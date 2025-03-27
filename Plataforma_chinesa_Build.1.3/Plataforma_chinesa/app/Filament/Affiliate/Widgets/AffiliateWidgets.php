<?php

namespace App\Filament\Affiliate\Widgets;

use App\Models\AffiliateHistory;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Deposit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AffiliateWidgets extends BaseWidget
{
    protected static ?int $navigationSort = -2;

    /**
     * @return array|Stat[]
     */
    protected function getCards(): array
    {
        $inviterId = auth()->user()->id;
        $usersIds = User::where('inviter', $inviterId)->pluck('id');
        $usersTotal = User::where('inviter', $inviterId)->count();

        // Soma dos depósitos confirmados para cada usuário indicado
        $confirmedDepositsTotal = Deposit::whereIn('user_id', $usersIds)
                                         ->where('status', 1) // Considerando 1 como o status para depósitos confirmados
                                         ->sum('amount');

        $mycomission = Wallet::where('user_id', $inviterId)->sum('refer_rewards');

        // Estatísticas adicionais do segundo script para os indicados
        $depositCounts = DB::table('deposits')
            ->select('user_id', DB::raw('count(*) as deposit_count'))
            ->whereIn('user_id', $usersIds)
            ->where('status', '1')
            ->groupBy('user_id')
            ->get();

        $usersWithSingleDeposit = $depositCounts->filter(function ($item) {
            return $item->deposit_count === 1;
        });
        $numberOfUsersWithSingleDeposit = $usersWithSingleDeposit->count();

        $usersWithTwoDeposits = $depositCounts->filter(function ($item) {
            return $item->deposit_count === 2;
        });
        $numberOfUsersWithTwoDeposits = $usersWithTwoDeposits->count();

        $usersWithThreeDeposits = $depositCounts->filter(function ($item) {
            return $item->deposit_count === 3;
        });
        $numberOfUsersWithThreeDeposits = $usersWithThreeDeposits->count();

        $usersWithFourOrMoreDeposits = $depositCounts->filter(function ($item) {
            return $item->deposit_count >= 4;
        });
        $numberOfUsersWithFourOrMoreDeposits = $usersWithFourOrMoreDeposits->count();

        // Soma dos depósitos confirmados de 5, 10, 20 e acima de 30 reais
        $confirmedDepositsTotal5 = Deposit::whereIn('user_id', $usersIds)
                                            ->where('status', 1)
                                            ->where('amount', 5)
                                            ->sum('amount');

        $confirmedDepositsTotal10 = Deposit::whereIn('user_id', $usersIds)
                                            ->where('status', 1)
                                            ->where('amount', 10)
                                            ->sum('amount');

        $confirmedDepositsTotal20 = Deposit::whereIn('user_id', $usersIds)
                                            ->where('status', 1)
                                            ->where('amount', 20)
                                            ->sum('amount');

        $confirmedDepositsTotalAbove30 = Deposit::whereIn('user_id', $usersIds)
                                                ->where('status', 1)
                                                ->where('amount', '>', 30)
                                                ->sum('amount');

        return [
            Stat::make('Saldo Disponível', \Helper::amountFormatDecimal($mycomission))
                ->description('Saldo Disponível para saque')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total de Depósitos Confirmados dos Indicados', \Helper::amountFormatDecimal($confirmedDepositsTotal))
                ->description('Total dos depósitos confirmados feitos pelos indicados.')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Cadastros', $usersTotal)
                ->description('Usuários cadastrados com meu link')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Pessoas Que Depositaram 1 Vez', $numberOfUsersWithSingleDeposit)
                ->description('Pessoas Que Depositaram 1 Vez')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make('Pessoas Que Depositaram 2 Vezes', $numberOfUsersWithTwoDeposits)
                ->description('Pessoas Que Depositaram 2 Vezes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make('Pessoas Que Depositaram 3 Vezes', $numberOfUsersWithThreeDeposits)
                ->description('Pessoas Que Depositaram 3 Vezes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make('Pessoas Que Depositaram 4 Vezes ou mais', $numberOfUsersWithFourOrMoreDeposits)
                ->description('Pessoas Que Depositaram 4 Vezes ou mais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make('Total de Depósitos Confirmados de 5 Reais', \Helper::amountFormatDecimal($confirmedDepositsTotal5))
                ->description('Total de depósitos confirmados de 5 reais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Total de Depósitos Confirmados de 10 Reais', \Helper::amountFormatDecimal($confirmedDepositsTotal10))
                ->description('Total de depósitos confirmados de 10 reais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Total de Depósitos Confirmados de 20 Reais', \Helper::amountFormatDecimal($confirmedDepositsTotal20))
                ->description('Total de depósitos confirmados de 20 reais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Total de Depósitos Confirmados Acima de 30 Reais', \Helper::amountFormatDecimal($confirmedDepositsTotalAbove30))
                ->description('Total de depósitos confirmados acima de 30 reais')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
        ];
    }

    /**
     * @return bool
     */
    public static function canView(): bool
    {
        return auth()->user()->hasRole('afiliado');
    }
}
