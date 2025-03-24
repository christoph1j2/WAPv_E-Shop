<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\Catalog/default.latte */
final class Template_d548615c44 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\Catalog/default.latte';

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
			foreach (array_intersect_key(['product' => '6'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '    <h2>Katalog produktů</h2>
    <div class="row">
';
		foreach ($products as $product) /* line 6 */ {
			echo '            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 9 */;
			echo '/';
			echo LR\Filters::escapeHtmlAttr($product->image_url) /* line 9 */;
			echo '" class="card-img-top" alt="';
			echo LR\Filters::escapeHtmlAttr($product->name) /* line 9 */;
			echo '">
                    <div class="card-body">
                        <h5 class="card-title">';
			echo LR\Filters::escapeHtmlText($product->name) /* line 11 */;
			echo '</h5>
                        <p class="card-text">';
			echo LR\Filters::escapeHtmlText(($this->filters->truncate)($product->description, 100)) /* line 12 */;
			echo '</p>
                        <p class="card-text">Cena: ';
			echo LR\Filters::escapeHtmlText($product->price) /* line 13 */;
			echo ' Kč</p>
                        <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 14 */;
			echo '/catalog/product/';
			echo LR\Filters::escapeHtmlAttr($product->id) /* line 14 */;
			echo '" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
';

		}

		echo '    </div>
';
	}
}
