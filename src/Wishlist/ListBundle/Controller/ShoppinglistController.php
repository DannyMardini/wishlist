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
                $purchaseRepo->deletePurchases($retractPurchases, PurchaseEventTypes::RemovedFromShoppingList);
            }
        }
        catch(Exception $e)
        {
           return new Response($e->getMessage());    
        }
        
        return new Response($message);
    }
    
    public function shoppinglistAction(/*int*/ $userId)
    {
        $purchaseRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Purchase');
        $purchases = $purchaseRepo->getPurchasesById($userId);
        $completePurchases = $purchaseRepo->getCompletePurchases($userId);
        
        return $this->render('WishlistListBundle:Default:shoppinglist.html.php', array('purchases' => $purchases, 'completePurchases' => $completePurchases));
    }
}
?>
