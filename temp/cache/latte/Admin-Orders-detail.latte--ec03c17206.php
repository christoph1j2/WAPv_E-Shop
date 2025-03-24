<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Admin\Orders/detail.latte */
final class Template_ec03c17206 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Admin\\Orders/detail.latte';

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
			foreach (array_intersect_key(['item' => '64'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '<div class="container-fluid mt-4">
    <h1>Detail objednávky #';
		echo LR\Filters::escapeHtmlText($order->id) /* line 5 */;
		echo '</h1>
    <p class="text-muted">Vytvořena: ';
		echo LR\Filters::escapeHtmlText(($this->filters->date)($order->created_at, 'j.n.Y H:i')) /* line 6 */;
		echo '</p>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Stav objednávky</h5>
                    <div>
                        ';
		$form = $this->global->formsStack[] = $this->global->uiControl['changeStatusForm'] /* line 14 */;
		Nette\Bridges\FormsLatte\Runtime::initializeForm($form);
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form, []) /* line 14 */;
		echo '
                            <div class="d-flex">
                                <select';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('status', $this->global)->getControlPart())->addAttributes(['class' => null])->attributes() /* line 16 */;
		echo ' class="form-select me-2">';
		echo $ʟ_elem->getHtml() /* line 16 */;
		echo '</select>
                                <button';
		echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item('submit', $this->global)->getControlPart())->addAttributes(['class' => null])->attributes() /* line 23 */;
		echo ' class="btn btn-primary">Aktualizovat</button>
                            </div>
                        ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack)) /* line 25 */;

		echo '
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
';
		if ($order->status == 'pending') /* line 30 */ {
			echo '                            <span class="badge bg-warning text-dark">Čeká na zpracování</span>
';
		} elseif ($order->status == 'processing') /* line 32 */ {
			echo '                            <span class="badge bg-info">Zpracovává se</span>
';
		} elseif ($order->status == 'shipped') /* line 34 */ {
			echo '                            <span class="badge bg-primary">Odesláno</span>
';
		} elseif ($order->status == 'delivered') /* line 36 */ {
			echo '                            <span class="badge bg-success">Doručeno</span>
';
		} elseif ($order->status == 'cancelled') /* line 38 */ {
			echo '                            <span class="badge bg-danger">Zrušeno</span>
';
		} else /* line 40 */ {
			echo '                            <span class="badge bg-secondary">';
			echo LR\Filters::escapeHtmlText($order->status) /* line 41 */;
			echo '</span>
';
		}




		echo '                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Položky objednávky</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produkt</th>
                                    <th class="text-end">Cena za kus</th>
                                    <th class="text-center">Množství</th>
                                    <th class="text-end">Celkem</th>
                                </tr>
                            </thead>
                            <tbody>
';
		foreach ($items as $item) /* line 64 */ {
			echo '                                <tr>
                                    <td>';
			echo LR\Filters::escapeHtmlText($item['product']->id) /* line 66 */;
			echo '</td>
                                    <td>
                                        <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 68 */;
			echo '/admin/products/edit/';
			echo LR\Filters::escapeHtmlAttr($item['product']->id) /* line 68 */;
			echo '" target="_blank">
                                            ';
			echo LR\Filters::escapeHtmlText($item['product']->name) /* line 69 */;
			echo '
                                        </a>
                                    </td>
                                    <td class="text-end">';
			echo LR\Filters::escapeHtmlText($item['item']->unit_price) /* line 72 */;
			echo ' Kč</td>
                                    <td class="text-center">';
			echo LR\Filters::escapeHtmlText($item['item']->quantity) /* line 73 */;
			echo '</td>
                                    <td class="text-end">';
			echo LR\Filters::escapeHtmlText($item['total_price']) /* line 74 */;
			echo ' Kč</td>
                                </tr>
';

		}

		echo '                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Celková cena:</th>
                                    <th class="text-end">';
		echo LR\Filters::escapeHtmlText($order->total_price) /* line 81 */;
		echo ' Kč</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
';
		if ($order->note) /* line 89 */ {
			echo '            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Poznámka k objednávce</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">';
			echo LR\Filters::escapeHtmlText($order->note) /* line 95 */;
			echo '</p>
                </div>
            </div>
';
		}
		echo '            
            <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 100 */;
		echo '/admin/orders" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Zpět na seznam objednávek
            </a>
        </div>
        
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informace o zákazníkovi</h5>
                </div>
                <div class="card-body">
';
		if ($userData) /* line 111 */ {
			echo '                        <p><strong>Jméno:</strong> ';
			echo LR\Filters::escapeHtmlText($userData->name) /* line 112 */;
			echo '</p>
                        <p><strong>Email:</strong> ';
			echo LR\Filters::escapeHtmlText($userData->email) /* line 113 */;
			echo '</p>
                        <p><strong>Telefon:</strong> ';
			echo LR\Filters::escapeHtmlText($userData->phone ?: 'Nevyplněno') /* line 114 */;
			echo '</p>
                        <p><strong>Adresa:</strong> ';
			echo LR\Filters::escapeHtmlText($userData->address ?: 'Nevyplněno') /* line 115 */;
			echo '</p>
                        
                    
';
		} else /* line 118 */ {
			echo '                        <p class="text-muted">Uživatel byl smazán nebo objednávka byla vytvořena bez registrace.</p>
';
		}
		echo '                </div>
            </div>
        </div>
    </div>
</div>
';
	}
}
