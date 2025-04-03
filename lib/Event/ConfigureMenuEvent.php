<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ConfigureMenuEvent extends Event
{
    public const SHOWROOM_MENU_SIDEBAR = "showroom.menu.sidebar";

    private FactoryInterface $factory;

    private ItemInterface $menu;

    /**
     * @var array<mixed>
     */
    private array $options;

    /**
     * @param array<mixed> $options
     */
    public function __construct(FactoryInterface $factory, ItemInterface $menu, array $options = [])
    {
        $this->factory = $factory;
        $this->menu = $menu;
        $this->options = $options;
    }

    public function getFactory(): FactoryInterface
    {
        return $this->factory;
    }

    public function getMenu(): ItemInterface
    {
        return $this->menu;
    }

    /**
     * @return array<mixed>
     */
    public function getOptions(): array
    {
        return $this->options ?? [];
    }
}
