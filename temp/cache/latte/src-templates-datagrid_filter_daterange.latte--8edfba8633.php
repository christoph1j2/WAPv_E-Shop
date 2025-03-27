<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\vendor\ublaboo\datagrid\src\templates\datagrid_filter_daterange.latte */
final class Template_8edfba8633 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\vendor\\ublaboo\\datagrid\\src\\templates\\datagrid_filter_daterange.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo "\n";
		if ($outer) /* line 9 */ {
			echo '	<div class="row">
		';
			echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item($container['from'], $this->global)->getLabel())?->addAttributes(['class' => 'col-sm-3 control-label']) /* line 11 */;
			echo '
		<div class="col-sm-4 form-inline">
			<div class="input-group input-group-sm">
				';
			echo Nette\Bridges\FormsLatte\Runtime::item($container['from'], $this->global)->getControl() /* line 14 */;
			echo '
				<div class="input-group-append input-group-addon-first">
					<label';
			echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item($container['from'], $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 16 */;
			echo ' class="input-group-text input-group-text-first">
						<i class="';
			echo LR\Filters::escapeHtmlAttr($iconPrefix) /* line 17 */;
			echo 'calendar"></i>
					</label>
				</div>
			</div>
		</div>
		';
			echo ($ʟ_label = Nette\Bridges\FormsLatte\Runtime::item($container['to'], $this->global)->getLabel())?->addAttributes(['class' => 'filter-range-delimiter col-sm-1 control-label']) /* line 22 */;
			echo '
		<div class="col-sm-4 form-inline">
			<div class="input-group input-group-sm">
				';
			echo Nette\Bridges\FormsLatte\Runtime::item($container['to'], $this->global)->getControl() /* line 25 */;
			echo '
				<div class="input-group-append">
					<label';
			echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item($container['to'], $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 27 */;
			echo ' class="input-group-text">
						<i class="';
			echo LR\Filters::escapeHtmlAttr($iconPrefix) /* line 28 */;
			echo 'calendar"></i>
					</label>
				</div>
			</div>
		</div>
	</div>
';
		} else /* line 34 */ {
			echo '	<div class="datagrid-col-filter-date-range form-inline">
		<div class="input-group input-group-sm">
			';
			echo Nette\Bridges\FormsLatte\Runtime::item($container['from'], $this->global)->getControl() /* line 37 */;
			echo '
			<div class="input-group-append input-group-addon-first">
				<label';
			echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item($container['from'], $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 39 */;
			echo ' class="input-group-text input-group-text-first">
					<i class="';
			echo LR\Filters::escapeHtmlAttr($iconPrefix) /* line 40 */;
			echo 'calendar"></i>
				</label>
			</div>
		</div>

		<div class="input-group-addon datagrid-col-filter-datte-range-delimiter">-</div>

		<div class="input-group input-group-sm">
			';
			echo Nette\Bridges\FormsLatte\Runtime::item($container['to'], $this->global)->getControl() /* line 48 */;
			echo '
			<div class="input-group-append">
				<label';
			echo ($ʟ_elem = Nette\Bridges\FormsLatte\Runtime::item($container['to'], $this->global)->getLabelPart())->addAttributes(['class' => null])->attributes() /* line 50 */;
			echo ' class="input-group-text">
					<i class="';
			echo LR\Filters::escapeHtmlAttr($iconPrefix) /* line 51 */;
			echo 'calendar"></i>
				</label>
			</div>
		</div>
	</div>
';
		}
	}


	public function prepare(): array
	{
		extract($this->params);

		$container = $input /* line 7 */;
		return get_defined_vars();
	}
}
