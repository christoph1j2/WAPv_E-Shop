<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Admin\Orders/default.latte */
final class Template_5ae8c8c77b extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Admin\\Orders/default.latte';

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

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['order' => '22'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$this->parentName = '../@layout.latte';
		return get_defined_vars();
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<div class="container-fluid mt-4">
    <h1>Správa objednávek</h1>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="ordersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Zákazník</th>
                            <th>Datum</th>
                            <th>Celková cena</th>
                            <th>Stav</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
';
		foreach ($orders as $order) /* line 22 */ {
			echo '                            <tr>
                                <td>#';
			echo LR\Filters::escapeHtmlText($order->id) /* line 24 */;
			echo '</td>
                                <td>
';
			if ($order->user_id) /* line 26 */ {
				echo '                                        <span href="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 27 */;
				echo '/admin/users/detail/';
				echo LR\Filters::escapeHtmlAttr($order->user_id) /* line 27 */;
				echo '">
                                            ID: ';
				echo LR\Filters::escapeHtmlText($order->user_id) /* line 28 */;
				echo '
                                        </span>
';
			} else /* line 30 */ {
				echo '                                        <span class="text-muted">Host</span>
';
			}
			echo '                                </td>
                                <td>';
			echo LR\Filters::escapeHtmlText(($this->filters->date)($order->created_at, 'j.n.Y H:i')) /* line 34 */;
			echo '</td>
                                <td>';
			echo LR\Filters::escapeHtmlText($order->total_price) /* line 35 */;
			echo ' Kč</td>
                                <td>
';
			if ($order->status == 'pending') /* line 37 */ {
				echo '                                        <span class="badge bg-warning text-dark">Čeká na zpracování</span>
';
			} elseif ($order->status == 'processing') /* line 39 */ {
				echo '                                        <span class="badge bg-info">Zpracovává se</span>
';
			} elseif ($order->status == 'shipped') /* line 41 */ {
				echo '                                        <span class="badge bg-primary">Odesláno</span>
';
			} elseif ($order->status == 'delivered') /* line 43 */ {
				echo '                                        <span class="badge bg-success">Doručeno</span>
';
			} elseif ($order->status == 'cancelled') /* line 45 */ {
				echo '                                        <span class="badge bg-danger">Zrušeno</span>
';
			} else /* line 47 */ {
				echo '                                        <span class="badge bg-secondary">';
				echo LR\Filters::escapeHtmlText($order->status) /* line 48 */;
				echo '</span>
';
			}




			echo '                                </td>
                                <td>
                                    <a href="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 52 */;
			echo '/admin/orders/detail/';
			echo LR\Filters::escapeHtmlAttr($order->id) /* line 52 */;
			echo '" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
';

		}

		echo '                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(\'#ordersTable\').DataTable({
        order: [[2, \'desc\']], // Řazení podle datumu (3. sloupec) sestupně
        language: {
            url: \'//cdn.datatables.net/plug-ins/1.10.22/i18n/cs.json\'
        }
    });
});
</script>
';
	}
}
