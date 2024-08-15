<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class UserWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Petugas', User::count())
            ->description('Employee Total')
            ->icon('heroicon-o-user-group')
            ->chart([1, 3, 5])
            ->color('success'),
        ];
    }
}