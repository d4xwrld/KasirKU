<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static ?string $modelLabel = 'Member';

    // public static function canViewAny(): bool
    // {
    //     return auth()->user()->usertype === 'kasir';
    // }

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('phone')
                    ->label('Phone')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('phone'),
            ])
            ->filters([
                //
            ])
            ->actions([ //TO-DO: Add condition to show edit button only for admin
                // auth()->user()->usertype === 'admin' ? Tables\Actions\EditAction::make() : null,
                // Tables\Actions\EditAction::make()
            ]);
            // ->bulkActions([
            //     auth()->user()->usertype === 'admin' ? Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]) : null,
            // ]);
            // ->bulkActions([ //TO-DO: Add condition to show Delete button only for admin
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            // 'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}