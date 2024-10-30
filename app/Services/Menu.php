<?php

namespace App\Services;


use Exception;

class Menu
{
    /**
     * @var MenuSection[]
     */
    private $sections = [];


    /**
     * @var MenuSection|null
     */
    private ?MenuSection $currentSection;

    public function currentSection()
    {
        return $this->currentSection;
    }

    /**
     * @param $name
     * @param string $icon
     * @return MenuSection
     */
    public function addSection($name, string $icon = ''): MenuSection
    {
        $section = new MenuSection($name, $icon);
        $this->sections[] = $section;
        $this->currentSection = $section;

        return $section;
    }

    /**
     * @return MenuSection[]
     */
    public function getSections()
    {
        return $this->sections;
    }


    /**
     * @param string $alias
     * @return MenuSection
     * @throws Exception
     */
    public function getSection(string $alias): MenuSection
    {
        foreach ($this->getSections() as $section) {
            if($section->getAlias() == $alias){
                return $section;
            }
        }
        throw new \Exception('Section not defined: ' . $alias);
    }


    /**
     * @param $alias
     * @return $this
     */
    public function setMenuSection($alias): static
    {
        $section = $this->getSection($alias);
        $section->setActive(true);

        return $this;
    }

}
