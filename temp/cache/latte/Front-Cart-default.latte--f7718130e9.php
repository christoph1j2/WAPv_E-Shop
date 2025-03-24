<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\Cart/default.latte */
final class Template_f7718130e9 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\Cart/default.latte';

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
			foreach (array_intersect_key(['item' => '20'], $this->params) as $ʟ_v => $ʟ_l) {
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
    <h1>Váš košík</h1>
    
';
		if (count($cartItems) > 0) /* line 7 */ {
			echo '    <div class="table-responsive mb-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Cena za kus</th>
                    <th>Množství</th>
                    <th>Celkem</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
';
			foreach ($cartItems as $item) /* line 20 */ {
				echo '                <tr>
                    <td>
                        <a href="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 23 */;
				echo '/catalog/product/';
				echo LR\Filters::escapeHtmlAttr($item['product']->id) /* line 23 */;
				echo '">';
				echo LR\Filters::escapeHtmlText($item['product']->name) /* line 23 */;
				echo '</a>
                    </td>
                    <td>';
				echo LR\Filters::escapeHtmlText($item['product']->price) /* line 25 */;
				echo ' Kč</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('updateQuantity!', ['productId' => $item['product']->id, 'quantity' => $item['quantity'] - 1])) /* line 28 */;
				echo '" class="btn btn-sm btn-outline-secondary me-2">-</a>
                            <span>';
				echo LR\Filters::escapeHtmlText($item['quantity']) /* line 29 */;
				echo '</span>
                            <a href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('updateQuantity!', ['productId' => $item['product']->id, 'quantity' => $item['quantity'] + 1])) /* line 30 */;
				echo '" class="btn btn-sm btn-outline-secondary ms-2">+</a>
                        </div>
                    </td>
                    <td>';
				echo LR\Filters::escapeHtmlText($item['price']) /* line 33 */;
				echo ' Kč</td>
                    <td>
                        <a href="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 35 */;
				echo '/cart/remove/';
				echo LR\Filters::escapeHtmlAttr($item['product']->id) /* line 35 */;
				echo '" class="btn btn-sm btn-danger" onclick="return confirm(\'Opravdu chcete odstranit tento produkt z košíku?\')">
                            <i class="fas fa-trash"></i> Odstranit
                        </a>
                    </td>
                </tr>
';

			}

			echo '            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Celková cena:</th>
                    <th>';
			echo LR\Filters::escapeHtmlText($totalPrice) /* line 45 */;
			echo ' Kč</th>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 53 */;
			echo '/catalog" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Pokračovat v nákupu
        </a>
        <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 56 */;
			echo '/cart/checkout" class="btn btn-success">
            <i class="fas fa-check"></i> Dokončit objednávku
        </a>
    </div>
';
		} else /* line 60 */ {
			echo '    <div class="alert alert-info">
        <p>Váš košík je prázdný.</p>
        <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 63 */;
			echo '/catalog" class="btn btn-primary mt-2">Přejít do katalogu</a>
    </div>
';
		}
		echo '</div>
';
	}
}
