<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\Catalog/detail.latte */
final class Template_6b43c1210e extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\Catalog/detail.latte';

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
    <div class="row">
        <div class="col-md-6">
';
		if ($product->image_url) /* line 7 */ {
			echo '                <img src="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 8 */;
			echo '/';
			echo LR\Filters::escapeHtmlAttr($product->image_url) /* line 8 */;
			echo '" class="img-fluid rounded" alt="';
			echo LR\Filters::escapeHtmlAttr($product->name) /* line 8 */;
			echo '">
';
		} else /* line 9 */ {
			echo '                <div class="text-center bg-light p-5 rounded">
                    <i class="fas fa-image fa-5x text-secondary"></i>
                </div>
';
		}
		echo '        </div>
        <div class="col-md-6">
            <h1>';
		echo LR\Filters::escapeHtmlText($product->name) /* line 16 */;
		echo '</h1>
            <p class="lead text-primary font-weight-bold">';
		echo LR\Filters::escapeHtmlText($product->price) /* line 17 */;
		echo ' Kč</p>
            
            <div class="my-4">
';
		if ($product->stock_quantity > 0) /* line 20 */ {
			echo '                    <span class="badge bg-success">Skladem: ';
			echo LR\Filters::escapeHtmlText($product->stock_quantity) /* line 21 */;
			echo ' ks</span>
';
		} else /* line 22 */ {
			echo '                    <span class="badge bg-danger">Vyprodáno</span>
';
		}
		echo '            </div>
            
            <div class="my-4">
                <h5>Popis produktu</h5>
                <p>';
		echo LR\Filters::escapeHtmlText($product->description) /* line 29 */;
		echo '</p>
            </div>
            
';
		if ($product->stock_quantity > 0) /* line 32 */ {
			echo '                <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('Cart:add', [$product->id])) /* line 33 */;
			echo '" class="btn btn-lg btn-primary">
                    <i class="fas fa-shopping-cart"></i> Přidat do košíku
                </a>
';
		} else /* line 36 */ {
			echo '                <button class="btn btn-lg btn-secondary" disabled>Vyprodáno</button>
';
		}
		echo '            
            <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 40 */;
		echo '/catalog" class="btn btn-outline-secondary mt-2">Zpět do katalogu</a>
        </div>
    </div>
</div>
';
	}
}
