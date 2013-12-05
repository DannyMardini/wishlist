<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ItemSearchCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wishenda:itemsearch')
            ->setDescription('Use the Amazon search API to send an item search')
            ->addArgument('index', InputArgument::REQUIRED, 'Search index')
            ->addArgument('keywords', InputArgument::REQUIRED, 'Search keywords');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $searchIndex = $input->getArgument('index');
        $keywords = $input->getArgument('keywords');
        $amazonService = $this->getContainer()->get('amazon_search_service');

        $response = $amazonService->itemSearch($searchIndex, $keywords);
        print_r($response);
        //$output->writeln($response);
    }
}
