<?php
namespace App\Filament\Affiliate\Widgets;

use App\Models\AffiliateHistory;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AffiliateChart extends ChartWidget
{
    protected static ?string $heading = 'Estatísticas de Conversão';
    protected int | string | array $columnSpan = 'full';

    /**
     * Retorna os dados para o gráfico
     * @return array
     */
    protected function getData(): array
    {
        $data = $this->getComissionPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'Estatísticas de Conversão',
                    'data' => $data['comissionsPerMonth'],
                ],
            ],
            'labels' => $data['months'],
        ];
    }

    /**
     * Define o tipo de gráfico
     * @return string
     */
    protected function getType(): string
    {
        return 'line';
    }

    /**
     * Obtém as comissões por mês
     * @return array
     */
    private function getComissionPerMonth(): array
    {
        $now = Carbon::now();
        $comissionsPerMonth = [];
        $months = [];

        // Loop pelos meses de 1 a 12
        for ($month = 1; $month <= 12; $month++) {
            // Calcula a soma das comissões para o mês atual
            $sum = AffiliateHistory::where('inviter', auth()->id())
                ->where('commission_type', 'revshare')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $now->year)  // Filtra pelo ano atual
                ->sum('commission_paid');

            $comissionsPerMonth[] = $sum;

            // Obtém o nome abreviado do mês (Jan, Feb, etc.)
            $months[] = Carbon::createFromDate(null, $month)->format('M');
        }

        return [
            'comissionsPerMonth' => $comissionsPerMonth,
            'months' => $months
        ];
    }

    /**
     * Verifica se o widget pode ser visualizado
     * @return bool
     */
    public static function canView(): bool
    {
        return auth()->user()->hasRole('afiliado');
    }
}
