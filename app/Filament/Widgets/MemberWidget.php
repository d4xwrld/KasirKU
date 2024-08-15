<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Member;

class MemberWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Member', Member::count())
            ->description('Member Total')
            ->icon('heroicon-o-user-group')
            ->chart([1, 3, 5])
            ->color('success'),
        ];
    }
}