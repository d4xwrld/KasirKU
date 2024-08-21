<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportTransactionResource\Pages;
use App\Filament\Resources\ReportTransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ReportTransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Reports";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('created_at')->label('Date')
                ->searchable()
                ->sortable(),
                TextColumn::make('member_id')->label('Member')
                ->searchable(),
                TextColumn::make('total'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
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

    public static function canAccess(): bool
    {
        if(Auth::user()->usertype === 'admin') {
            return true;
        } return false;
        // return static::canViewAny();
    }

    public static function canCreate(): bool
    {
       return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReportTransactions::route('/'),
            // 'create' => Pages\CreateReportTransaction::route('/create'),
            // 'edit' => Pages\EditReportTransaction::route('/{record}/edit'),
        ];
    }
}