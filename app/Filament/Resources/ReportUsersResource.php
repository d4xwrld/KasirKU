<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportUsersResource\Pages;
use App\Filament\Resources\ReportUsersResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportUsersResource extends Resource
{
    protected static ?string $model = User::class;
    public static function canViewAny(): bool
    {
        return auth()->user()->usertype === 'admin';
    }

    protected static ?string $navigationLabel = "Karyawan";


    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = "Reports";

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             //
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('usertype')
                            ->label('Role'),
            ])
            ->filters([
                //
            ])
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            // ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function canCreate(): bool
    {
       return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportUsers::route('/'),
            // 'create' => Pages\CreateReportUsers::route('/create'),
            // 'edit' => Pages\EditReportUsers::route('/{record}/edit'),
        ];
    }
}