<?php
namespace Wishlist\ListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Wishlist\CoreBundle\Entity\PurchaseEventTypes;

class ShoppinglistController extends Controller
{
    public function retractPurchasesAction()
    {
        $request = $this->getRequest()->request;
        $purchaseRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Purchase');
        $retractPurchases = $request->get('purchaseIds');
        $message = "";
        
        if(isset($retractPurchases))
        {            
            $message = $purchaseRepo->deletePurchases($retractPurchases, PurchaseEventTypes::RemovedFromShoppingList);
        }
        
        return new Response($message);
    }
    
    public function shoppinglistAction(/*int*/ $userId)
    {
        $purchaseRepo = $this->getDoctrine()->getRepository('WishlistCoreBundle:Purchase');
        $purchases = $purchaseRepo->getPurchasesById($userId);
        
        return $this->render('WishlistListBundle:Default:shoppinglist.html.php', array('purchases' => $purchases));        
    }
}
?>
