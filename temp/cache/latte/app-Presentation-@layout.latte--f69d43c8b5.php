<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\@layout.latte */
final class Template_f69d43c8b5 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\@layout.latte';

	public const Blocks = [
		['title' => 'blockTitle', 'pageTitle' => 'blockPageTitle', 'header' => 'blockHeader', 'flashes' => 'blockFlashes', 'content' => 'blockContent', 'footer' => 'blockFooter', 'scripts' => 'blockScripts'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo '<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>';
		$this->renderBlock('title', get_defined_vars()) /* line 7 */;
		echo '</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 9 */;
		echo '/css/styles.css">
</head>
<body class="d-flex flex-column min-vh-100"> <!-- Přidáno flexbox -->
    <header class="bg-dark text-white p-3">
        <h1 class="text-center">';
		$this->renderBlock('header', get_defined_vars()) /* line 13 */;
		echo '</h1>
    </header>

    <main class="flex-grow-1 container py-4"> <!-- Flex-grow pro vyplnění -->
';
		$this->renderBlock('flashes', get_defined_vars()) /* line 17 */;
		$this->renderBlock('content', get_defined_vars()) /* line 24 */;
		echo '    </main>

    <footer class="bg-dark text-white text-center p-3 mt-4">
        <p>';
		$this->renderBlock('footer', get_defined_vars()) /* line 28 */;
		echo '</p>
    </footer>
';
		$this->renderBlock('scripts', get_defined_vars()) /* line 31 */;
		echo '</body>
</html>


';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['flash' => '18'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}


	/** {block title} on line 7 */
	public function blockTitle(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo 'LaceShop ';
		$this->renderBlock('pageTitle', get_defined_vars()) /* line 7 */;
	}


	/** {block pageTitle} on line 7 */
	public function blockPageTitle(array $ʟ_args): void
	{
	}


	/** {block header} on line 13 */
	public function blockHeader(array $ʟ_args): void
	{
		echo 'LaceShop';
	}


	/** {block flashes} on line 17 */
	public function blockFlashes(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		foreach ($flashes as $flash) /* line 18 */ {
			echo '                <div class="alert alert-';
			echo LR\Filters::escapeHtmlAttr($flash->type) /* line 19 */;
			echo '">
                    ';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 20 */;
			echo '
                </div>
';

		}
	}


	/** {block content} on line 24 */
	public function blockContent(array $ʟ_args): void
	{
	}


	/** {block footer} on line 28 */
	public function blockFooter(array $ʟ_args): void
	{
		echo '&copy; 2025 LaceShop. Všechna práva vyhrazena.';
	}


	/** {block scripts} on line 31 */
	public function blockScripts(array $ʟ_args): void
	{
		echo '	<script src="https://unpkg.com/nette-forms@3"></script>
';
	}
}
