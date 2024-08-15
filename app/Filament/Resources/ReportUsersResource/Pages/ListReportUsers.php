<?php

namespace App\Filament\Resources\ReportUsersResource\Pages;

use App\Filament\Resources\ReportUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportUsers extends ListRecords
{
    protected static string $resource = ReportUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
