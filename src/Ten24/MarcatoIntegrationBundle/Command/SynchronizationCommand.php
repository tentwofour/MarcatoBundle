<?php

namespace Ten24\MarcatoIntegrationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizationCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ten24:marcato:synchronize')
            ->addOption('artists', null, InputOption::VALUE_NONE, 'Synchronize only the artists feed')
            ->addOption('contacts', null, InputOption::VALUE_NONE, 'Synchronize only the contacts feed')
            ->addOption('shows', null, InputOption::VALUE_NONE, 'Synchronize only the shows feed')
            ->addOption('venues', null, InputOption::VALUE_NONE, 'Synchronize only the venues feed')
            ->addOption('workshops', null, InputOption::VALUE_NONE, 'Synchronize only the workshops feed')
            ->setDescription('Synchronizes Marcato data based on the configured organization id')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command synchronizes Marcato data.

By default, all XML feeds are downloaded, parsed into associative arrays
using Symfony's Serializer component, and saved to the application's
cache directory (%kernel.cache_dir%) using Doctrine\Common\Cache\PHPFileCache.

You can choose to only synchronize particular feeds using the options provided.
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $enabled = $this->getContainer()->getParameter('ten24_marcato_integration.enabled');

        if (!$enabled)
        {
            $output->writeln(<<<EOF
This command is not available - please enable the bundle in config.yml:

# app/config/config.yml
ten24_marcato_integration:
    enabled: true
EOF
            );
        }

        $synchronizer = $this->getContainer()->get('ten24_marcato_integration.synchronizer');


        if (count($input->getArguments()) == 0)
        {
            $output->writeln('Synchronizing all Marcato data');
            $synchronizer->synchronizeAll();
        }
        else
        {
            if ($input->getOption('artists'))
            {
                $output->writeln('Synchronizing Artist Marcato data');
                $synchronizer->synchronizeArtists();
            }

            if ($input->getOption('contacts'))
            {
                $output->writeln('Synchronizing Contact Marcato data');
                $synchronizer->synchronizeContacts();
            }

            if ($input->getOption('shows'))
            {
                $output->writeln('Synchronizing Show Marcato data');
                $synchronizer->synchronizeShows();
            }

            if ($input->getOption('venues'))
            {
                $output->writeln('Synchronizing Venue Marcato data');
                $synchronizer->synchronizeVenues();
            }

            if ($input->getOption('workshops'))
            {
                $output->writeln('Synchronizing Workshop Marcato data');
                $synchronizer->synchronizeWorkshops();
            }
        }
    }
}