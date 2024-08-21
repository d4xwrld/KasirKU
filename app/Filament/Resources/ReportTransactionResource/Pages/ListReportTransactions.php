<?php

namespace App\Filament\Resources\ReportTransactionResource\Pages;

use App\Filament\Resources\ReportTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportTransactions extends ListRecords
{
    protected static string $resource = ReportTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
