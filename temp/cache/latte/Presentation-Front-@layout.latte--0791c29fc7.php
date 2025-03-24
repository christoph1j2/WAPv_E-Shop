<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\@layout.latte */
final class Template_0791c29fc7 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\@layout.latte';

	public const Blocks = [
		['header' => 'blockHeader'],
	];


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo "\n";
		$this->renderBlock('header', get_defined_vars()) /* line 4 */;
	}


	public function prepare(): array
	{
		extract($this->params);

		$this->parentName = '../@layout.latte';
		return get_defined_vars();
	}


	/** {block header} on line 4 */
	public function blockHeader(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 6 */;
		echo '">LaceShop</a>
        <div class="collapse navbar-collapse fs-5">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 10 */;
		echo '/catalog">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 13 */;
		echo '/cart">Košík</a>
                </li>
            </ul>
            <ul class="navbar-nav">
';
		if ($user->loggedIn) /* line 17 */ {
			echo '                    <li class="nav-item"><a class="nav-link" href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 18 */;
			echo '/user/profile">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 19 */;
			echo '/logout">Odhlásit se</a></li>
';
		} else /* line 20 */ {
			echo '                    <li class="nav-item"><a class="nav-link" href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 21 */;
			echo '/login">Přihlášení</a></li>
                    <li class="nav-item"><a class="nav-link" href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 22 */;
			echo '/register">Registrace</a></li>
';
		}
		echo '            </ul>
        </div>
    </nav>
';
	}
}
