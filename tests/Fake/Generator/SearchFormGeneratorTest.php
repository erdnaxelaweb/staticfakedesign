<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\SearchFormGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;

class SearchFormGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator()
    {
        $formFactory = self::createStub(FormFactoryInterface::class);
        return new SearchFormGenerator($formFactory, self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();
        self::assertInstanceOf(SearchFormGenerator::class, $generator);
    }
}
