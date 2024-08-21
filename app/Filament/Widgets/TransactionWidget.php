<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;

class TransactionWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Transaksi', Transaction::count())
            ->icon('heroicon-o-banknotes')
            ->chart([1, 3, 5])
            ->color('success'),
        ];
    }
}