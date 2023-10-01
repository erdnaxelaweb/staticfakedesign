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

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use DOMDocument;
use DOMElement;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RichTextGenerator extends AbstractGenerator
{
    public const P_TAG = 'p';

    public const A_TAG = 'a';

    public const SPAN_TAG = 'span';

    public const TABLE_TAG = 'table';

    public const THEAD_TAG = 'thead';

    public const TBODY_TAG = 'tbody';

    public const TR_TAG = 'tr';

    public const TD_TAG = 'td';

    public const TH_TAG = 'th';

    public const UL_TAG = 'ul';

    public const LI_TAG = 'li';

    public const H_TAG = 'h';

    public const B_TAG = 'b';

    public const I_TAG = 'i';

    public const TITLE_TAG = 'title';

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->define('maxWidth')
            ->default(10)
            ->allowedTypes('int')
            ->info(
                'Identifier of the taxonomy entry to generate. See erdnaxelaweb.static_fake_design.taxonomy_entry_definition'
            );
    }

    public function __invoke(int $maxWidth = 10): string
    {
        if (! class_exists(DOMDocument::class, false)) {
            throw new \RuntimeException('ext-dom is required to use randomHtml.');
        }

        $domDocument = new DOMDocument();
        $body = $domDocument->createElement('body');
        $this->addRandomSubTree($body, $maxWidth);

        $resultDocument = new DOMDocument();
        foreach ($body->childNodes as $childNode) {
            $node = $resultDocument->importNode($childNode, true);
            $resultDocument->appendChild($node);
        }
        return $resultDocument->saveXML();
    }

    private function addRandomSubTree(DOMElement $root, int $maxWidth)
    {
        $siblings = $this->fakerGenerator->numberBetween(1, $maxWidth);

        for ($i = 0; $i < $siblings; ++$i) {
            $this->addRandomLeaf($root);
        }

        return $root;
    }

    private function addRandomLeaf(DOMElement $node): void
    {
        $rand = $this->fakerGenerator->numberBetween(1, 10);

        switch ($rand) {
            case 1:
                $this->addRandomP($node);

                break;

            case 2:
                $this->addRandomA($node);

                break;

            case 3:
                $this->addRandomSpan($node);

                break;

            case 4:
                $this->addRandomUL($node);

                break;

            case 5:
                $this->addRandomH($node);

                break;

            case 6:
                $this->addRandomB($node);

                break;

            case 7:
                $this->addRandomI($node);

                break;

            case 8:
                $this->addRandomTable($node);

                break;

            default:
                $this->addRandomText($node);

                break;
        }
    }

    private function addRandomP(DOMElement $element, $maxLength = 10): void
    {
        $node = $element->ownerDocument->createElement(static::P_TAG);
        $node->textContent = $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength));
        $element->appendChild($node);
    }

    private function addRandomText(DOMElement $element, $maxLength = 10): void
    {
        $text = $element->ownerDocument->createTextNode(
            $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength))
        );
        $element->appendChild($text);
    }

    private function addRandomA(DOMElement $element, $maxLength = 10): void
    {
        $text = $element->ownerDocument->createTextNode(
            $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength))
        );
        $node = $element->ownerDocument->createElement(static::A_TAG);
        $node->setAttribute('href', $this->fakerGenerator->safeEmailDomain());
        $node->appendChild($text);
        $element->appendChild($node);
    }

    private function addRandomTitle(DOMElement $element, $maxLength = 10): void
    {
        $text = $element->ownerDocument->createTextNode(
            $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength))
        );
        $node = $element->ownerDocument->createElement(static::TITLE_TAG);
        $node->appendChild($text);
        $element->appendChild($node);
    }

    private function addRandomH(DOMElement $element, $maxLength = 10): void
    {
        $h = static::H_TAG . (string) $this->fakerGenerator->numberBetween(1, 3);
        $text = $element->ownerDocument->createTextNode(
            $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength))
        );
        $node = $element->ownerDocument->createElement($h);
        $node->appendChild($text);
        $element->appendChild($node);
    }

    private function addRandomB(DOMElement $element, $maxLength = 10): void
    {
        $text = $element->ownerDocument->createTextNode(
            $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength))
        );
        $node = $element->ownerDocument->createElement(static::B_TAG);
        $node->appendChild($text);
        $element->appendChild($node);
    }

    private function addRandomI(DOMElement $element, $maxLength = 10): void
    {
        $text = $element->ownerDocument->createTextNode(
            $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength))
        );
        $node = $element->ownerDocument->createElement(static::I_TAG);
        $node->appendChild($text);
        $element->appendChild($node);
    }

    private function addRandomSpan(DOMElement $element, $maxLength = 10): void
    {
        $text = $element->ownerDocument->createTextNode(
            $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength))
        );
        $node = $element->ownerDocument->createElement(static::SPAN_TAG);
        $node->appendChild($text);
        $element->appendChild($node);
    }

    private function addRandomTable(
        DOMElement $element,
        $maxRows = 10,
        $maxCols = 6,
        $maxTitle = 4,
        $maxLength = 10
    ): void {
        $rows = $this->fakerGenerator->numberBetween(1, $maxRows);
        $cols = $this->fakerGenerator->numberBetween(1, $maxCols);

        $table = $element->ownerDocument->createElement(static::TABLE_TAG);
        $thead = $element->ownerDocument->createElement(static::THEAD_TAG);
        $tbody = $element->ownerDocument->createElement(static::TBODY_TAG);

        $table->appendChild($thead);
        $table->appendChild($tbody);

        $tr = $element->ownerDocument->createElement(static::TR_TAG);
        $thead->appendChild($tr);

        for ($i = 0; $i < $cols; ++$i) {
            $th = $element->ownerDocument->createElement(static::TH_TAG);
            $th->textContent = $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxTitle));
            $tr->appendChild($th);
        }

        for ($i = 0; $i < $rows; ++$i) {
            $tr = $element->ownerDocument->createElement(static::TR_TAG);
            $tbody->appendChild($tr);

            for ($j = 0; $j < $cols; ++$j) {
                $th = $element->ownerDocument->createElement(static::TD_TAG);
                $th->textContent = $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength));
                $tr->appendChild($th);
            }
        }
        $element->appendChild($table);
    }

    private function addRandomUL(DOMElement $element, $maxItems = 11, $maxLength = 4): void
    {
        $num = $this->fakerGenerator->numberBetween(1, $maxItems);
        $ul = $element->ownerDocument->createElement(static::UL_TAG);

        for ($i = 0; $i < $num; ++$i) {
            $li = $element->ownerDocument->createElement(static::LI_TAG);
            $li->textContent = $this->fakerGenerator->sentence($this->fakerGenerator->numberBetween(1, $maxLength));
            $ul->appendChild($li);
        }
        $element->appendChild($ul);
    }
}
