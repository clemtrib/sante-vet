<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Description of CreateArticleCommand
 *
 * @author Clément
 */
class CreateProductCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
            ->setName('app:create-product')
            ->setDescription('Import a new products list from leboncoin.fr.')
            ->setHelp('Import a new products list from leboncoin.fr')
            ->addArgument('region', InputArgument::REQUIRED, 'The region is requiered. Ex: rhone-alpes')
            ->addArgument('category', InputArgument::REQUIRED, 'The category is requiered. Ex: animaux')
            ->addArgument('limit', InputArgument::REQUIRED, 'The limit is requiered. Ex: 100');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln([
            '============================================',
            'Import a new products list from leboncoin.fr',
            '============================================',
            '',
        ]);
        
        $container = $this->getApplication()->getKernel()->getContainer();
        
        //
        $service = $container->get('app.leboncoin');
        $service->getProductEntities(
                $input->getArgument('region'),
                $input->getArgument('category'), 
                $input->getArgument('limit')
        );
        $service->setProductEntities();
        
        //
        return $output->writeln([
            '',
            'Done!',
            '',
        ]);
        
        
    }

}
