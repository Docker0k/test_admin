<?php

namespace App\Services;

class MenuSection
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $icon;

    /**
     * @var string
     */
    private string $alias;
    /**
     * @var bool
     */
    private bool $active = false;
    private string $route = '';

    /**
     * @param $name
     * @param string $icon
     */
    public function __construct($name, string $icon = '')
    {
        $this->name = $name;
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @param $value
     * @return void
     */
    public function setActive($value): void
    {
        $this->active = $value;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param $route
     * @return void
     */
    public function setRoute($route): void
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return route($this->route);
    }
}
