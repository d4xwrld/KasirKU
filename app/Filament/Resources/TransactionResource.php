<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use App\Models\Transaction;
use Filament\Resources\Form\BulkActions\BulkAction;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Product;
use Filament\Pages\Page;
use Filament\Support\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Filament\Pages\Actions\Action as FilamentAction;

class TransactionResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Grid::make(['default' => 2])->schema([
                // TextInput::make('date')->label('Date'),
                // DatePicker::make('date')->label('Date')->default(now())->required()->disabled(),
                TextInput::make('total')->label('Total')
                    ->disabled()
                    ->reactive()
                    ->afterStateUpdated(function ($component, $state, $context) {
                        $product_id = $component->getState('product_id');
                        $quantity = $component->getState('quantity');
                        
                        $product = Product::find($product_id);
                        $component->state($product->price * $quantity);
                    }),
            ]),
            Grid::make(['default' => 2])->schema([
                Select::make('product_id')
                    ->label('Product')
                    ->options(fn () => Product::all()->pluck('name', 'id'))
                    ->multiple()
                    ->reactive(),
                TextInput::make('quantity') /* ERROR HERE */
                    ->label('Quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->reactive()
                    ->afterStateUpdated(function ($component, $state, $context) {
                        $product_id = $component->getState('product_id');
                        
                        $product = Product::find($product_id);
                        $component->parent()->get('total')->state($product->price * $state);
                    }),
                // Calculated price
                // TextInput::make('price')
                //     ->label('Price')
                //     ->disabled()
                //     ->reactive()
                //     ->afterStateUpdated(function ($component, $state, $context) {
                //         $product = Product::find($component->getState('product_id'));
                //         $component->state($state * $product->price);
                //     }),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->label('Date'),
                TextColumn::make('total')->label('Total'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                // Bulk actions can be added here
            ]);
    }

    public static function getModel(): string
    {
        return Transaction::class;
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-shopping-bag';
    }

    public static function getNavigationGroup(): string
    {
        if(auth()->user()->usertype === 'admin') {
            return 'Reports';
        } return null;
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return Auth::user()->usertype !== 'admin'; 
    }

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()->usertype === 'admin';
    // }
}