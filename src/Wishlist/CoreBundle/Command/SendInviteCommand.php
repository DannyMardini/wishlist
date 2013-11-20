<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendInviteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wishenda:sendinvite')
            ->setDescription('Send invite email to user who has requested an invite')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address of user to send invite');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $requestRepo = $this->getContainer()->get('doctrine')->getRepository('WishlistCoreBundle:Request');
        $templating = $this->getContainer()->get('templating');
        $mailer = $this->getContainer()->get('mailer_service');

        $request = $requestRepo->findOneByEmail($email);
        if(!$request)
        {
            $output->writeln('<error>Email '.$email.' was not found!</error>');
            return;
        }

        try {
            //Set Request context
            $context = $this->getContainer()->get('router')->getContext();
            $context->setHost('wishenda.com');
            $context->setScheme('http');

            $mailer->sendInvite($request);
        }
        catch(Exception $ex)
        {
            $output->writeln('<error>could not send mail</error>');
        }

        $output->writeln('Successfully sent email to '.$email);
    }
}
