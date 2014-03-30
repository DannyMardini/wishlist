<?php

namespace Wishlist\CoreBundle\Services;

abstract class VendorSearchService
{
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

?>
