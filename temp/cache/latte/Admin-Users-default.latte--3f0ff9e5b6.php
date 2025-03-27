<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Admin\Users/default.latte */
final class Template_3f0ff9e5b6 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Admin\\Users/default.latte';

	public const Blocks = [
		0 => ['content' => 'blockContent'],
		'snippet' => ['grid' => 'blockGrid'],
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

		echo LR\Filters::escapeHtmlText($pageTitle) /* line 4 */;
		echo "\n";
		echo '<div id="', htmlspecialchars($this->global->snippetDriver->getHtmlId('grid')), '">';
		$this->renderBlock('grid', [], null, 'snippet') /* line 5 */;
		echo '</div>
';
	}


	/** {snippet grid} on line 5 */
	public function blockGrid(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		$this->global->snippetDriver->enter('grid', 'static') /* line 5 */;
		try {
			echo "\n";
			$ʟ_tmp = $this->global->uiControl->getComponent('usersGrid');
			if ($ʟ_tmp instanceof Nette\Application\UI\Renderable) $ʟ_tmp->redrawControl(null, false);
			$ʟ_tmp->render() /* line 6 */;


		} finally {
			$this->global->snippetDriver->leave();
		}
	}
}
