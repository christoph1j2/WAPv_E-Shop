<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\vendor\ublaboo\datagrid\src\templates\datagrid_filter_select.latte */
final class Template_bd9756a437 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\vendor\\ublaboo\\datagrid\\src\\templates\\datagrid_filter_select.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		if ($outer) /* line 6 */ {
			echo '	<div class="row">
		';
			echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item($input, $this->global)->getLabel())?->addAttributes(['class' => 'col-sm-3 control-label']) /* line 8 */;
			echo '
		<div class="col-sm-9">
			';
			echo Nette\Bridges\FormsLatte\Runtime::item($input, $this->global)->getControl() /* line 10 */;
			echo '
		</div>
	</div>
';
		} else /* line 13 */ {
			echo '	';
			echo Nette\Bridges\FormsLatte\Runtime::item($input, $this->global)->getControl() /* line 14 */;
			echo "\n";
		}
	}
}
