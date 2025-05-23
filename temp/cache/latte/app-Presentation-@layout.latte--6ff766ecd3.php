<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\@layout.latte */
final class Template_6ff766ecd3 extends Latte\Runtime\Template
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/nette.ajax.js/nette.ajax.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/ublaboo-datagrid/assets/datagrid.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/ublaboo-datagrid/assets/datagrid.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ublaboo-datagrid/assets/datagrid-instant-url-refresh.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/ublaboo-datagrid/assets/datagrid-spinners.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/ublaboo-datagrid/assets/datagrid-spinners.js"></script>
</head>
<body class="d-flex flex-column min-vh-100"> <!-- Přidáno flexbox -->
    <header class="bg-dark text-white p-3">
        <h1 class="text-center">';
		$this->renderBlock('header', get_defined_vars()) /* line 27 */;
		echo '</h1>
    </header>

    <main class="flex-grow-1 container py-4"> <!-- Flex-grow pro vyplnění -->
';
		$this->renderBlock('flashes', get_defined_vars()) /* line 31 */;
		$this->renderBlock('content', get_defined_vars()) /* line 38 */;
		echo '    </main>
    <footer class="bg-dark text-white text-center p-3 mt-4">
        <p>';
		$this->renderBlock('footer', get_defined_vars()) /* line 41 */;
		echo '</p>
    </footer>
';
		$this->renderBlock('scripts', get_defined_vars()) /* line 45 */;
		echo '</body>
</html>


';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['flash' => '32'], $this->params) as $ʟ_v => $ʟ_l) {
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


	/** {block header} on line 27 */
	public function blockHeader(array $ʟ_args): void
	{
		echo 'LaceShop';
	}


	/** {block flashes} on line 31 */
	public function blockFlashes(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		foreach ($flashes as $flash) /* line 32 */ {
			echo '                <div class="alert alert-';
			echo LR\Filters::escapeHtmlAttr($flash->type) /* line 33 */;
			echo '">
                    ';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 34 */;
			echo '
                </div>
';

		}
	}


	/** {block content} on line 38 */
	public function blockContent(array $ʟ_args): void
	{
	}


	/** {block footer} on line 41 */
	public function blockFooter(array $ʟ_args): void
	{
		echo '&copy; 2025 LaceShop. Všechna práva vyhrazena.';
	}


	/** {block scripts} on line 45 */
	public function blockScripts(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    		<script src="https://unpkg.com/nette-forms@3/src/assets/netteForms.js"></script>
    <script>
        $(function() {
            // Inicializace Nette.ajax
            $.nette.init();

            // Zaplata pro Datagrid
            $(\'[data-toggle]\').each(function ()
            {
                const $el = $(this);
                const toggle = $el.attr(\'data-toggle\');

                $el.attr(\'data-bs-toggle\', toggle);
                // Mozna prilis "brutalni"
                // $el.removeAttr(\'data-toggle\');
            });
        });
    </script>
';
	}
}
