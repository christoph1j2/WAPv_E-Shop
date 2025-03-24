<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Admin\@layout.latte */
final class Template_ef8905a8d1 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Admin\\@layout.latte';

	public const Blocks = [
		['header' => 'blockHeader', 'footer' => 'blockFooter'],
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
		echo "\n";
		$this->renderBlock('footer', get_defined_vars()) /* line 22 */;
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

		echo '    <nav class="navbar navbar-expand-lg navbar-dark ">
';
		if ($user->isInRole('admin')) /* line 6 */ {
			echo '            <a class="navbar-brand" href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 7 */;
			echo '/admin/dashboard" style="font-size: 1rem;">Admin Dashboard</a>
';
		} else /* line 8 */ {
			echo '            <a class="navbar-brand" href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 9 */;
			echo '/admin/editor" style="font-size: 1rem;">Editor Dashboard</a>
';
		}
		echo '        <ul class="navbar-nav" style="font-size: 0.875rem;">
            <li class="nav-item"><a class="nav-link" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 12 */;
		echo '/admin/products">Produkty</a></li>
            <li class="nav-item"><a class="nav-link" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 13 */;
		echo '/admin/orders">Objednávky</a></li>
';
		if ($user->isInRole('admin')) /* line 14 */ {
			echo '                <li class="nav-item"><a class="nav-link" href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 15 */;
			echo '/admin/users">Uživatelé</a></li>
';
		}
		echo '            <li class="nav-item"><a class="nav-link" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 17 */;
		echo '/logout">Odhlásit se</a></li>
        </ul>
    </nav>
';
	}


	/** {block footer} on line 22 */
	public function blockFooter(array $ʟ_args): void
	{
		echo '    <p>Admin rozhraní LaceShopu. Všechna práva vyhrazena.</p>
';
	}
}
