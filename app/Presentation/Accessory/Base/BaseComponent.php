<?php

namespace App\Presentation\Accessory\Base;

use Nette\Application\UI\Control;

abstract class BaseComponent extends Control
{
    /**
     * Vykresleni komponenty
     *
     * @param ...$parametry
     * @return void
     */
    public function render(...$parametry)
    {
        // Sablona komponenty
        $this->template->setFile($this->getTemplateFileName());

        // Nastaveni prekladu
        if (NULL != ($translator = $this->getTranslator()))
        {
            // Nastaveni prekladu
            $this->template->setTranslator($translator);
        }

        // Predani parametru do sablony - predani "neznameho" poctu parametru
        $this->putParametersIntoTemplate(...$parametry);

        // Vykresleni podle nastavene sablony
        $this->template->render();
    }

    /**
     * "Rozpojitelna" metoda pro jmeno souboru se sablonou
     */
    protected function getTemplateFileName() : string
    {
        // Vraceni jmena souboru pro sablonu => lze prekryt a vracet __FILE__ !!!
        return str_replace('.php', '.latte', $this->getReflection()->getFileName());
    }

    /**
     * @return null
     */
    public function getTranslator()
    {
        // Metoda je "virtualni" => bude se v potomcich prekryvat
        return NULL;
    }

    /**
     * "Virtualni" metoda pro predani parametru do sablony
     *
     * @param ...$parameters
     * @return void
     */
    protected function putParametersIntoTemplate(...$parameters)
    {
        // Metoda je "virtualni" => bude se v potomcich prekryvat
    }
}