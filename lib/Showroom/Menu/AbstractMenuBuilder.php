<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Showroom\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;

class AbstractMenuBuilder
{
    public function __construct(
        protected FactoryInterface         $factory,
        protected EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @param array<string, mixed> $options
     */
    protected function createMenuItem(string $id, array $options = []): ItemInterface
    {
        return $this->factory->createItem($id, $options);
    }

    protected function dispatchMenuEvent(string $name, Event $event): void
    {
        $this->eventDispatcher->dispatch($event, $name);
    }
}
