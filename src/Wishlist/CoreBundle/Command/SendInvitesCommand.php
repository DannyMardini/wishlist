<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class SendInvitesCommand extends ContainerAwareCommand
{    
    protected function configure()
    {
        $this
            ->setName('wishenda:sendinvites')
            ->setDescription('Add multiple emails to the queue to be sent to users')
            ->addArgument('N', InputArgument::REQUIRED, 'Number of users to send invite to');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $max_users_allowed = $this->getContainer()->getParameter('maximum_total_users_allowed');
        $num_users_to_invite = $input->getArgument('N');
        $userRepo = $doctrine->getRepository('WishlistCoreBundle:WishlistUser');
        $current_user_count = $userRepo->getTotalUserCount();
        
        if($max_users_allowed < ($num_users_to_invite + $current_user_count))
        {
            $output->writeln("Could not complete request. Maximum number of users has been reached.");
            return;
        }

        $requestRepo = $doctrine->getRepository('WishlistCoreBundle:Request');
        $mailer = $this->getContainer()->get('mailer_service');

        $query = $requestRepo->createQueryBuilder('r')->where('r.dateLastInvited is NULL')->getQuery();

        $requests = $query->setMaxResults($num_users_to_invite)->getResult();
        
        //Set Request context
        $context = $this->getContainer()->get('router')->getContext();
        $context->setHost('wishenda.com');
        $context->setScheme('http');

        $successCount = 0;
        foreach ($requests as $request)
        {
            try {
                $mailer->sendInvite($request);
                $successCount++;
            }
            catch(Exception $ex)
            {
                $output->writeln('<error>could not send mail to '.$request->getEmail().'</error> ');
            }
        }

        $successMessage = 'Successfully queued '.$successCount.' email' . ($successCount > 1 ? 's.' : '.');
        $output->writeln($successMessage);
    }
}
