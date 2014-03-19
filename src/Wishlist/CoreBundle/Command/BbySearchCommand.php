<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BbySearchCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wishenda:bbysearch')
            ->setDescription('Use the Best Buy API to send an item search')
            ->addArgument('keywords', InputArgument::REQUIRED, 'Search keywords')
            ->addArgument('raw', InputArgument::OPTIONAL, 'set to \'raw\' to receive raw response from Best Buy');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $keywords = $input->getArgument('keywords');
        $raw = $input->getArgument('raw');
        
        if($raw === 'raw') {
            $raw = True;
        }
        else {
            $raw = False;
        }
        
        $bestbuyService = $this->getContainer()->get('bestbuy_search_service');

        $response = $bestbuyService->itemSearch($keywords, $raw);

        print_r($response);
    }
}
