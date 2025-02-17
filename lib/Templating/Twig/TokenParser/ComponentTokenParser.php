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

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\TokenParser;

use ErdnaxelaWeb\StaticFakeDesign\Templating\Twig\Node\ComponentReferenceNode;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class ComponentTokenParser extends AbstractTokenParser
{
    public function parse(Token $token): Node
    {
        $parameters = $this->parser->getExpressionParser()
            ->parseExpression();

        $stream = $this->parser->getStream();
        $stream->expect(/* Token::BLOCK_END_TYPE */ 3);
        return new ComponentReferenceNode($parameters);
    }

    public function getTag()
    {
        return 'component';
    }
}
