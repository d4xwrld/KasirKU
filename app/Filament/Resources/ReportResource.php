<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Product;
use Filament\Actions\ExportAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction as ActionsExportAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\FIlament\Exports\ProductExporter;
use Faker\Provider\ar_EG\Text;

class ReportResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $modelLabel = 'Product';

    public static function canViewAny(): bool
    {
        return Auth::user()->usertype === 'admin';
    }
    protected static ?string $navigationGroup = "Reports";
    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

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
                TextColumn::make('name')
                ->searchable()
                ->sortable(),
                TextColumn::make('price'),
                TextColumn::make('stock'),
                TextColumn::make('created_at')
                ->label('Ditambahkan Pada'),
                TextColumn::make('updated_at')
                ->label('Diperbarui Pada'),
            ])
            ->filters([
                //
            ])
            // ->actions([
            //     // Tables\Actions\EditAction::make(),
            // ])
            ->headerActions([
                \Filament\Tables\Actions\ExportAction::make()->exporter(ProductExporter::class),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
    public static function canCreate(): bool
    {
       return false;
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
            'index' => Pages\ListReports::route('/'),
            // 'create' => Pages\CreateReport::route('/create'),
            // 'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}