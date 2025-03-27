<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\vendor\ublaboo\datagrid\src\templates\datagrid_filter_range.latte */
final class Template_d6e55a21b4 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\vendor\\ublaboo\\datagrid\\src\\templates\\datagrid_filter_range.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo "\n";
		if ($outer) /* line 8 */ {
			echo '	<div class="row">
		';
			echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item($container['from'], $this->global)->getLabel())?->addAttributes(['class' => 'col-sm-3 control-label']) /* line 10 */;
			echo '
		<div class="col-sm-4">
			';
			echo Nette\Bridges\FormsLatte\Runtime::item($container['from'], $this->global)->getControl() /* line 12 */;
			echo '
		</div>
		';
			echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item($container['to'], $this->global)->getLabel())?->addAttributes(['class' => 'filter-range-delimiter col-sm-1 control-label']) /* line 14 */;
			echo '
		<div class="col-sm-4">
			';
			echo Nette\Bridges\FormsLatte\Runtime::item($container['to'], $this->global)->getControl() /* line 16 */;
			echo '
		</div>
	</div>
';
		} else /* line 19 */ {
			echo '	<div class="datagrid-col-filter-range form-inline">
		<div class="input-group">
			';
			echo Nette\Bridges\FormsLatte\Runtime::item($container['from'], $this->global)->getControl() /* line 22 */;
			echo '

			<div class="input-group-addon datagrid-col-filter-datte-range-delimiter">-</div>

			';
			echo Nette\Bridges\FormsLatte\Runtime::item($container['to'], $this->global)->getControl() /* line 26 */;
			echo '
		</div>
	</div>
';
		}
	}


	public function prepare(): array
	{
		extract($this->params);

		$container = $input /* line 6 */;
		return get_defined_vars();
	}
}
