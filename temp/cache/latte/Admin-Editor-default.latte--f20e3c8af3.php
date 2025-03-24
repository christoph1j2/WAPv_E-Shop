<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Admin\Editor/default.latte */
final class Template_f20e3c8af3 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Admin\\Editor/default.latte';

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
			foreach (array_intersect_key(['product' => '59', 'order' => '105'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '<div class="container-fluid">
    <h1 class="mt-4">Editor Dashboard</h1>
    <p>Vítejte v editační sekci. Zde můžete spravovat produkty a prohlížet objednávky.</p>
    
    <div class="row mt-4">
        <div class="col-xl-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Celkem produktů</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">';
		echo LR\Filters::escapeHtmlText($totalProducts) /* line 16 */;
		echo '</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 29 */;
		echo '/admin/products" class="btn btn-primary mb-3">
                <i class="fas fa-box"></i> Správa produktů
            </a>
        </div>
        <div class="col-md-6">
            <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 34 */;
		echo '/admin/orders" class="btn btn-secondary mb-3">
                <i class="fas fa-shopping-cart"></i> Přehled objednávek
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nedávné produkty</h6>
                </div>
                <div class="card-body">
';
		if ($recentProducts && count($recentProducts)) /* line 47 */ {
			echo '                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Název</th>
                                        <th>Skladem</th>
                                        <th>Cena</th>
                                        <th>Akce</th>
                                    </tr>
                                </thead>
                                <tbody>
';
			foreach ($recentProducts as $product) /* line 59 */ {
				echo '                                    <tr>
                                        <td>';
				echo LR\Filters::escapeHtmlText($product->name) /* line 61 */;
				echo '</td>
                                        <td>
';
				if ($product->stock_quantity <= 0) /* line 63 */ {
					echo '                                                <span class="badge bg-danger">Vyprodáno</span>
';
				} elseif ($product->stock_quantity < 5) /* line 65 */ {
					echo '                                                <span class="badge bg-warning">';
					echo LR\Filters::escapeHtmlText($product->stock_quantity) /* line 66 */;
					echo ' ks</span>
';
				} else /* line 67 */ {
					echo '                                                <span class="badge bg-success">';
					echo LR\Filters::escapeHtmlText($product->stock_quantity) /* line 68 */;
					echo ' ks</span>
';
				}

				echo '                                        </td>
                                        <td>';
				echo LR\Filters::escapeHtmlText($product->price) /* line 71 */;
				echo ' Kč</td>
                                        <td>
                                            <a href="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 73 */;
				echo '/admin/products/edit/';
				echo LR\Filters::escapeHtmlAttr($product->id) /* line 73 */;
				echo '" class="btn btn-sm btn-primary">Upravit</a>
                                        </td>
                                    </tr>
';

			}

			echo '                                </tbody>
                            </table>
                        </div>
';
		} else /* line 80 */ {
			echo '                        <p>Žádné nedávné produkty.</p>
';
		}
		echo '                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nedávné objednávky</h6>
                </div>
                <div class="card-body">
';
		if ($recentOrders && count($recentOrders)) /* line 93 */ {
			echo '                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Stav</th>
                                        <th>Datum</th>
                                        <th>Akce</th>
                                    </tr>
                                </thead>
                                <tbody>
';
			foreach ($recentOrders as $order) /* line 105 */ {
				echo '                                    <tr>
                                        <td>#';
				echo LR\Filters::escapeHtmlText($order->id) /* line 107 */;
				echo '</td>
                                        <td>
';
				if ($order->status == 'pending') /* line 109 */ {
					echo '                                                <span class="badge bg-warning">Čeká na zpracování</span>
';
				} elseif ($order->status == 'processing') /* line 111 */ {
					echo '                                                <span class="badge bg-info">Zpracovává se</span>
';
				} elseif ($order->status == 'shipped') /* line 113 */ {
					echo '                                                <span class="badge bg-primary">Odesláno</span>
';
				} elseif ($order->status == 'delivered') /* line 115 */ {
					echo '                                                <span class="badge bg-success">Doručeno</span>
';
				} elseif ($order->status == 'cancelled') /* line 117 */ {
					echo '                                                <span class="badge bg-danger">Zrušeno</span>
';
				}




				echo '                                        </td>
                                        <td>';
				echo LR\Filters::escapeHtmlText(($this->filters->date)($order->created_at, 'j.n.Y')) /* line 121 */;
				echo '</td>
                                        <td>
                                            <a href="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 123 */;
				echo '/admin/orders/detail/';
				echo LR\Filters::escapeHtmlAttr($order->id) /* line 123 */;
				echo '" class="btn btn-sm btn-primary">Detail</a>
                                        </td>
                                    </tr>
';

			}

			echo '                                </tbody>
                            </table>
                        </div>
';
		} else /* line 130 */ {
			echo '                        <p>Žádné nedávné objednávky.</p>
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
