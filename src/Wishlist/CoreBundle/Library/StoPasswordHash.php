<?php

namespace Wishlist\CoreBundle\Library;

use \Exception;

class StoPasswordHash
{
  /**
   * Generates a bcrypt hash of a password, which can be stored in a database.
   * @param string $password Password whose hash-value we need.
   * @param int $cost Controls the number of iterations. Increasing the cost
   *   by 1, doubles the needed calculation time. Must be in the range of 4-31.
   * @param string $serverSideKey This key acts similar to a pepper, but
   *   can be exchanged when necessary. In certain situations, encrypting
   *   the hash-value can protect weak passwords from a dictionary attack.
   * @return string Hash-value of the password. A random salt is included.
   *   Without passing a $serverSideKey the result has a length of 60
   *   characters, with a $serverSideKey the length is 108 characters.
   */
  public static function hashBcrypt($password, $cost=10, $serverSideKey='')
  {
    if (!defined('CRYPT_BLOWFISH')) throw new Exception('The CRYPT_BLOWFISH algorithm is required (PHP 5.3).');
    if (is_null($password) || $password === '') throw new InvalidArgumentException('Cannot hash an empty password.');
    if ($cost < 4 || $cost > 31) throw new InvalidArgumentException('The cost factor must be a number between 4 and 31');

    if (version_compare(PHP_VERSION, '5.3.7') >= 0)
      $algorithm = '2y'; // BCrypt, with fixed unicode problem
    else
      $algorithm = '2a'; // BCrypt

    // BCrypt expects nearly the same alphabet as base64_encode returns,
    // but instead of the '+' characters it accepts '.' characters.
    // BCrypt alphabet: ./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
    $salt = str_replace('+', '.', StoPasswordHash::generateRandomBase64String(22));

    // Create crypt parameters: $algorithm$cost$salt
    $cryptParams = sprintf('$%s$%02d$%s', $algorithm, $cost, $salt);
    $hash = crypt($password, $cryptParams);

    // Encrypt hash with the server side key
    if ($serverSideKey != '')
    {
      $encryptedHash = StoPasswordHash::encryptTwofish($hash, $serverSideKey);
      $hash = base64_encode($encryptedHash);
    }
    return $hash;
  }

  /**
   * Checks, if the password matches a given hash value. This is useful when
   * a user enters his password for login, to check if the password corresponds
   * to the hash stored in the database.
   * @param string $password Password to check.
   * @param string $existingHash Stored hash-value from the database.
   * @param string $serverSideKey Pass the same key that was used to encrypt
   *   $existingHash, or omit this parameter if no key was used.
   * @return bool Returns true, if the password matches the hash,
   *   otherwise false.
   */
  public static function verifyPassword($password, $existingHash, $serverSideKey='')
  {
    if (!defined('CRYPT_BLOWFISH')) throw new Exception('The CRYPT_BLOWFISH algorithm is required (PHP 5.3).');
    if (is_null($password) || $password === '') return false;

    // Decrypt hash with the server side key
    if ($serverSideKey != '')
    {
      $encryptedHash = base64_decode($existingHash);
      $existingHash = StoPasswordHash::decryptTwofish($encryptedHash, $serverSideKey);
    }

    // The parameters that where used to generate $existingHash, will be
    // extracted automatically from the first 29 characters of $existingHash.
    $newHash = crypt($password, $existingHash);
    return $newHash === $existingHash;
  }

  /**
   * Generates a random string of a given length, using the random source of
   * the operating system. The string contains only characters of this
   * alphabet: +/0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz
   * @param int $length Number of characters the string should have.
   * @return string A random base64 encoded string.
   */
  protected static function generateRandomBase64String($length)
  {
    if (!defined('MCRYPT_DEV_URANDOM')) throw new Exception('The MCRYPT_DEV_URANDOM source is required (PHP 5.3).');

    // Generate random bytes, using the operating system's random source.
    // Since PHP 5.3 this also uses the random source on a Windows server.
    // Unlike /dev/random, the /dev/urandom does not block the server, if
    // there is not enough entropy available.
    $binaryLength = (int)($length * 3 / 4 + 1);
    $randomBinaryString = mcrypt_create_iv($binaryLength, MCRYPT_DEV_URANDOM);
    $randomBase64String = base64_encode($randomBinaryString);
    return substr($randomBase64String, 0, $length);
  }

  /**
   * Encrypts data with the TWOFISH algorithm. The IV vector will be
   * included in the resulting binary string.
   * @param string $data Data to encrypt. Trailing \0 characters will get lost.
   * @param string $key This key will be used to encrypt the data. The key
   *   will be hashed to a binary representation before it is used.
   * @return string Returns the encrypted data in form of a binary string.
   */
  public static function encryptTwofish($data, $key)
  {
    if (!defined('MCRYPT_DEV_URANDOM')) throw new Exception('The MCRYPT_DEV_URANDOM source is required (PHP 5.3).');
    if (!defined('MCRYPT_TWOFISH')) throw new Exception('The MCRYPT_TWOFISH algorithm is required (PHP 5.3).');

    // The cbc mode is preferable over the ecb mode
    $td = mcrypt_module_open(MCRYPT_TWOFISH, '', MCRYPT_MODE_CBC, '');

    // Twofish accepts a key of 32 bytes. Because usually longer strings
    // with only readable characters are passed, we build a binary string.
    $binaryKey = hash('sha256', $key, true);

    // Create initialization vector of 16 bytes
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);

    mcrypt_generic_init($td, $binaryKey, $iv);
    $encryptedData = mcrypt_generic($td, $data);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);

    // Combine iv and encrypted text
    return $iv . $encryptedData;
  }

  /**
   * Decrypts data, formerly encrypted with @see encryptTwofish.
   * @param string $encryptedData Binary string with encrypted data.
   * @param string $key This key will be used to decrypt the data.
   * @return string Returns the original decrypted data.
   */
  public static function decryptTwofish($encryptedData, $key)
  {
    if (!defined('MCRYPT_TWOFISH')) throw new Exception('The MCRYPT_TWOFISH algorithm is required (PHP 5.3).');

    $td = mcrypt_module_open(MCRYPT_TWOFISH, '', MCRYPT_MODE_CBC, '');

    // Extract initialization vector from encrypted data
    $ivSize = mcrypt_enc_get_iv_size($td);
    $iv = substr($encryptedData, 0, $ivSize);
    $encryptedData = substr($encryptedData, $ivSize);

    $binaryKey = hash('sha256', $key, true);

    mcrypt_generic_init($td, $binaryKey, $iv);
    $decryptedData = mdecrypt_generic($td, $encryptedData);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);

    // Original data was padded with 0-characters to block-size
    return rtrim($decryptedData, "\0");
  }
}
?>
