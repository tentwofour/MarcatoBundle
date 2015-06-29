<?php

namespace Ten24\MarcatoIntegrationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class SynchronizationCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('ten24:marcato:sync')
            ->addOption('artists', null, InputOption::VALUE_NONE, 'Synchronize only the artists feed')
            ->addOption('contacts', null, InputOption::VALUE_NONE, 'Synchronize only the contacts feed')
            ->addOption('shows', null, InputOption::VALUE_NONE, 'Synchronize only the shows feed')
            ->addOption('venues', null, InputOption::VALUE_NONE, 'Synchronize only the venues feed')
            ->addOption('workshops', null, InputOption::VALUE_NONE, 'Synchronize only the workshops feed')
            ->addOption('clear-cache', null, InputOption::VALUE_NONE, 'Also clear and warm the application cache')
            ->setDescription('Synchronizes Marcato data based on the configured organization id, optionally clearing the application cache (for cached templates).')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command synchronizes Marcato data.

All XML feeds are downloaded, parsed with JMS Serializer, and inserted/replaced into your database.

You can choose to only synchronize particular feeds using the options provided.

You may also want to clear and warm the cache using the --clear-cache option, if your view layer caches any of the Marcato data.

EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input,
                               OutputInterface $output)
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

            exit(1);
        }

        $feedsConfiguration = $this->getContainer()->getParameter('ten24_marcato_integration.feeds.configuration');
        $organizationId     = $this->getContainer()->getParameter('ten24_marcato_integration.organization_id');
        $synchronizer       = $this->getContainer()->get('ten24_marcato_integration.synchronizer');

        $output->writeln('Synchronizing Marcato data for organziation id: <info>' . $organizationId . '</info>');

        ProgressBar::setFormatDefinition('skipped',
                                         '[ %feedname% ] Skipped; specify the --%command_option% to synchronize this feed.');
        ProgressBar::setFormatDefinition('not_configured',
                                         '[ %feedname% ] Skipped; not enabled in your configuration.');
        $progressBar = new ProgressBar($output, 6);
        $progressBar->setMessage('Starting Synchronization', 'feedname');
        $progressBar->setFormatDefinition('default', "[ %feedname% ] [%bar%] %elapsed:6s% %memory:6s%");
        $progressBar->setFormat('default');
        $progressBar->start();

        $optionsAreEmpty = (false === $input->getOption('artists') &&
                            false === $input->getOption('contacts') &&
                            false === $input->getOption('shows') &&
                            false === $input->getOption('venues') &&
                            false === $input->getOption('workshops'));

        $progressBar->setMessage('Artists', 'feedname');

        if (!$optionsAreEmpty && false === $input->getOption('artists'))
        {
            $progressBar->setMessage('artists', 'command_option');
            $progressBar->setFormat('skipped');
        }
        elseif ($optionsAreEmpty || true === $input->hasOption('artists'))
        {
            if (!$feedsConfiguration['artists'])
            {
                $progressBar->setFormat('not_configured');
            }
            else
            {
                $synchronizer->synchronizeArtists();
            }
        }

        $progressBar->advance();
        $progressBar->setFormat('default');
        $progressBar->setMessage('Contacts', 'feedname');

        if (!$optionsAreEmpty && false === $input->getOption('contacts'))
        {
            $progressBar->setMessage('contacts', 'command_option');
            $progressBar->setFormat('skipped');
        }
        elseif ($optionsAreEmpty || false !== $input->hasOption('contacts'))
        {
            if (!$feedsConfiguration['contacts'])
            {
                $progressBar->setFormat('not_configured');
            }
            else
            {
                $synchronizer->synchronizeContacts();
            }
        }

        $progressBar->advance();
        $progressBar->setFormat('default');
        $progressBar->setMessage('Shows', 'feedname');

        if (!$optionsAreEmpty && false === $input->getOption('shows'))
        {
            $progressBar->setMessage('shows', 'command_option');
            $progressBar->setFormat('skipped');
        }
        elseif ($optionsAreEmpty || false !== $input->hasOption('shows'))
        {
            if (!$feedsConfiguration['shows'])
            {
                $progressBar->setFormat('not_configured');
            }
            else
            {
                $synchronizer->synchronizeShows();
            }
        }

        $progressBar->advance();
        $progressBar->setFormat('default');
        $progressBar->setMessage('Venues', 'feedname');

        if (!$optionsAreEmpty && false === $input->getOption('venues'))
        {
            $progressBar->setMessage('venues', 'command_option');
            $progressBar->setFormat('skipped');
        }
        elseif ($optionsAreEmpty || false !== $input->hasOption('venues'))
        {
            if (!$feedsConfiguration['venues'])
            {
                $progressBar->setFormat('not_configured');
            }
            else
            {
                $synchronizer->synchronizeVenues();
            }
        }

        $progressBar->advance();
        $progressBar->setFormat('default');
        $progressBar->setMessage('Workshops', 'feedname');

        if (!$optionsAreEmpty && false === $input->getOption('workshops'))
        {
            $progressBar->setMessage('workshops', 'command_option');
            $progressBar->setFormat('skipped');
        }
        elseif ($optionsAreEmpty || false !== $input->hasOption('workshops'))
        {
            if (!$feedsConfiguration['workshops'])
            {
                $progressBar->setFormat('not_configured');
            }
            else
            {
                $synchronizer->synchronizeWorkshops();
            }
        }

        $progressBar->advance();
        $progressBar->setFormat('default');


        if ($input->getOption('clear-cache'))
        {
            $progressBar->setMessage('Clearing Cache', 'feedname');
            $progressBar->display();

            $env       = $this->getContainer()->getParameter('kernel.environment');
            $subInput  = new ArgvInput(['--env=' . $env]);
            $subOutput = new NullOutput();
            $this->getContainer()->get('ten24_marcato_integration.command.cache.clear')->run($subInput, $subOutput);
        }

        $progressBar->advance();
        $progressBar->setFormat('default');
        $progressBar->setMessage('Sync Complete', 'feedname');
        $progressBar->finish();
        $output->writeln("\n");
    }
}