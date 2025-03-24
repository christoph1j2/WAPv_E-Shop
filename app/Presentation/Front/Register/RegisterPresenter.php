<?php

declare(strict_types=1);

namespace App\Presentation\Front\Register;

use App\Presentation\Auth\AuthService;
use App\Presentation\Front\FrontPresenter;
use Nette\Application\UI\Form;
use Tracy\Debugger;

final class RegisterPresenter extends FrontPresenter
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        parent::__construct();
        $this->authService = $authService;
    }

    protected function createComponentRegisterForm(): Form
    {
        $form = new Form();
        $form->getElementPrototype()->addClass('needs-validation')->setAttribute('novalidate', 'novalidate');
    
        $form->addText('name', 'Jméno:*')
             ->setRequired('Zadejte své jméno.')
             ->getControlPrototype()->addClass('form-control');
    
        $form->addEmail('email', 'E-mail:*')
             ->setRequired('Zadejte platný e-mail.')
             ->getControlPrototype()->addClass('form-control');
    
        $form->addPassword('password', 'Heslo:*')
             ->setRequired('Zadejte heslo.')
             ->getControlPrototype()->addClass('form-control');

        $form->addPassword('password2', 'Heslo znovu:*')
                ->setRequired('Zadejte heslo znovu.')
                ->addRule(Form::Equal, 'Hesla se neshodují.', $form['password'])
                ->getControlPrototype()->addClass('form-control');

        $form->addText('phone', 'Telefon:')
             ->getControlPrototype()->addClass('form-control');

        $form->addText('address', 'Adresa:')
             ->getControlPrototype()->addClass('form-control');
    
        $form->addSubmit('submit', 'Registrovat se')
             ->getControlPrototype()->addClass('btn btn-primary mt-2');
    
        $form->onSuccess[] = [$this, 'processRegister'];
        return $form;
    }

    public function processRegister(Form $form, array $values): void
    {
        try {
            //Debugger::barDump($values);
            $this->authService->register($values['name'], $values['email'], $values['password']);
            $this->flashMessage('Registrace byla úspěšná! Přihlašte se.', 'success');
            $this->redirect('Login:default');
        } catch (\Nette\Application\AbortException $e) {
            // !nedelat nic, je to guta
        } catch (\Exception $e) {
            Debugger::barDump($e, 'Exception');
            $this->flashMessage('Registrace se nezdařila: ' . $e->getMessage(), 'error');
        }
    }
}