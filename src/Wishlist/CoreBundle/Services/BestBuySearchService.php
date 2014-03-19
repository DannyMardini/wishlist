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
    
    protected function sendRequest($request, $raw)
    {
        
        $response = file_get_contents($request);
        $response = simplexml_load_string($response);
        /*
        if($response->Items->Request->IsValid != True) {
            throw new \Exception("Request was not valid");
        }
         * 
         */

        if(True === $raw)
        {
            return $response;
        }
        
        return $response;
//        return $this->responseToItems($response);
    }
}

?>
