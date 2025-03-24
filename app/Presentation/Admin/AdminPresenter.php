<?php

namespace App\Presentation\Admin;

use App\Presentation\Accessory\Components\Dummy\DummyComponent;
use App\Presentation\BasePresenter;
use App\Presentation\Accessory\Base\BaseComponent;

class AdminPresenter extends BasePresenter
{
    protected function startup(): void
    {
        parent::startup();
        
        // Check if user is logged in
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Pro přístup do administrace se musíte přihlásit.', 'warning');
            $this->redirect(':Front:Login:default', ['backlink' => $this->storeRequest()]);
        }
        
        // Check if user has admin or editor role
        if (!$this->getUser()->isInRole('admin') && !$this->getUser()->isInRole('editor')) {
            $this->flashMessage('Pro přístup do administrace nemáte dostatečná oprávnění.', 'danger');
            $this->redirect(':Front:Home:default');
        }
        
        // Get current action
        $action = $this->getAction() ?: 'default';
        
        // Check if user has permission for specific resource and action
        $resource = $this->getName();
        if (!$this->getUser()->isAllowed($resource, $action)) {
            $this->flashMessage('Nemáte oprávnění k této akci.', 'danger');
            $this->redirect(':default');
        }
    }
}