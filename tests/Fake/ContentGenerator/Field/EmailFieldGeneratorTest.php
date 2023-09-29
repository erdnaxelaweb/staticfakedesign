<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\EmailFieldGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Tests\Fake\GeneratorTestTrait;
use PHPUnit\Framework\TestCase;

class EmailFieldGeneratorTest extends TestCase
{
    use GeneratorTestTrait;

    public static function getGenerator(): EmailFieldGenerator
    {
        return new EmailFieldGenerator(self::getFakerGenerator());
    }

    public function testGenerator()
    {
        $generator = self::getGenerator();

        $email = $generator();
        self::assertIsString($email);
        self::assertTrue(preg_match('/^.+\@\S+\.\S+$/', $email) === 1);
    }
}
