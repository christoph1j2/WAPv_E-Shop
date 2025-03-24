<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Users;

use App\Presentation\Admin\AdminPresenter;
use App\Presentation\Accessory\Repository\UserRepository;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;

final class UsersPresenter extends AdminPresenter
{
    private UserRepository $userRepository;
    private Passwords $passwords;

    public function __construct(
        UserRepository $userRepository,
        Passwords $passwords
    ) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->passwords = $passwords;
    }

    public function renderDefault(): void
    {
        $this->template->pageTitle = 'Správa uživatelů';
        $this->template->users = $this->userRepository->getAll();
    }

    public function renderEdit(int $id): void
    {
        $user = $this->userRepository->getById($id);
        
        if (!$user) {
            $this->flashMessage('Uživatel nebyl nalezen.', 'danger');
            $this->redirect('default');
        }
        
        $this->template->pageTitle = 'Upravit uživatele: ' . $user->name;
        $this->template->userDetail = $user;  // Používáme userDetail místo user
        
        // Nastavení výchozích hodnot formuláře
        $this['userForm']->setDefaults([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'is_admin' => $user->is_admin,
            'is_editor' => $user->is_editor,
        ]);
    }
    
    public function actionToggleStatus(int $id): void
    {
        $user = $this->userRepository->getById($id);
        
        if (!$user) {
            $this->flashMessage('Uživatel nebyl nalezen.', 'danger');
            $this->redirect('default');
        }
        
        // Nemůžete deaktivovat sami sebe
        if ($user->id === $this->getUser()->getId()) {
            $this->flashMessage('Nemůžete deaktivovat vlastní účet.', 'warning');
            $this->redirect('default');
        }
        
        $this->userRepository->update((int)$id, [
            'active' => !$user->active,
        ]);
        
        $statusText = $user->active ? 'deaktivován' : 'aktivován';
        $this->flashMessage("Uživatel byl úspěšně $statusText.", 'success');
        $this->redirect('default');
    }

    protected function createComponentUserForm(): Form
    {
        $form = new Form;
        
        $form->addText('name', 'Jméno:')
            ->setRequired('Zadejte jméno uživatele.');
            
        $form->addEmail('email', 'E-mail:')
            ->setRequired('Zadejte platný e-mail.');
            
        $form->addText('phone', 'Telefon:');
        
        $form->addTextArea('address', 'Adresa:');
        
        $form->addPassword('password', 'Nové heslo:')
            ->setRequired(false)
            ->addRule($form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', 6);
            
        $form->addCheckbox('is_admin', 'Administrátor')
            ->setDefaultValue(false);
            
        $form->addCheckbox('is_editor', 'Editor')
            ->setDefaultValue(false);
            
        $form->addSubmit('submit', 'Uložit');
        
        $form->onSuccess[] = [$this, 'processUserForm'];
        
        return $form;
    }
    
    public function processUserForm(Form $form, array $values): void
    {
        $id = $this->getParameter('id');
        
        $userData = [
            'name' => $values['name'],
            'email' => $values['email'],
            'phone' => $values['phone'],
            'address' => $values['address'],
            'is_admin' => $values['is_admin'],
            'is_editor' => $values['is_editor'],
        ];
        
        // Aktualizace hesla, pouze pokud bylo zadáno nové heslo
        if ($values['password']) {
            $userData['password_hash'] = $this->passwords->hash($values['password']);
        }
        
        // Přetypuj ID na integer
        $this->userRepository->update((int)$id, $userData);
        $this->flashMessage('Uživatel byl úspěšně aktualizován.', 'success');
        $this->redirect('default');
    }
}