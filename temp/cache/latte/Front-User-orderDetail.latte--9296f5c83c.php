<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\User/orderDetail.latte */
final class Template_9296f5c83c extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\User/orderDetail.latte';

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
			foreach (array_intersect_key(['item' => '47'], $this->params) as $ʟ_v => $ʟ_l) {
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
    <h1>Detail objednávky #';
		echo LR\Filters::escapeHtmlText($order->id) /* line 5 */;
		echo '</h1>
    <p class="text-muted">Vytvořena: ';
		echo LR\Filters::escapeHtmlText(($this->filters->date)($order->created_at, 'j.n.Y H:i')) /* line 6 */;
		echo '</p>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Stav objednávky</h5>
                </div>
                <div class="card-body">
';
		if ($order->status == 'pending') /* line 15 */ {
			echo '                        <span class="badge bg-warning">Čeká na zpracování</span>
';
		} elseif ($order->status == 'processing') /* line 17 */ {
			echo '                        <span class="badge bg-info">Zpracovává se</span>
';
		} elseif ($order->status == 'shipped') /* line 19 */ {
			echo '                        <span class="badge bg-primary">Odesláno</span>
';
		} elseif ($order->status == 'delivered') /* line 21 */ {
			echo '                        <span class="badge bg-success">Doručeno</span>
';
		} elseif ($order->status == 'cancelled') /* line 23 */ {
			echo '                        <span class="badge bg-danger">Zrušeno</span>
';
		} else /* line 25 */ {
			echo '                        <span class="badge bg-secondary">';
			echo LR\Filters::escapeHtmlText($order->status) /* line 26 */;
			echo '</span>
';
		}




		echo '                </div>
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
                                    <th>Produkt</th>
                                    <th class="text-end">Cena za kus</th>
                                    <th class="text-center">Množství</th>
                                    <th class="text-end">Celkem</th>
                                </tr>
                            </thead>
                            <tbody>
';
		foreach ($items as $item) /* line 47 */ {
			echo '                                <tr>
                                    <td>
                                        <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 50 */;
			echo '/catalog/product/';
			echo LR\Filters::escapeHtmlAttr($item['product']->id) /* line 50 */;
			echo '">
                                            ';
			echo LR\Filters::escapeHtmlText($item['product']->name) /* line 51 */;
			echo '
                                        </a>
                                    </td>
                                    <td class="text-end">';
			echo LR\Filters::escapeHtmlText($item['item']->unit_price) /* line 54 */;
			echo ' Kč</td>
                                    <td class="text-center">';
			echo LR\Filters::escapeHtmlText($item['item']->quantity) /* line 55 */;
			echo '</td>
                                    <td class="text-end">';
			echo LR\Filters::escapeHtmlText($item['total_price']) /* line 56 */;
			echo ' Kč</td>
                                </tr>
';

		}

		echo '                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Celková cena:</th>
                                    <th class="text-end">';
		echo LR\Filters::escapeHtmlText($order->total_price) /* line 63 */;
		echo ' Kč</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
';
		if (isset($order->note) && $order->note) /* line 71 */ {
			echo '            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Poznámka k objednávce</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">';
			echo LR\Filters::escapeHtmlText($order->note) /* line 77 */;
			echo '</p>
                </div>
            </div>
';
		}
		echo '            
            <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 82 */;
		echo '/user/profile" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Zpět na profil
            </a>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Souhrn objednávky</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Číslo objednávky:</span>
                            <span class="fw-bold">#';
		echo LR\Filters::escapeHtmlText($order->id) /* line 96 */;
		echo '</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Datum vytvoření:</span>
                            <span>';
		echo LR\Filters::escapeHtmlText(($this->filters->date)($order->created_at, 'j.n.Y H:i')) /* line 100 */;
		echo '</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Stav:</span>
                            <span>
';
		if ($order->status == 'pending') /* line 105 */ {
			echo '                                    <span class="badge bg-warning">Čeká na zpracování</span>
';
		} elseif ($order->status == 'processing') /* line 107 */ {
			echo '                                    <span class="badge bg-info">Zpracovává se</span>
';
		} elseif ($order->status == 'shipped') /* line 109 */ {
			echo '                                    <span class="badge bg-primary">Odesláno</span>
';
		} elseif ($order->status == 'delivered') /* line 111 */ {
			echo '                                    <span class="badge bg-success">Doručeno</span>
';
		} elseif ($order->status == 'cancelled') /* line 113 */ {
			echo '                                    <span class="badge bg-danger">Zrušeno</span>
';
		} else /* line 115 */ {
			echo '                                    <span class="badge bg-secondary">';
			echo LR\Filters::escapeHtmlText($order->status) /* line 116 */;
			echo '</span>
';
		}




		echo '                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Celková cena:</span>
                            <span class="fw-bold">';
		echo LR\Filters::escapeHtmlText($order->total_price) /* line 122 */;
		echo ' Kč</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
';
	}
}
