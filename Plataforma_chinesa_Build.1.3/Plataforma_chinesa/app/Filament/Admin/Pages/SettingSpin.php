<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;

class SettingSpin extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.setting-spin';

    public ?array $data = [];

    public function mount(): void
    {
        //
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function getTitle(): string
    {
        return __('Setting Spin');
    }

    public function getHeading(): string
    {
        return __('Setting Spin');
    }

    public function form(Form $form): Form
    {
        return $form;
    }

    public function submit(): void
    {
        //
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }

    public function getVisibleWidgets(): array
    {
        return [];
    }

    public function getWidgets(): array
    {
        return [];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return [
            'md' => 4,
            'xl' => 5,
        ];
    }
}
