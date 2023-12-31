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

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\FakerGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatrixFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected FakerGenerator $fakerGenerator
    ) {
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('columns')
            ->required()
            ->allowedTypes('string[]');

        $optionsResolver->define('minimumRows')
            ->default(1)
            ->allowedTypes('int');
    }

    public function __invoke(array $columns, int $minimumRows = 1): array
    {
        $count = $this->fakerGenerator->numberBetween($minimumRows, 10);
        $rows = [];
        for ($i = 0; $i < $count; $i++) {
            $row = [];
            foreach ($columns as $column) {
                $row[$column] = $this->fakerGenerator->word();
            }
            $rows[] = $row;
        }
        return $rows;
    }
}
