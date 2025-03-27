<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\vendor\ublaboo\datagrid\src\Column/../templates/column_status.latte */
final class Template_3b243ad012 extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\vendor\\ublaboo\\datagrid\\src\\Column/../templates/column_status.latte';


	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		if ($this->global->snippetDriver?->renderSnippets($this->blocks[self::LayerSnippet], $this->params)) {
			return;
		}

		echo '
<div class="dropdown">
';
		if ($activeOption) /* line 9 */ {
			if ($status->shouldBeRendered($row)) /* line 10 */ {
				echo '			<button class="dropdown-toggle ';
				echo LR\Filters::escapeHtmlAttr($activeOption->getClass()) /* line 11 */;
				echo ' ';
				echo LR\Filters::escapeHtmlAttr($activeOption->getClassSecondary()) /* line 11 */;
				echo '" type="button" data-toggle="dropdown">
';
				if ($activeOption->getIcon()) /* line 12 */ {
					echo '				<i class="';
					echo LR\Filters::escapeHtmlAttr($iconPrefix) /* line 12 */;
					echo LR\Filters::escapeHtmlAttr($activeOption->getIcon()) /* line 12 */;
					echo '"></i> ';
				}
				echo '
				';
				echo LR\Filters::escapeHtmlText(($this->filters->translate)($activeOption->getText())) /* line 13 */;
				echo ' ';
				if ($status->hasCaret()) /* line 13 */ {
					echo '<i class="caret"></i>
';
				}
				echo '			</button>
';
			} else /* line 15 */ {
				echo '			';
				echo LR\Filters::escapeHtmlText(($this->filters->translate)($activeOption->getText())) /* line 16 */;
				echo "\n";
			}
		} else /* line 18 */ {
			echo '		';
			echo LR\Filters::escapeHtmlText($row->getValue($status->getColumn())) /* line 19 */;
			echo "\n";
		}
		echo '	<ul class="dropdown-menu">
';
		foreach ($status->getOptions() as $option) /* line 22 */ {
			echo '		<li>
';
			$confirmationDialog = $option->getConfirmationDialog($row) /* line 23 */;
			echo '
			<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link('changeStatus!', ['id' => $row->getId(), 'key' => $status->getKey(), 'value' => $option->getValue()])) /* line 27 */;
			echo '"
				class="';
			echo LR\Filters::escapeHtmlAttr($option->getClassInDropdown()) /* line 26 */;
			echo '"
				';
			if ($confirmationDialog) /* line 28 */ {
				echo '
					data-';
				echo LR\Filters::escapeHtmlTag(Ublaboo\DataGrid\Column\Action::$dataConfirmAttributeName) /* line 29 */;
				echo '="';
				echo LR\Filters::escapeHtmlAttr($confirmationDialog) /* line 29 */;
				echo '"
				';
			}
			echo '
			>
';
			if ($option->getIconSecondary()) /* line 32 */ {
				echo '				<i class="datagrid-column-status-option-icon ';
				echo LR\Filters::escapeHtmlAttr($iconPrefix) /* line 32 */;
				echo LR\Filters::escapeHtmlAttr($option->getIconSecondary()) /* line 32 */;
				echo '"></i> ';
			}
			echo '
				';
			echo LR\Filters::escapeHtmlText(($this->filters->translate)($option->getText())) /* line 33 */;
			echo '
			</a>
		</li>
';

		}

		echo '	</ul>
</div>
';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['option' => '22'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$activeOption = $status->getCurrentOption($row) /* line 6 */;
		return get_defined_vars();
	}
}
