<?php

namespace Wishlist\CoreBundle\Services;

abstract class VendorSearchService
{
    abstract protected function createItemSearchRequest($keywords);
    abstract protected function createItemLookupRequest($itemId);
    abstract protected function sendRequest($request, $raw);
    
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
}

?>
