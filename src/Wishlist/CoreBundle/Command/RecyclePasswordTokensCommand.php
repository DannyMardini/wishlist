<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecyclePasswordTokensCommand extends ContainerAwareCommand {
    
    protected function configure()
    {
        $this
            ->setName('wishenda:recycle-password-tokens')
            ->setDescription('Remove the reset password tokens that are pending in the queue over 24 hours.');            
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {        
        $requestRepo = $this->getContainer()->get('doctrine')->getRepository('WishlistCoreBundle:Token');
        $tokensUpdated = $requestRepo->recycleOverdueTokens();
        $output->writeln('Successfully recycled '. $tokensUpdated.' overdue "reset password" tokens.');
    }    
}

?>
