<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ItemLookupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wishenda:itemlookup')
            ->setDescription('Use the Amazon search API to send an item lookup')
            ->addArgument('asin', InputArgument::REQUIRED, 'Amazon Search Item Number');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $vendorId = $input->getArgument('asin');
        $amazonService = $this->getContainer()->get('amazon_search_service');

        $response = $amazonService->itemLookup($vendorId, True);

        print_r($response);
    }
}
