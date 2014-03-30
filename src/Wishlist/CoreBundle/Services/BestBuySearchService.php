<?php

namespace Wishlist\CoreBundle\Services;

class BestBuySearchService extends VendorSearchService
{
    protected $apiKey;
    
    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    
    protected function createItemSearchRequest($keywords)
    {
        $request = "http://api.remix.bestbuy.com/v1/products"
            ."(name=".strtr( $keywords, array('+' => '%20') )."*)?"
            ."apiKey=".$this->apiKey;
        return $request;
    }
    
    protected function createItemLookupRequest($itemId)
    {
        $request = "http://api.remix.bestbuy.com/v1/products/"
            .$itemId. ".xml?"
            . "apiKey=".$this->apiKey;
        return $request;
    }
    
    protected function isResponseValid($response)
    {
        //todo: implement this function
        return True;
    }
    
    protected function responseToItems($response)
    {
        //todo: implement this function
        return $response;
    }
}

?>
