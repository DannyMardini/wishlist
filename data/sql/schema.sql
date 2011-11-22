CREATE TABLE friendships (name TEXT, friendship_id BIGINT AUTO_INCREMENT, PRIMARY KEY(friendship_id)) ENGINE = INNODB;
CREATE TABLE user_friendship (wishlistuser_id BIGINT, friendship_id BIGINT, PRIMARY KEY(wishlistuser_id, friendship_id)) ENGINE = INNODB;
CREATE TABLE wishlist_item (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, price BIGINT NOT NULL, is_public TINYINT(1) DEFAULT '1' NOT NULL, user_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE wishlist_user (name VARCHAR(255) NOT NULL, is_male TINYINT(1) DEFAULT '1', age BIGINT DEFAULT 18 NOT NULL, email VARCHAR(255) NOT NULL, wishlistuser_id BIGINT AUTO_INCREMENT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(wishlistuser_id)) ENGINE = INNODB;
ALTER TABLE user_friendship ADD CONSTRAINT user_friendship_wishlistuser_id_wishlist_user_wishlistuser_id FOREIGN KEY (wishlistuser_id) REFERENCES wishlist_user(wishlistuser_id);
ALTER TABLE user_friendship ADD CONSTRAINT user_friendship_friendship_id_friendships_friendship_id FOREIGN KEY (friendship_id) REFERENCES friendships(friendship_id);
ALTER TABLE wishlist_item ADD CONSTRAINT wishlist_item_user_id_wishlist_user_wishlistuser_id FOREIGN KEY (user_id) REFERENCES wishlist_user(wishlistuser_id) ON DELETE CASCADE;
