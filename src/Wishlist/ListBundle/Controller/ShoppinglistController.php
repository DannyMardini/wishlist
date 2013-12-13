<?php
namespace Wishlist\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Wishlist\CoreBundle\Entity\PurchaseEventTypes;
use \Exception;

class ShoppinglistController extends Controller
{
    public function retractPurchasesAction()
    {
        $request = $this->getRequest()->request;
        $purchaseRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Purchase');
        $retractPurchases = $request->get('purchaseIds');
        $message = "";
        
        try{
            if(isset($retractPurchases))
            {            
                $purchaseRepo->deletePurchases($retractPurchases);
                // TO DO send email with this message: PurchaseEventTypes::RemovedFromShoppingList);
            }
        }
        catch(Exception $e)
        {
           return new Response($e->getMessage());    
        }
        
        return new Response($message);
    }

    public function completeShoppingListItemsAction()
    {
        $request = $this->getRequest()->request;
        $purchaseRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Purchase');

        try
        {
            $completedIds = $request->get('expiredPurchases');
            if(!isset($completedIds))
            {
                throw new \Exception();
            }
            $purchases = $purchaseRepo->getPurchases($completedIds);
            $purchaseRepo->completePurchases($purchases);
        }
        catch(\Exception $e)
        {
            return new Response('failure');
        }
        return new Response('success');
    }
    
    public function shoppinglistAction(/*int*/ $userId)
    {
        $purchaseRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Purchase');
        $purchases = $purchaseRepo->getPurchasesById($userId);
        $expiredPurchases = $purchaseRepo->getExpiredPurchases($userId);
        
        return $this->render('WishlistListBundle:Default:shoppinglist.html.php', array('purchases' => $purchases, 'expiredPurchases' => $expiredPurchases));
    }
}
?>
