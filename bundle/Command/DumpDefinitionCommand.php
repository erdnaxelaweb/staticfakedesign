<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesignBundle\Command;

use ErdnaxelaWeb\StaticFakeDesign\Configuration\DefinitionManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DumpDefinitionCommand extends Command
{
    protected static $defaultName = 'static_fake_design:definition:dump';

    public function __construct(
        protected DefinitionManager $definitionManager,
    ) {
        parent::__construct(null);
    }

    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('type', InputArgument::REQUIRED, 'Type of component');
        $this->addOption('identifier', null, InputOption::VALUE_OPTIONAL, 'Identifier for component');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getArgument('type');
        $identifier = $input->getOption('identifier');
        if ($identifier) {
            /* @phpstan-ignore argument.templateType */
            $definitions = [$this->definitionManager->getDefinition($type, $identifier)];
        } else {
            /* @phpstan-ignore argument.templateType */
            $definitions = $this->definitionManager->getDefinitionsByType($type);
        }
        foreach ($definitions as $definition) {
            dump($definition);
        }
        return Command::SUCCESS;
    }
}
