<?php

namespace App\Presentation\Front;

use App\Presentation\BasePresenter;

class FrontPresenter extends BasePresenter
{
    protected function startup(): void
    {
        parent::startup();
        
        $action = $this->getAction() ?: 'default';

        $resource = $this->getName();
        if (!$this->getUser()->isAllowed($resource, $action)) {
            if (!$this->getUser()->isLoggedIn()) {
                $this->flashMessage('Pro přístup k této stránce se musíte přihlásit.', 'warning');
                $this->redirect('Login:default', ['backlink' => $this->storeRequest()]);
            } else {
                $this->flashMessage('Nemáte oprávnění k přístupu na tuto stránku.', 'danger');
                $this->redirect('Home:default');
            }
        }
    }
}