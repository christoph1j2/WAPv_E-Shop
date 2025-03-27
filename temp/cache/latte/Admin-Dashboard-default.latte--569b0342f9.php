<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Admin\Dashboard/default.latte */
final class Template_569b0342f9 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Admin\\Dashboard/default.latte';

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
			foreach (array_intersect_key(['order' => '80', 'product' => '129'], $this->params) as $ʟ_v => $ʟ_l) {
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
    <h1 class="mt-4">Admin Dashboard</h1>
    
    <div class="row mt-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Celkem produktů</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">';
		echo LR\Filters::escapeHtmlText($totalProducts) /* line 15 */;
		echo '</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Celkem objednávek</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">';
		echo LR\Filters::escapeHtmlText($totalOrders) /* line 32 */;
		echo '</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Celkem uživatelů</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">';
		echo LR\Filters::escapeHtmlText($totalUsers) /* line 49 */;
		echo '</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nedávné objednávky</h6>
                </div>
                <div class="card-body">
';
		if ($recentOrders && count($recentOrders)) /* line 67 */ {
			echo '                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Zákazník</th>
                                        <th>Stav</th>
                                        <th>Datum</th>
                                        <th>Celkem</th>
                                    </tr>
                                </thead>
                                <tbody>
';
			foreach ($recentOrders as $order) /* line 80 */ {
				echo '                                    <tr>
                                        <td>#';
				echo LR\Filters::escapeHtmlText($order->id) /* line 82 */;
				echo '</td>
                                        <td>';
				echo LR\Filters::escapeHtmlText($order->user_id ? $order->ref('users', 'user_id')->name : 'Neznámý') /* line 83 */;
				echo '</td>
                                        <td>
';
				if ($order->status == 'pending') /* line 85 */ {
					echo '                                                <span class="badge bg-warning">Čeká na zpracování</span>
';
				} elseif ($order->status == 'processing') /* line 87 */ {
					echo '                                                <span class="badge bg-info">Zpracovává se</span>
';
				} elseif ($order->status == 'shipped') /* line 89 */ {
					echo '                                                <span class="badge bg-primary">Odesláno</span>
';
				} elseif ($order->status == 'delivered') /* line 91 */ {
					echo '                                                <span class="badge bg-success">Doručeno</span>
';
				} elseif ($order->status == 'cancelled') /* line 93 */ {
					echo '                                                <span class="badge bg-danger">Zrušeno</span>
';
				}




				echo '                                        </td>
                                        <td>';
				echo LR\Filters::escapeHtmlText(($this->filters->date)($order->created_at, 'j.n.Y')) /* line 97 */;
				echo '</td>
                                        <td>';
				echo LR\Filters::escapeHtmlText($order->total_price) /* line 98 */;
				echo ' Kč</td>
                                    </tr>
';

			}

			echo '                                </tbody>
                            </table>
                        </div>
';
		} else /* line 104 */ {
			echo '                        <p>Žádné nedávné objednávky.</p>
';
		}
		echo '                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produkty s nízkým stavem skladu</h6>
                </div>
                <div class="card-body">
';
		if ($lowStockProducts && count($lowStockProducts)) /* line 117 */ {
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
			foreach ($lowStockProducts as $product) /* line 129 */ {
				echo '                                    <tr>
                                        <td>';
				echo LR\Filters::escapeHtmlText($product->name) /* line 131 */;
				echo '</td>
                                        <td>
';
				if ($product->stock_quantity <= 0) /* line 133 */ {
					echo '                                                <span class="badge bg-danger">Vyprodáno</span>
';
				} elseif ($product->stock_quantity < 5) /* line 135 */ {
					echo '                                                <span class="badge bg-warning">';
					echo LR\Filters::escapeHtmlText($product->stock_quantity) /* line 136 */;
					echo ' ks</span>
';
				} else /* line 137 */ {
					echo '                                                <span class="badge bg-success">';
					echo LR\Filters::escapeHtmlText($product->stock_quantity) /* line 138 */;
					echo ' ks</span>
';
				}

				echo '                                        </td>
                                        <td>';
				echo LR\Filters::escapeHtmlText($product->price) /* line 141 */;
				echo ' Kč</td>
                                        <td>
                                            <a href="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 143 */;
				echo '/admin/products/edit/';
				echo LR\Filters::escapeHtmlAttr($product->id) /* line 143 */;
				echo '" class="btn btn-sm btn-primary">Upravit</a>
                                        </td>
                                    </tr>
';

			}

			echo '                                </tbody>
                            </table>
                        </div>
';
		} else /* line 150 */ {
			echo '                        <p>Všechny produkty mají dostatečný stav skladu.</p>
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
