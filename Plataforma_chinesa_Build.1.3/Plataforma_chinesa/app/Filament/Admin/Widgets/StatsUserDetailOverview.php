<?php
namespace App\Filament\Admin\Widgets;

use App\Models\AffiliateHistory;
use App\Models\Order;
use App\Models\Bau;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Helpers\Core as Helper;
use Illuminate\Support\Facades\DB;

class StatsUserDetailOverview extends BaseWidget
{

    public User $record;

    public function mount($record)
    {
       $this->record = $record;
    }

    /**
     * @return array|Stat[]
     */
    protected function getStats(): array
    {
        $totalGanhos = Order::where('user_id', $this->record->id)->where('type', 'win')->sum('amount');
        $totalPerdas = Order::where('user_id', $this->record->id)->where('type', 'bet')->sum('amount');
    
        // Ganho CPA
        $ganhoCpa = AffiliateHistory::where('inviter', $this->record->id)
            ->whereIn('status', [0, 1])
            ->sum('commission_paid') 
            + AffiliateHistory::where('inviter', $this->record->id)
            ->whereIn('status', [0, 1])
            ->sum('receita');
    
        // Obtém o valor de cada baú a partir da tabela `users`
        $bauValue = $this->record->affiliate_bau_value;
    
        // Calcula o GANHO BAU
        $ganhoBau = Bau::where('user_id', $this->record->id)
            ->whereIn('status', [2, 3])
            ->count() * $bauValue;
    
        // Contagem dos Baús Abertos
        $bausAbertos = Bau::where('user_id', $this->record->id)
            ->where('status', 3) // Status 3 para baús abertos
            ->count();
    
        // Lucro Afiliado (CPA + Baús)
        $lucroAfiliado = $ganhoCpa + $ganhoBau;
    
        $trouxeDeDepositantes = AffiliateHistory::where('inviter', $this->record->id)
            ->where('status', 1)
            ->where('deposited', '>', 0)
            ->count();
    
        $trouxeDeClientes = AffiliateHistory::where('inviter', $this->record->id)
            ->count();
    
        $trouxeDeLucro = AffiliateHistory::where('inviter', $this->record->id)
            ->whereIn('status', [0, 1])
            ->sum(DB::raw('deposited + deposited_amount'));
    
        return [
            Stat::make('TOTAL DE GANHO', Helper::amountFormatDecimal(Helper::formatNumber($totalGanhos)))
                ->description('Total de ganhos das apostas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
    
            Stat::make('TOTAL DE PERDAS', Helper::amountFormatDecimal(Helper::formatNumber($totalPerdas)))
                ->description('Total de perdas das apostas')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
    
            Stat::make('GANHO CPA', Helper::amountFormatDecimal(Helper::formatNumber($ganhoCpa)))
                ->description('Ganho como afiliado (CPA)')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
    
            Stat::make('GANHO BAU', Helper::amountFormatDecimal(Helper::formatNumber($ganhoBau)))
                ->description('Ganho total de baús')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
    
            Stat::make('BAUS ABERTOS', $bausAbertos)
                ->description('Total de baús abertos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
    
            Stat::make('LUCRO AFILIADO', Helper::amountFormatDecimal(Helper::formatNumber($lucroAfiliado)))
                ->description('Lucro total do afiliado (CPA + Baús)')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
    
            Stat::make('TROUXE DE DEPOSITANTES', $trouxeDeDepositantes)
                ->description('Quantidade de depositantes trazidos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
    
            Stat::make('TROUXE DE LUCRO', Helper::amountFormatDecimal(Helper::formatNumber($trouxeDeLucro)))
                ->description('Quantidade de lucro trazido')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('success')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
    
            Stat::make('TROUXE DE CLIENTES', $trouxeDeClientes)
                ->description('Total de clientes trazidos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([10, 20, 15, 30, 25, 40, 35])
                ->chartColor('rgba(59, 130, 246, 0.5)'),
        ];
    }
    
    
    
}
// crie um novo widget chamado StatsUserDetailOverview.php em app/Filament/Widgets/StatsUserDetailOverview.php
