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
use App\Models\TransactionDetail;
use Filament\Pages\Page;
use Filament\Support\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Repeater;
use App\Models\Member;
class TransactionResource extends Resource
    {
    
    public static function form(Form $form): Form
    {
        
        
        function updateTotal($get, $set) {
            $transactionDetails = $get('transaction_detail');
            $total = 0;
        
            if ($transactionDetails) {
                foreach ($transactionDetails as $detail) {
                    $total += $detail['subtotal'];
                }
            }
        
            $discount = $get('discount');
            if ($discount) {
                $total -= $total * ($discount / 100);
            }
        
            $set('total', $total);
        }

        function applyDiscount($get, $set) {
            $memberPhone = $get('member_phone');
            $discount = 0;
        
            if ($memberPhone) {
                $member = Member::where('phone', $memberPhone)->first();
                if ($member) {
                    $discount = $member->discount;
                }
            }
        
            $set('discount', $discount);
            updateTotal($get, $set);
        }
        
        return $form
            ->schema([
                Repeater::make('transaction_detail')
                    ->label('Transaksi')
                    ->relationship('transactionDetails')
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->options(Product::all()->pluck('name', 'id'))
                            ->reactive()
                            ->searchable()
                            ->required()
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $product = Product::find($state);
                                if ($product) {
                                    $set('price', $product->price);
                                    $quantity = $get('qty');
                                    if ($quantity) {
                                        $set('subtotal', $product->price * $quantity);
                                    }
                                    updateTotal($get, $set);
                                }
                            }),
                            TextInput::make('qty')
                            ->label('Quantity')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get, $set) {
                                $price = $get('price');
                                if ($price) {
                                    $set('subtotal', $price * $state);
                                }
                                updateTotal($get, $set);
                            }),
                        TextInput::make('price')
                            ->label('Price')
                            ->disabled()
                            ->reactive(),
                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->disabled()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get, $set) {
                                updateTotal($get, $set);
                            }),
                    ])
                    ->createItemButtonLabel('Add Product')
                    ->afterStateUpdated(function ($state, $get, $set) {
                        updateTotal($get, $set);
                    }),
                    Select::make('member_phone')
                    ->label('Member')
                    ->options(Member::all()->pluck('phone', 'phone')) // Use phone as both key and value
                    ->reactive()
                    ->searchable()
                    ->afterStateUpdated(function ($state, $get, $set) {
                        if ($state) {
                            applyDiscount($get, $set);
                        }
                        updateTotal($get, $set);
                    }),
                    TextInput::make('total')
                    ->label('Total')
                    ->disabled()
                    ->reactive()
                    ->afterStateHydrated(function ($state, $get, $set) {
                        updateTotal($get, $set);
                    }),
            ]);
    }
    
        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    // TextColumn::make('id'),
                    // TextColumn::make('created_at')->label('Date'),
                    // TextColumn::make('member_id')->label('Member'),
                    // TextColumn::make('total')->label('Total'),
                ])
                ->actions([
                    EditAction::make(),
                    // DeleteAction::make(),
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

    // public static function getNavigationGroup(): string
    // {
    //     if(Auth::user()->usertype === 'admin') {
    //         return 'Reports';
    //     } return 'Transactions';
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateTransaction::route('/'),
            // 'create' => Pages\CreateTransaction::route('/create'),
            // 'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    // public static function canCreate(): bool
    // {
    //     return Auth::user()->usertype !== 'admin'; 
    // }

    public static function canAccess(): bool
    {
        if(Auth::user()->usertype !== 'admin') {
            return true;
        } return false;
        // return static::canViewAny();
    }

    public static function canView(Model $record): bool
    {
        return Auth::user()->usertype === 'admin'; 
    }

    // public static function canViewAny(): bool
    // {
    //     return Auth::user()->usertype === 'admin';
    // }
}