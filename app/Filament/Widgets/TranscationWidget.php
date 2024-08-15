<?php

use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;


class TranscationWidget extends Widget
{
    protected static string $view = 'filament.widgets.transcation-widget';
    
    protected int | string | array $columnSpan = 'full';
 
    public ?array $data = [];
 
    public function mount(): void
    {
        $this->form->fill();
    }
 
    public function form(Form $form): Form
    { 
        return $form
        ->schema([
            TextInput   ::make('name')
                        ->label('Name')
                        ->required(),
        ]);
    }
}