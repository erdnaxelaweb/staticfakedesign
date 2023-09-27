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

declare( strict_types=1 );

namespace ErdnaxelaWeb\StaticFakeDesign\Tests\Templating\Twig;

use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\CommentReplacer;
use ErdnaxelaWeb\StaticFakeDesign\Tests\MethodInvokerTrait;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class CommentReplacerTest extends TestCase
{
    use MethodInvokerTrait;

    public static function replaceInStringData()
    {
        return [
            [
                '{# @fake sentence sentence(2) #}',
                '{% set sentence = sentence is defined ? sentence : generateFake("sentence", [2]) %}'
            ],
            [
                '{# @fake link link #}',
                '{% set link = link is defined ? link : generateFake("link", []) %}'
            ],
            [
                '{# @fake link link({target:"_blank"}) #}',
                '{% set link = link is defined ? link : generateFake("link", {target:"_blank"}) %}'
            ],
            [
                '{# @fake link link({target:"_blank", title:"test"}) #}',
                '{% set link = link is defined ? link : generateFake("link", {target:"_blank", title:"test"}) %}'
            ],
            [
                '{# @fake links link({target:"_blank"})[] #}',
                '{% set links = links is defined ? links : generateFakeArray(null, "link", {target:"_blank"}) %}'
            ],
            [
                '{# @fake links link({target:"_blank"})[2] #}',
                '{% set links = links is defined ? links : generateFakeArray(2, "link", {target:"_blank"}) %}'
            ],
        ];
    }

    /**
     * @dataProvider replaceInStringData
     * @return void
     */
    public function testReplaceInString(string $string, string $expected)
    {
        $replacer = new CommentReplacer();
        $result = $replacer->replaceInString($string);
        assertEquals($expected, $result);
    }

    public static function matchCommentsData()
    {
        return [
            [
                '{# @fake sentence sentence(2) #}',
                [
                    "string" => '{# @fake sentence sentence(2) #}',
                    "fake_name" => 'sentence',
                    "fake_type" => "sentence",
                    "fake_parameters" => '[2]',
                    "is_array" => false,
                    "array_size" => null
                ]
            ],
            [
                '{# @fake link link #}',
                [
                    "string" => '{# @fake link link #}',
                    "fake_name" => 'link',
                    "fake_type" => "link",
                    "fake_parameters" => '[]',
                    "is_array" => false,
                    "array_size" => null
                ]
            ],
            [
                '{# @fake link link({target:"_blank"}) #}',
                [
                    "string" => '{# @fake link link({target:"_blank"}) #}',
                    "fake_name" => 'link',
                    "fake_type" => "link",
                    "fake_parameters" => '{target:"_blank"}',
                    "is_array" => false,
                    "array_size" => null
                ]
            ],
            [
                '{# @fake link link({target:"_blank", title:"test"}) #}',
                [
                    "string" => '{# @fake link link({target:"_blank", title:"test"}) #}',
                    "fake_name" => 'link',
                    "fake_type" => "link",
                    "fake_parameters" => '{target:"_blank", title:"test"}',
                    "is_array" => false,
                    "array_size" => null
                ]
            ],
            [
                '{# @fake links link({target:"_blank"})[] #}',
                [
                    "string" => '{# @fake links link({target:"_blank"})[] #}',
                    "fake_name" => 'links',
                    "fake_type" => "link",
                    "fake_parameters" => '{target:"_blank"}',
                    "is_array" => true,
                    "array_size" => null
                ]
            ],
            [
                '{# @fake links link({target:"_blank"})[2] #}',
                [
                    "string" => '{# @fake links link({target:"_blank"})[2] #}',
                    "fake_name" => 'links',
                    "fake_type" => "link",
                    "fake_parameters" => '{target:"_blank"}',
                    "is_array" => true,
                    "array_size" => 2
                ]
            ],
        ];
    }

    /**
     * @dataProvider matchCommentsData
     * @return void
     */
    public function testMatchComments( string $comment, array $expectedResult )
    {
        $replacer = new CommentReplacer();
        $comments = $this->invokeMethod( $replacer, "matchComments", [ $comment ] );
        self::assertIsArray( $comments );
        self::assertArrayHasKey( 0, $comments );
        self::assertEquals( $expectedResult, $comments[0] );
    }

}
