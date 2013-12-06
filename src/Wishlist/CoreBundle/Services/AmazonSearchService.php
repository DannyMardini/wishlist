<?php

namespace Wishlist\CoreBundle\Services;

use Wishlist\CoreBundle\Entity\Item;

class AmazonSearchService
{
    protected $accessId;
    protected $accessKey;
    const VERSION = "2011-08-01";
    const ResponseGroup = "ItemAttributes";

    function __construct($accessId, $accessKey, $associateTag)
    {
        $this->accessId = $accessId;
        $this->accessKey = $accessKey;
        $this->associateTag = $associateTag;
    }
    
    protected function createRequest($operation, $searchIndex, $keywords)
    {
        $request=
             "http://webservices.amazon.com/onca/xml"
           . "?Service=AWSECommerceService"
           . "&AssociateTag=" . $this->associateTag
           . "&AWSAccessKeyId=" . $this->accessId
           . "&Operation=" . $operation
           . "&Version=" . AmazonSearchService::VERSION
           . "&SearchIndex=" . $searchIndex
           . "&Keywords=" . strtr( $keywords, array('+' => '%20') )
           . "&ResponseGroup=" . AmazonSearchService::ResponseGroup
           . "&Timestamp=" . gmdate("Y-m-d\TH:i:s\Z");

        $strToSign = $this->createStringToSign($request);
        $request .= "&Signature=" . strtr( base64_encode(hash_hmac("sha256", $strToSign, $this->accessKey, true)), array('+' => '%2B', '=' => '%3D') );

        return $request;
    }
    
    protected function CreateStringToSign($request) 
    {
        $str = strtr( substr($request, strpos($request, "?")+1), array(',' => '%2C', ':' => '%3A', '+' => '%20') );
        $params = explode("&", $str);
        natsort($params);

        $str = "GET\nwebservices.amazon.com\n/onca/xml\n";
        foreach ($params as $param) {
            $str .= $param."&";
        }

        return rtrim($str, '&');
    }

    protected function responseToItems($response)
    {
        $array = array();
        foreach($response->Items->Item as $current) {

            if( !isset($current->ItemAttributes->Title) || 
                !isset($current->ItemAttributes->ListPrice->Amount) || 
                !isset($current->DetailPageURL) ) 
            {
                //If any of the required info is not present skip this item.
                continue;
            }

            $item = new Item();
            $item->setName((string)$current->ItemAttributes->Title);
            $item->setPrice(intval((string)$current->ItemAttributes->ListPrice->Amount));
            $item->setLink((string)$current->DetailPageURL);
            $array[] = $item;
        }

        return $array;
    }

    public function itemSearch($searchIndex, $keywords)
    {
        $request = $this->createRequest( "ItemSearch", $searchIndex, $keywords);
        $response = file_get_contents($request);
        $response = simplexml_load_string($response);
        if($response->Items->Request->IsValid != True) {
            throw new \Exception("Request was not valid");
        }

        //return $response;
        return $this->responseToItems($response);
    }
}
