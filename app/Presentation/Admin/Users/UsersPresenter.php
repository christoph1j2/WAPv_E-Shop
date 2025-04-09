<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Users;

use App\Presentation\Admin\AdminPresenter;
use App\Presentation\Accessory\Repository\UserRepository;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;
use Ublaboo\DataGrid\DataGrid;

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
        // Users are loaded by DataGrid - no need for template->users anymore
    }

    public function renderEdit(int $id): void
    {
        $user = $this->userRepository->getById($id);
        
        if (!$user) {
            $this->flashMessage('Uživatel nebyl nalezen.', 'danger');
            $this->redirect('default');
        }
        
        $this->template->pageTitle = 'Upravit uživatele: ' . $user->name;
        $this->template->userDetail = $user;
        
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

    /**
     * Signal handler for changing user status from DataGrid
     */
    public function handleToggleStatus(int $id): void
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
        
        try {
            $this->userRepository->update($id, [
                'active' => !$user->active
            ]);
            
            $statusText = $user->active ? 'deaktivován' : 'aktivován';
            $this->flashMessage("Uživatel byl úspěšně $statusText.", 'success');
            
            if ($this->isAjax()) {
                $this->redrawControl('flashes');
                $this['usersGrid']->redrawItem($id);
            } else {
                $this->redirect('default');
            }
        } catch (\Exception $e) {
            $this->flashMessage('Chyba při změně stavu: ' . $e->getMessage(), 'danger');
            $this->redirect('default');
        }
    }
    
    /**
     * Signal handler for toggling admin role from DataGrid
     */
    public function handleToggleAdmin(int $id): void
    {
        $user = $this->userRepository->getById($id);
        
        if (!$user) {
            $this->flashMessage('Uživatel nebyl nalezen.', 'danger');
            $this->redirect('default');
        }
        
        // Nemůžete deaktivovat sami sebe
        if ($user->id === $this->getUser()->getId()) {
            $this->flashMessage('Nemůžete změnit oprávnění vlastního účtu.', 'warning');
            $this->redirect('default');
        }
        
        try {
            $this->userRepository->update($id, [
                'is_admin' => !$user->is_admin
            ]);
            
            $roleText = $user->is_admin ? 'odebrána' : 'přidělena';
            $this->flashMessage("Role administrátora byla úspěšně $roleText.", 'success');
            
            if ($this->isAjax()) {
                $this->redrawControl('flashes');
                $this['usersGrid']->redrawItem($id);
            } else {
                $this->redirect('default');
            }
        } catch (\Exception $e) {
            $this->flashMessage('Chyba při změně role: ' . $e->getMessage(), 'danger');
            $this->redirect('default');
        }
    }

    protected function createComponentUsersGrid(): DataGrid
    {
        $grid = new DataGrid();
        $grid->setPrimaryKey('id');
        
        // Data source
        $grid->setDataSource($this->userRepository->getAll());
        
        // Columns with inline editing
        $grid->addColumnText('id', 'ID')
            ->setSortable()
            ->setFilterText();
            
        $grid->addColumnText('name', 'Jméno')
            ->setEditableCallback(function($id, $value) {
                try {
                    $this->userRepository->update((int)$id, ['name' => $value]);
                    return $value;
                } catch (\Exception $e) {
                    return false;
                }
            })
            ->setSortable()
            ->setFilterText();
            
        $grid->addColumnText('email', 'E-mail')
            ->setEditableCallback(function($id, $value) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
                try {
                    $this->userRepository->update((int)$id, ['email' => $value]);
                    return $value;
                } catch (\Exception $e) {
                    return false;
                }
            })
            ->setSortable()
            ->setFilterText();
            
        $grid->addColumnText('phone', 'Telefon')
            ->setEditableCallback(function($id, $value) {
                try {
                    $this->userRepository->update((int)$id, ['phone' => $value]);
                    return $value;
                } catch (\Exception $e) {
                    return false;
                }
            })
            ->setSortable()
            ->setFilterText();
            
        // Status column with toggle
        $statusColumn = $grid->addColumnStatus('active', 'Stav')
            ->setSortable()
            ->addOption(true, 'Aktivní')
                ->setClass('btn-success')
                ->endOption()
            ->addOption(false, 'Neaktivní')
                ->setClass('btn-danger')
                ->endOption();
        
        $statusColumn->onChange[] = function($id, $status) {
            $this->redirect('toggleStatus!', ['id' => (int)$id]);
        };
        
        // Admin role column with toggle
        $adminColumn = $grid->addColumnStatus('is_admin', 'Administrátor')
            ->setSortable()
            ->addOption(true, 'Ano')
                ->setClass('btn-primary')
                ->endOption()
            ->addOption(false, 'Ne')
                ->setClass('btn-secondary')
                ->endOption();
        
        $adminColumn->onChange[] = function($id, $status) {
            $this->redirect('toggleAdmin!', ['id' => (int)$id]);
        };
        
        // Filter for status column
        $grid->addFilterSelect('active', 'Stav:', [
            '' => 'Všichni',
            '1' => 'Aktivní',
            '0' => 'Neaktivní'
        ]);
        
        // Filter for admin column
        $grid->addFilterSelect('is_admin', 'Administrátor:', [
            '' => 'Všichni',
            '1' => 'Administrátoři',
            '0' => 'Běžní uživatelé'
        ]);
        
        // Created at column
        $grid->addColumnDateTime('created_at', 'Registrován')
            ->setFormat('d.m.Y H:i')
            ->setSortable();
        $grid->addFilterDateRange('created_at', 'Datum registrace:');
            
        // Actions
        $grid->addAction('edit', 'Upravit', 'edit')
            ->setIcon('pencil')
            ->setClass('btn btn-sm btn-primary');
        
        // Inline add functionality (bez hesla podle zadání)
        $grid->addInlineAdd()
            ->setPositionTop()
            ->onControlAdd[] = function($container) {
                $container->addText('name', '')
                    ->setRequired('Zadejte jméno uživatele')
                    ->setHtmlAttribute('placeholder', 'Jméno');
                    
                $container->addText('email', '')
                    ->setRequired('Zadejte e-mail uživatele')
                    ->addRule(\Nette\Forms\Form::EMAIL, 'Zadejte platný e-mail')
                    ->setHtmlAttribute('placeholder', 'E-mail');
                    
                $container->addText('phone', '')
                    ->setHtmlAttribute('placeholder', 'Telefon');
                    
                $container->addTextArea('address', '')
                    ->setHtmlAttribute('placeholder', 'Adresa');
                    
                $container->addCheckbox('is_admin', 'Administrátor')
                    ->setDefaultValue(false);
                    
                $container->addCheckbox('is_editor', 'Editor')
                    ->setDefaultValue(false);
            };
            
        $grid->getInlineAdd()->onSubmit[] = function($values) {
            try {
                $userData = [
                    'name' => $values['name'],
                    'email' => $values['email'],
                    'phone' => $values['phone'] ?? '',
                    'address' => $values['address'] ?? '',
                    'is_admin' => isset($values['is_admin']) ? (bool)$values['is_admin'] : false,
                    'is_editor' => isset($values['is_editor']) ? (bool)$values['is_editor'] : false,
                    'active' => true,
                    'created_at' => new \DateTime(),
                    // Heslo není nastaveno záměrně - podle zadání
                ];
                
                $this->userRepository->insert($userData);
                $this->flashMessage('Uživatel byl úspěšně přidán. Uživatel si musí nastavit heslo pomocí funkce "Zapomenuté heslo".', 'success');
                return true;
            } catch (\Exception $e) {
                $this->flashMessage('Při vytváření uživatele došlo k chybě: ' . $e->getMessage(), 'danger');
                return false;
            }
        };
        
        // Nastavení stránkování
        $grid->setPagination(true);
        $grid->setItemsPerPageList([10, 20, 50, 100]);
        
        return $grid;
    }

    /**
     * Callback for user status change in DataGrid - opraveno pro správné typování
     */
    public function userStatusChange($id, $status): void
    {
        $this->redirect('toggleStatus!', ['id' => (int)$id]);
    }

    /**
     * Callback for user admin role change in DataGrid - opraveno pro správné typování
     */
    public function userAdminChange($id, $status): void
    {
        $this->redirect('toggleAdmin!', ['id' => (int)$id]);
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