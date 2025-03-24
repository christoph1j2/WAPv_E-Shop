<?php

declare(strict_types=1);

use Latte\Runtime as LR;

/** source: C:\xampp\htdocs\WAPv_E-Shop\app\Presentation\Front\User/profile.latte */
final class Template_458122e88a extends Latte\Runtime\Template
{
	public const Source = 'C:\\xampp\\htdocs\\WAPv_E-Shop\\app\\Presentation\\Front\\User/profile.latte';

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
			foreach (array_intersect_key(['order' => '28'], $this->params) as $ʟ_v => $ʟ_l) {
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

		echo '    <h2>Profil uživatele</h2>
    <p><strong>Jméno:</strong> ';
		echo LR\Filters::escapeHtmlText($userData->name) /* line 5 */;
		echo '</p>
    <p><strong>E-mail:</strong> ';
		echo LR\Filters::escapeHtmlText($userData->email) /* line 6 */;
		echo '</p>
    <p><strong>Telefon:</strong> ';
		echo LR\Filters::escapeHtmlText($userData->phone) /* line 7 */;
		echo '</p>
    <p><strong>Adresa:</strong> ';
		echo LR\Filters::escapeHtmlText($userData->address) /* line 8 */;
		echo '</p>

    <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 10 */;
		echo '/user/edit" class="btn btn-primary mt-2">Upravit profil</a>
    <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 11 */;
		echo '/user/changePassword" class="btn btn-warning mt-2">Změna hesla</a>
    <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 12 */;
		echo '/logout" class="btn btn-danger mt-2">Odhlásit se</a>
    
    <h3 class="mt-4">Moje objednávky</h3>
    
';
		if (isset($orders) && count($orders)) /* line 16 */ {
			echo '        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Číslo objednávky</th>
                    <th>Datum</th>
                    <th>Stav</th>
                    <th>Celková cena</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
';
			foreach ($orders as $order) /* line 28 */ {
				echo '                    <tr>
                        <td>#';
				echo LR\Filters::escapeHtmlText($order->id) /* line 30 */;
				echo '</td>
                        <td>';
				echo LR\Filters::escapeHtmlText(($this->filters->date)($order->created_at, 'j.n.Y H:i')) /* line 31 */;
				echo '</td>
                        <td>
';
				if ($order->status == 'pending') /* line 33 */ {
					echo '                                <span class="badge bg-warning">Čeká na zpracování</span>
';
				} elseif ($order->status == 'processing') /* line 35 */ {
					echo '                                <span class="badge bg-info">Zpracovává se</span>
';
				} elseif ($order->status == 'shipped') /* line 37 */ {
					echo '                                <span class="badge bg-primary">Odesláno</span>
';
				} elseif ($order->status == 'delivered') /* line 39 */ {
					echo '                                <span class="badge bg-success">Doručeno</span>
';
				} elseif ($order->status == 'cancelled') /* line 41 */ {
					echo '                                <span class="badge bg-danger">Zrušeno</span>
';
				} else /* line 43 */ {
					echo '                                <span class="badge bg-secondary">';
					echo LR\Filters::escapeHtmlText($order->status) /* line 44 */;
					echo '</span>
';
				}




				echo '                        </td>
                        <td>';
				echo LR\Filters::escapeHtmlText($order->total_price) /* line 47 */;
				echo ' Kč</td>
                        <td>
                            <a href="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 49 */;
				echo '/user/orderDetail/';
				echo LR\Filters::escapeHtmlAttr($order->id) /* line 49 */;
				echo '" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>
';

			}

			echo '            </tbody>
        </table>
';
		} else /* line 55 */ {
			echo '        <p class="mt-3">Zatím nemáte žádné objednávky.</p>
';
		}
	}
}
