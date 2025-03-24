<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\Login/default.latte */
final class Template_895713c5a9 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\Login/default.latte';

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

		echo '    <h2>Přihlášení</h2>
';
		$form = $this->global->formsStack[] = $this->global->uiControl['loginForm'] /* line 5 */;
		Nette\Bridges\FormsLatte\Runtime::initializeForm($form);
		echo '    <form';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), [], false) /* line 5 */;
		echo '>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Heslo:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mt-2">
            <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 15 */;
		echo '/user/forgotPassword">Zapomněli jste heslo?</a>
        </div>
        <button type="submit" class="btn btn-primary">Přihlásit se</button>
    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(end($this->global->formsStack), false) /* line 5 */;
		echo '</form>
';
		array_pop($this->global->formsStack);
		echo '
    <p class="mt-2">Nemáte účet? <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 20 */;
		echo '/register">Registrujte se</a></p>
';
	}
}
