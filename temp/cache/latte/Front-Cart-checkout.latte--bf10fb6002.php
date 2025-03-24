<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\Cart/checkout.latte */
final class Template_bf10fb6002 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\Cart/checkout.latte';

	public const Blocks = [
		['content' => 'blockContent'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo "\n";
		$this->renderBlock('content', get_defined_vars()) /* line 3 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['item' => '81'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$this->parentName = '../@layout.latte';
		return get_defined_vars();
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<div class="container mt-4">
    <h1>Dokončení objednávky</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dodací údaje</h5>
                </div>
                <div class="card-body">
                    ';
		$form = $this->global->formsStack[] = $this->global->uiControl['checkoutForm'] /* line 14 */;
		Nette\Bridges\FormsLatte\Runtime::initializeForm($form);
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form, []) /* line 14 */;
		echo "\n";
		if ($user->isLoggedIn()) /* line 15 */ {
			echo '                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="useExistingAddress" name="useExistingAddress" checked>
                                    <label class="form-check-label" for="useExistingAddress">
                                        Použít moje uložené údaje
                                    </label>
                                </div>
                            </div>
                            
                            <div id="existingAddressDetails" class="mb-4 p-3 bg-light rounded">
                                <div><strong>Jméno:</strong> ';
			echo LR\Filters::escapeHtmlText($userData->name) /* line 26 */;
			echo '</div>
                                <div><strong>Adresa:</strong> ';
			echo LR\Filters::escapeHtmlText($userData->address ?: 'Není vyplněna') /* line 27 */;
			echo '</div>
                                <div><strong>Telefon:</strong> ';
			echo LR\Filters::escapeHtmlText($userData->phone ?: 'Není vyplněn') /* line 28 */;
			echo '</div>
                                <div><strong>Email:</strong> ';
			echo LR\Filters::escapeHtmlText($userData->email) /* line 29 */;
			echo '</div>
                            </div>
';
		}
		echo '                        
                        <div id="formFields" ';
		if ($user->isLoggedIn()) /* line 33 */ {
			echo 'class="d-none"';
		}
		echo '>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('name', $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 36 */;
		echo ' class="form-label">Jméno a příjmení</label>
                                    <input';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('name', $this->global)->getControlPart())->addAttributes(['class' => null])->attributes() /* line 37 */;
		echo ' class="form-control">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('email', $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 41 */;
		echo ' class="form-label">Email</label>
                                    <input';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('email', $this->global)->getControlPart())->addAttributes(['class' => null])->attributes() /* line 42 */;
		echo ' class="form-control">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('phone', $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 47 */;
		echo ' class="form-label">Telefon</label>
                                <input';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('phone', $this->global)->getControlPart())->addAttributes(['class' => null])->attributes() /* line 48 */;
		echo ' class="form-control">
                            </div>
                            
                            <div class="mb-3">
                                <label';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('address', $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 52 */;
		echo ' class="form-label">Adresa</label>
                                <textarea';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('address', $this->global)->getControlPart())->addAttributes(['class' => null, 'rows' => null])->attributes() /* line 53 */;
		echo ' class="form-control" rows="3">';
		echo $ʟ_elem->getHtml() /* line 53 */;
		echo '</textarea>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('note', $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 58 */;
		echo ' class="form-label">Poznámka k objednávce</label>
                            <textarea';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('note', $this->global)->getControlPart())->addAttributes(['class' => null, 'rows' => null])->attributes() /* line 59 */;
		echo ' class="form-control" rows="2">';
		echo $ʟ_elem->getHtml() /* line 59 */;
		echo '</textarea>
                        </div>
                        
                        <button';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('submit', $this->global)->getControlPart())->addAttributes(['class' => null])->attributes() /* line 62 */;
		echo ' class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle me-2"></i>Dokončit objednávku
                        </button>
                        
                        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 66 */;
		echo '/cart" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Zpět do košíku
                        </a>
                    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack)) /* line 69 */;

		echo '
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Souhrn objednávky</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group mb-3">
';
		foreach ($cartItems as $item) /* line 81 */ {
			echo '                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <span class="fw-bold">';
			echo LR\Filters::escapeHtmlText($item['product']->name) /* line 84 */;
			echo '</span>
                                    <span class="text-muted d-block">';
			echo LR\Filters::escapeHtmlText($item['quantity']) /* line 85 */;
			echo ' ks × ';
			echo LR\Filters::escapeHtmlText($item['product']->price) /* line 85 */;
			echo ' Kč</span>
                                </div>
                                <span class="text-dark">';
			echo LR\Filters::escapeHtmlText($item['price']) /* line 87 */;
			echo ' Kč</span>
                            </li>
';

		}

		echo '                        <li class="list-group-item d-flex justify-content-between border-top">
                            <span class="fw-bold">Celkem:</span>
                            <span class="fw-bold">';
		echo LR\Filters::escapeHtmlText($totalPrice) /* line 92 */;
		echo ' Kč</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener(\'DOMContentLoaded\', function() {
    const useExistingAddressCheckbox = document.getElementById(\'useExistingAddress\');
    if (!useExistingAddressCheckbox) return;
    
    const formFields = document.getElementById(\'formFields\');
    
    // Initial state
    toggleFormFields();
    
    // Event listener
    useExistingAddressCheckbox.addEventListener(\'change\', toggleFormFields);
    
    function toggleFormFields() {
        const useExisting = useExistingAddressCheckbox.checked;
        
        if (useExisting) {
            formFields.classList.add(\'d-none\');
        } else {
            formFields.classList.remove(\'d-none\');
        }
    }
});
</script>
';
	}
}
