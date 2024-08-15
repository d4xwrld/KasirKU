<?php

namespace App\Filament\Resources\ReportUsersResource\Pages;

use App\Filament\Resources\ReportUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReportUsers extends EditRecord
{
    protected static string $resource = ReportUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
