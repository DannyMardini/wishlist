<?php

namespace Wishlist\CoreBundle\Services;

abstract class VendorSearchService
{
    //Different vendors available
    const VENDOR_BESTBUY = "2";
    const VENDOR_AMAZON  = "1";
    
    abstract protected function createItemSearchRequest($keywords);
    abstract protected function createItemLookupRequest($itemId);
    abstract protected function isResponseValid($response);
    abstract protected function responseToItems($response);
    
    public function itemSearch($keywords, $raw=False)
    {
        $request = $this->createItemSearchRequest($keywords);
        return $this->sendRequest($request, $raw);
    }

    public function itemLookup($itemId, $raw=False)
    {
        $request = $this->createItemLookupRequest($itemId);
        return $this->sendRequest($request, $raw);
    }
    
    protected function sendRequest($request, $raw=False)
    {
        $response = file_get_contents($request);
        $response = simplexml_load_string($response);
        
        if($this->isResponseValid($response) != True) {
            //return empty results of reponse is not valid.
            return array();
        }

        if(True === $raw)
        {
            return $response;
        }
        
        //return $response;
        return $this->responseToItems($response);
    }
}

?>
