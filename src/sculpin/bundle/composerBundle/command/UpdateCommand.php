<?php

/*
 * This file is a part of Sculpin
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sculpin\bundle\composerBundle\command;

use Composer\Command\UpdateCommand as BaseUpdateCommand;
use Composer\Factory;
use Composer\IO\ConsoleIO;
use Composer\Json\JsonFile;
use Composer\Package\LinkConstraint\VersionConstraint;
use Composer\Repository\FilesystemRepository;
use Composer\Script\EventDispatcher;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends BaseUpdateCommand
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('composer:update')
            ->setDescription('Updates dependencies. (bundles)')
            ->setHelp(<<<EOT
The <info>composer:update</info> command reads dependencies defined in composer.json in
the Sculpin project's root and installs and updates dependencies for the project.
EOT
            )
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $installCommand = $this->getApplication()->find('composer:install');
        $io = new ConsoleIO($input, $output, $this->getApplication()->getHelperSet());
        $composer = Factory::create($io);
        $eventDispatcher = new EventDispatcher($composer, $io);
        if ($this->getApplication()->internallyInstalledRepositoryEnabled()) {
            $internalRepositoryFile = $this->getApplication()->internalVendorRoot().'/.composer/installed.json';
            $filesystemRepository = new FilesystemRepository(new JsonFile($internalRepositoryFile));
        } else {
            $filesystemRepository = null;
        }
        return $installCommand->install(
            $io,
            $composer,
            $eventDispatcher,
            (Boolean)$input->getOption('prefer-source'),
            (Boolean)$input->getOption('dry-run'),
            (Boolean)$input->getOption('verbose'),
            (Boolean)$input->getOption('no-install-recommends'),
            (Boolean)$input->getOption('install-suggests'),
            true,
            $filesystemRepository //->getPackages()
        );
    }
}
