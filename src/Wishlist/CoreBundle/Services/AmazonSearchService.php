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
    
    protected function createRequestBase($operation, $params)
    {
        $request=
             "http://webservices.amazon.com/onca/xml"
           . "?Service=AWSECommerceService"
           . "&AssociateTag=" . $this->associateTag
           . "&AWSAccessKeyId=" . $this->accessId
           . "&Operation=" . $operation
           . "&Version=" . AmazonSearchService::VERSION
           . "&ResponseGroup=" . AmazonSearchService::ResponseGroup
           . "&Timestamp=" . gmdate("Y-m-d\TH:i:s\Z")
           . $params;

        $strToSign = $this->createStringToSign($request);
        $request .= "&Signature=" . strtr( base64_encode(hash_hmac("sha256", $strToSign, $this->accessKey, true)), array('+' => '%2B', '=' => '%3D') );

        return $request;
    }

    protected function createItemSearchRequest($searchIndex, $keywords)
    {
        $params = 
             "&SearchIndex=" . $searchIndex
           . "&Keywords=" . strtr( $keywords, array('+' => '%20') );

        return $this->createRequestBase("ItemSearch", $params);
    }

    protected function createItemLookupRequest($asin)
    {
        $params = "&ItemId=" . $asin;

        return $this->createRequestBase("ItemLookup", $params);
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
                !isset($current->DetailPageURL) || 
                !isset($current->ASIN) ) 
            {
                //If any of the required info is not present skip this item.
                continue;
            }

            $item = new Item();
            $item->setName((string)$current->ItemAttributes->Title);
            $item->setPrice(intval((string)$current->ItemAttributes->ListPrice->Amount), Item::CURRENCY_UNIT_CENT);
            $item->setLink((string)$current->DetailPageURL);
            $item->setAsin((string)$current->ASIN);
            $array[] = $item;
        }

        return $array;
    }

    public function itemSearch($searchIndex, $keywords, $raw=false)
    {
        $request = $this->createItemSearchRequest($searchIndex, $keywords);
        return $this->sendRequest($request, $raw);
    }

    public function itemLookup($asin)
    {
        $request = $this->createItemLookupRequest($asin);
        return $this->sendRequest($request);
    }

    protected function sendRequest($request, $raw=False)
    {
        $response = file_get_contents($request);
        $response = simplexml_load_string($response);
        if($response->Items->Request->IsValid != True) {
            throw new \Exception("Request was not valid");
        }

        if(True === $raw)
        {
            return $response;
        }
        
        //return $response;
        return $this->responseToItems($response);
    }
}
