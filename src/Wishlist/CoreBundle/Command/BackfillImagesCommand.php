<?php

namespace Wishlist\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BackfillImagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('wishenda:backfillImages')
            ->setDescription('Backfill all of the images for amazon items.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemRepo = $this->getContainer()->get('doctrine')->getRepository('WishlistCoreBundle:Item');
        $amazonService = $this->getContainer()->get('amazon_search_service');
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $countSuccess = 0;
        
        $items = $itemRepo->getItemsMissingImages();
        $count = count($items);
        
        foreach ($items as $item)
        {
            $name = $item->getName();
            $aitems = $amazonService->itemSearch("All", strtr($item->getName(), array(' ' => '+', '/' => '+')));
            foreach ($aitems as $aitem)
            {
                if ($aitem->getName() == $name) {
                    $countSuccess++;
                    $item->setSmallImage($aitem->getSmallImage());
                    break;
                }
            }
            
            $em->persist($item);
        }
        
        $em->flush();
        $output->writeln($countSuccess." out of ".$count." images backfilled!");
    }
}
