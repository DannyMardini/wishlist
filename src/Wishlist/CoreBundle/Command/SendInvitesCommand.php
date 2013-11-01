<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendInvitesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wishenda:sendinvites')
            ->setDescription('Send invite email to multiple users')
            ->addArgument('N', InputArgument::REQUIRED, 'Number of users to send invite to');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $numUsers = $input->getArgument('N');
        $requestRepo = $this->getContainer()->get('doctrine')->getRepository('WishlistCoreBundle:Request');
        $mailer = $this->getContainer()->get('mailer_service');

        $query = $requestRepo->createQueryBuilder('r')->getQuery();

        $requests = $query->setMaxResults($numUsers)->getResult();

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

        $successMessage = 'Successfully sent '.$successCount.' email';
        if($successMessage > 1) {
            $successMessage .= 's.';
        }
        else {
            $successMessage .= '.';
        }

        $output->writeln($successMessage);
    }
}
