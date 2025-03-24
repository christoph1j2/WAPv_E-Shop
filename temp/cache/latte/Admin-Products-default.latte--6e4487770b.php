<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Admin\Products/default.latte */
final class Template_6e4487770b extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Admin\\Products/default.latte';

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
			foreach (array_intersect_key(['product' => '28'], $this->params) as $ʟ_v => $ʟ_l) {
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
    <h1 class="mt-4">Správa produktů</h1>
    
    <div class="mb-4">
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 8 */;
		echo '/admin/products/add" class="btn btn-success">
            <i class="fas fa-plus"></i> Přidat nový produkt
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Název</th>
                            <th>Cena</th>
                            <th>Skladem</th>
                            <th>Kategorie</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
';
		foreach ($products as $product) /* line 28 */ {
			echo '                        <tr>
                            <td>';
			echo LR\Filters::escapeHtmlText($product->id) /* line 30 */;
			echo '</td>
                            <td>';
			echo LR\Filters::escapeHtmlText($product->name) /* line 31 */;
			echo '</td>
                            <td>';
			echo LR\Filters::escapeHtmlText($product->price) /* line 32 */;
			echo ' Kč</td>
                            <td>
';
			if ($product->stock_quantity <= 0) /* line 34 */ {
				echo '                                    <span class="badge bg-danger">Vyprodáno</span>
';
			} elseif ($product->stock_quantity < 5) /* line 36 */ {
				echo '                                    <span class="badge bg-warning">';
				echo LR\Filters::escapeHtmlText($product->stock_quantity) /* line 37 */;
				echo ' ks</span>
';
			} else /* line 38 */ {
				echo '                                    <span class="badge bg-success">';
				echo LR\Filters::escapeHtmlText($product->stock_quantity) /* line 39 */;
				echo ' ks</span>
';
			}

			echo '                            </td>
                            <td>';
			echo LR\Filters::escapeHtmlText($product->ref('categories', 'category_id')->name) /* line 42 */;
			echo '</td>
                            <td>
                                <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 44 */;
			echo '/admin/products/edit/';
			echo LR\Filters::escapeHtmlAttr($product->id) /* line 44 */;
			echo '" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Upravit
                                </a>
                                <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 47 */;
			echo '/admin/products/delete/';
			echo LR\Filters::escapeHtmlAttr($product->id) /* line 47 */;
			echo '" class="btn btn-sm btn-danger" 
                                   onclick="return confirm(\'Opravdu chcete smazat tento produkt?\');">
                                    <i class="fas fa-trash"></i> Smazat
                                </a>
                            </td>
                        </tr>
';

		}

		echo '                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
';
	}
}
