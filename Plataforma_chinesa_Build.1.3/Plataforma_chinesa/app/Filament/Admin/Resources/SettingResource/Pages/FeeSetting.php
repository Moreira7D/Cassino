<?php

namespace App\Filament\Admin\Resources\SettingResource\Pages;

use App\Filament\Admin\Resources\SettingResource;
use App\Models\Setting;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FeeSetting extends Page implements HasForms
{
    use HasPageSidebar, InteractsWithForms;

    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.resources.setting-resource.pages.fee-setting';

    /**
     * Verifica se o usuário pode visualizar a página.
     */
    public static function canView(Model $record): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Retorna o título da página.
     */
    public function getTitle(): string | Htmlable
    {
        return __('SECÇÃO DE CPA E REVSHARE');
    }

    public Setting $record;
    public ?array $data = [];

    /**
     * Inicializa a página e preenche o formulário com os dados.
     */
    public function mount(): void
    {
        $setting = Setting::first();
        $this->record = $setting;
        $this->form->fill($setting->toArray());
    }

    /**
     * Salva as configurações alteradas.
     */
    public function save()
    {
        try {
            if (env('APP_DEMO')) {
                Notification::make()
                    ->title('Atenção')
                    ->body('Você não pode realizar esta alteração na versão demo')
                    ->danger()
                    ->send();
                return;
            }

            $setting = Setting::find($this->record->id);

            if ($setting->update($this->data)) {
                Cache::put('setting', $setting);

                Notification::make()
                    ->title('Dados alterados')
                    ->body('Dados alterados com sucesso!')
                    ->success()
                    ->send();

                return redirect(route('filament.admin.resources.settings.fee', ['record' => $this->record->id]));
            }
        } catch (\Exception $exception) {
            return;
        }
    }

    /**
     * Define o formulário para ajustar as taxas.
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('SECÇÃO DE CPA')
                    ->description('Ajuste o valor da comissão CPA e depósito mínimo para o afiliado ganhar o CPA.')
                    ->schema([
                        TextInput::make('cpa_baseline')
                            ->label('DEPÓSITO MÍNIMO CPA')
                            ->helperText('Valor mínimo que o usuário deve depositar para o afiliado ganhar o CPA.')
                            ->numeric()
                            ->suffix('R$ ')
                            ->maxLength(191),
                        TextInput::make('cpa_value')
                            ->label('AFILIADO CPA')
                            ->helperText('Valor da comissão CPA que o afiliado ganhará.')
                            ->numeric()
                            ->suffix('R$')
                            ->maxLength(191),
                        TextInput::make('cpa_percentage_baseline')
                            ->label('QUANDO O AFILIADO GANHA CPA (%)')
                            ->numeric()
                            ->suffix('R$')
                            ->helperText('Quanto é necessário depositar para ativar o CPA em %')
                            ->maxLength(191),
                        TextInput::make('cpa_percentage')
                            ->label('QUANTO O AFILIADO VAI GANHAR EM (%)')
                            ->numeric()
                            ->suffix('%')
                            ->helperText('Seu afiliado vai receber a % definida aqui do depósito do seu indicado!')
                            ->maxLength(191),
                    ])->columns(2),

                Section::make('SECÇÃO DE REVSHARE')
                    ->description('Formulário para ajustar as taxas da plataforma.')
                    ->schema([
                        Grid::make()->schema([
                            TextInput::make('revshare_percentage')
                                ->label('QUAL O REVSHARE (%)')
                                ->numeric()
                                ->suffix('%')
                                ->helperText('Este é o revshare padrão para cada usuário que se candidata a ser afiliado.')
                                ->maxLength(191),
                            TextInput::make('ngr_percent')
                                ->helperText('Esta taxa é deduzida dos ganhos do afiliado para a plataforma.')
                                ->label('QUAL O NGR (%)')
                                ->numeric()
                                ->suffix('%')
                                ->maxLength(191),
                            Toggle::make('revshare_reverse')
                                ->inline(true)
                                ->label('ATIVAR REVSHARE REVERSO')
                                ->helperText('Esta opção possibilita que o afiliado acumule saldos negativos decorrentes das perdas geradas pelos seus indicados.')
                        ])
                    ])
            ])
            ->statePath('data');
    }
}
