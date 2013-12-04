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
        $numUsers = $input->getArgument('N');
        $requestRepo = $this->getContainer()->get('doctrine')->getRepository('WishlistCoreBundle:Request');
        $mailer = $this->getContainer()->get('mailer_service');

        $query = $requestRepo->createQueryBuilder('r')->where('r.dateLastInvited is NULL')->getQuery();

        $requests = $query->setMaxResults($numUsers)->getResult();
        
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
                $output->writeln('<error>could not send mail to '.$request->getEmail().'</error>');
            }
        }

        $successMessage = 'Successfully queued '.$successCount.' email';
        if($successMessage > 1) {
            $successMessage .= 's.';
        }
        else {
            $successMessage .= '.';
        }

        $output->writeln($successMessage);
    }
}
