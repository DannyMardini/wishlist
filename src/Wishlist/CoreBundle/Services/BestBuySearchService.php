<?php

namespace Wishlist\CoreBundle\Services;
use Wishlist\CoreBundle\Entity\Item;

class BestBuySearchService extends VendorSearchService
{
    const PAGE_SIZE = 100;
    protected $apiKey;
    
    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    
    protected function createItemSearchRequest($keywords)
    {
        $request = "http://api.remix.bestbuy.com/v1/products(";
        
        $request .= "name=".(string)str_replace("+", "%20", $keywords);
                
                
        $request .= "*)?page=1&pageSize=".BestBuySearchService::PAGE_SIZE
                ."&sort=customerReviewCount.desc,customerReviewAverage.desc"
                ."&apiKey=".$this->apiKey;
        
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
        if(!isset($response->product))
        {
            return False;
        }
        return True;
    }
    
    protected function responseToItems($response)
    {
        //todo: implement this function
        $array = array();
        foreach($response->product as $current) {

            if( !isset($current->name) || 
                !isset($current->regularPrice) || 
                !isset($current->url) || 
                !isset($current->productId) ) 
            {
                //If any of the required info is not present skip this item.
                continue;
            }

            $item = new Item();
            $item->setName((string)$current->name);
            $item->setPrice(intval((string)$current->regularPrice), Item::CURRENCY_UNIT_DOLLAR);
            $item->setLink((string)$current->url);
            $item->setvendorId((string)$current->productId);
            
            if(isset($current->thumbnailImage))
            {
                $item->setSmallImage((string)$current->thumbnailImage);
            }
            
            if(isset($current->image))
            {
                $item->setMediumImage((string)$current->image);
            }
                        
            $array[] = $item;
        }

        return $array;

    }
}

?>
