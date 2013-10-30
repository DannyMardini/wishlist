<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AcceptUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wishenda:acceptuser')
            ->setDescription('Accept a user who has requested an invite')
            ->addArgument('email', InputArgument::REQUIRED, 'Email address of user to accept');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $requestRepo = $this->getContainer()->get('doctrine')->getRepository('WishlistCoreBundle:Request');

        $request = $requestRepo->findOneByEmail($email);
        if(!$request)
        {
            $output->writeln('<error>Email '.$email.' was not found!</error>');
            return;
        }

        $output->writeln('This is where we would invite '.$request->getId());
        //Get the email sending service and send the accept email to the user.
    }
}
