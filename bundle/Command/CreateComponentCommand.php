<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesignBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class CreateComponentCommand extends Command
{
    protected static $defaultName = 'static_fake_design:component:create';

    public function __construct(
        protected Filesystem $filesystem
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to the component template');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the component');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $path = $input->getArgument('path');
        $name = $input->getArgument('name');
        $content = sprintf(
            "{%% component {
    name: '%s',
    description: '',
    specifications: '',
    parameters: {
    }
} %%}
",
            $name
        );

        $this->filesystem->dumpFile($path, $content);
        return Command::SUCCESS;
    }
}
