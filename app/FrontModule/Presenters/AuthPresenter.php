<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class AuthPresenter extends Nette\Application\UI\Presenter
{
    /** @var Nette\Security\User */
    private $user;
    
    public function __construct(Nette\Security\User $user)
    {
        $this->user = $user;
    }
    
    public function actionLogin(): void
    {

        if ($this->user->isLoggedIn()) {
            $this->redirect('Homepage:');
        }
    }
    
    public function actionLogout(): void
    {
        if ($this->user->isLoggedIn()) {
            $this->user->logout();
            $this->flashMessage('Byli jste odhlášeni.', 'success');
        }
        $this->redirect('Homepage:');
    }
    
    protected function createComponentLoginForm(): Form
    {
        $form = new Form;
        
        $form->addText('username', 'Uživatelské jméno')
            ->setRequired('Prosím vyplňte uživatelské jméno.');
            
        $form->addPassword('password', 'Heslo')
            ->setRequired('Prosím vyplňte heslo.');
            
        $form->addCheckbox('remember', 'Zapamatovat si mě');
        
        $form->addSubmit('send', 'Přihlásit');
        
        $form->onSuccess[] = [$this, 'loginFormSucceeded'];
        
        return $form;
    }
    
    public function loginFormSucceeded(Form $form, \stdClass $values): void
    {
        try {
            $this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
            $this->user->login($values->username, $values->password);
            $this->flashMessage('Přihlášení bylo úspěšné.', 'success');
            $this->redirect('Homepage:');
            
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Nesprávné přihlašovací údaje.');
        }
    }
    
    protected function createComponentRegisterForm(): Form
    {
        $form = new Form;
        
        $form->addText('username', 'Uživatelské jméno')
            ->setRequired('Prosím vyplňte uživatelské jméno.');
            
        $form->addEmail('email', 'E-mail')
            ->setRequired('Prosím vyplňte e-mail.');
            
        $form->addPassword('password', 'Heslo')
            ->setRequired('Prosím vyplňte heslo.')
            ->addRule($form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 6);
            
        $form->addPassword('passwordVerify', 'Heslo znovu')
            ->setRequired('Prosím vyplňte heslo znovu.')
            ->addRule($form::EQUAL, 'Hesla se neshodují', $form['password']);
            
        $form->addSubmit('send', 'Registrovat');
        
        $form->onSuccess[] = [$this, 'registerFormSucceeded'];
        
        return $form;
    }
    
    public function registerFormSucceeded(Form $form, \stdClass $values): void
    {

        $this->flashMessage('Registrace byla úspěšná. Nyní se můžete přihlásit.', 'success');
        $this->redirect('Auth:login');
        
    }
    
    protected function createComponentForgotPasswordForm(): Form
    {
        $form = new Form;
        
        $form->addEmail('email', 'E-mail')
            ->setRequired('Prosím vyplňte e-mail.');
            
        $form->addSubmit('send', 'Obnovit heslo');
        
        $form->onSuccess[] = [$this, 'forgotPasswordFormSucceeded'];
        
        return $form;
    }
    
    public function forgotPasswordFormSucceeded(Form $form, \stdClass $values): void
    {

        $this->flashMessage('Pokyny k obnovení hesla byly odeslány na váš e-mail.', 'success');
        $this->redirect('Auth:login');
    }
}
