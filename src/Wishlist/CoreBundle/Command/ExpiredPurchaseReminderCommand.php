<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExpiredPurchaseReminderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('wishenda:expiredPurchaseReminder')
            ->setDescription('Remind users about their expired purchase items. They are given the option of check those items off their list');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // get the total count of users who have past due shopping list items
        
        // loop through each of those users and send each one a notification
        
        // print out the number of successful notifications out of the total        
        $doctrine = $this->getContainer()->get('doctrine');        
        $purchaseRepo = $doctrine->getRepository('WishlistCoreBundle:Purchase');        
        $mailer = $this->getContainer()->get('mailer_service');        
        $exp_users = $purchaseRepo->getUsersWithExpiredPurchases();        
        $successCount = 0;
        $numUsers = 0;
        
        if(isset($exp_users))
        {            
            $numUsers = count($exp_users);
            foreach($exp_users as $u)
            {
                // for each user, send him/her an email with a link to the wishenda homepage
                // and a message saying that they should view their shopping list to confirm 
                // that they have purchased the items they promised to get.
                try {
                    $success = $mailer->sendExpiredPurchaseReminder($u);
                    if($success){ 
                        $successCount++;
                    }
                }
                catch(Exception $ex){
                    $output->writeln('<error>could not send mail to '.$u->getEmail().'</error> ');                    
                }               
            }
        }
        
        $successMessage = 'Successfully emailed '.$successCount.' users, out of '.$numUsers;
        $output->writeln($successMessage);
    }
}
