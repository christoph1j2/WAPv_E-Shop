<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\Home/default.latte */
final class Template_2bf969fc4c extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\Home/default.latte';

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

		echo '<!-- Hero Banner - centered horizontally with appropriate padding -->
<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="text-white p-5 text-center rounded shadow" style="background: linear-gradient(135deg, #1F2937 0%, #9A3412 100%);">
                <h1 class="display-4 fw-bold mb-4">Vítejte v našem e-shopu</h1>
                <p class="lead mb-4">Objevte naši nabídku kvalitních produktů za skvělé ceny</p>
                <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 11 */;
		echo '/catalog" class="btn btn-lg px-4 py-2" style="background-color: #F97316; color: white; border: none;">
                    Prohlédnout katalog
                </a>
            </div>
        </div>
    </div>
</div>
';
	}
}
