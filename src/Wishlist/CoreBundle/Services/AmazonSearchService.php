<?php

namespace Wishlist\CoreBundle\Services;

use Wishlist\CoreBundle\Entity\Item;

class AmazonSearchService extends VendorSearchService
{
    protected $accessId;
    protected $accessKey;
    const VERSION = "2011-08-01";
    const ResponseGroup = "ItemAttributes,Images";

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

    protected function createItemSearchRequest($keywords)
    {
        $params = 
             "&SearchIndex=All"
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
        $str = strtr( substr($request, strpos($request, "?")+1), array(',' => '%2C', ':' => '%3A', '+' => '%20', '(' => '%28', ')' => '%29') );
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
            
            //Image Set to use in case there is no primary image set
            if(isset($current->ImageSets) && isset($current->ImageSets->ImageSet)) {
                if(is_array($current->ImageSets->ImageSet)) {
                    $variantImageSet = $current->ImageSets->ImageSet[0];
                }
                else {
                    $variantImageSet = $current->ImageSets->ImageSet;
                }
            }
            
            if(isset($current->SmallImage) && isset($current->SmallImage->URL)) {
                $item->setSmallImage((string)$current->SmallImage->URL);
            }
            else if(isset($variantImageSet) && isset($variantImageSet->SmallImage)) {
                if(isset($variantImageSet->SmallImage->URL)) {
                    $item->setSmallImage((string)$variantImageSet->SmallImage->URL);
                }
            }
            
            if(isset($current->MediumImage) && isset($current->MediumImage->URL)) {
                $item->setMediumImage((string)$current->MediumImage->URL);
            }
            else if(isset($variantImageSet) && isset($variantImageSet->MediumImage)) {
                if(isset($variantImageSet->MediumImage->URL)) {
                    $item->setMediumImage((string)$variantImageSet->MediumImage->URL);
                }
            }
            
            if(isset($current->LargeImage) && isset($current->LargeImage->URL)) {
                $item->setLargeImage((string)$current->LargeImage->URL);
            }
            else if(isset($variantImageSet) && isset($variantImageSet->LargeImage)) {
                if(isset($variantImageSet->LargeImage->URL)) {
                    $item->setLargeImage((string)$variantImageSet->LargeImage->URL);
                }
            }
            
            $array[] = $item;
        }

        return $array;
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
