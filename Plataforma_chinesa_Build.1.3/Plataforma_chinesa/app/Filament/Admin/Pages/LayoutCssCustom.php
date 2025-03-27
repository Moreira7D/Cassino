<?php

namespace App\Filament\Admin\Pages;

use App\Models\CustomLayout;
use Creagia\FilamentCodeField\CodeField;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use App\Helpers\Core;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Cache;

class LayoutCssCustom extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.layout-css-custom';

    protected static ?string $navigationLabel = 'Customização Layout';

    protected static ?string $modelLabel = 'Customização Layout';

    protected static ?string $title = 'Customização Layout';

    protected static ?string $slug = 'custom-layout';

    public ?array $data = [];
    public CustomLayout $custom;

    /**
     * @dev @victormsalatiel
     * @return bool
     */
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->custom = CustomLayout::first();
        $this->form->fill($this->custom->toArray());
    }

    /**
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        return $data;
    }

    /**
     * @param Form $form
     * @return Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('SISTEMA DE NOTIFICAÇÃO')
                    ->description('Crie notificações personalizadas para seus usuários.')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        FileUpload::make('notificacao_icon_1')->label("Icon de notificação N°1")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('notificacao_titulo_1')
                            ->label('Titulo notificação N°1')
                            ->placeholder('Digite o titulo da notificação')
                            ->maxLength(1000),
                        TextInput::make('notificacao_descricao_1')
                            ->label('Descrição notificação N°1')
                            ->placeholder('Digite a descrição da notificação')
                            ->maxLength(1000),
                        FileUpload::make('notificacao_icon_2')->label("Icon de notificação N°2")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('notificacao_titulo_2')
                            ->label('Titulo notificação N°2')
                            ->placeholder('Digite o titulo da notificação')
                            ->maxLength(1000),
                        TextInput::make('notificacao_descricao_2')
                            ->label('Descrição notificação N°2')
                            ->placeholder('Digite a descrição da notificação')
                            ->maxLength(1000),
                        FileUpload::make('notificacao_icon_3')->label("Icon de notificação N°3")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('notificacao_titulo_3')
                            ->label('Titulo notificação N°3')
                            ->placeholder('Digite o titulo da notificação')
                            ->maxLength(1000),
                        TextInput::make('notificacao_descricao_3')
                            ->label('Descrição notificação N°3')
                            ->placeholder('Digite a descrição da notificação')
                            ->maxLength(1000),
                        FileUpload::make('notificacao_icon_4')->label("Icon de notificação N°4")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('notificacao_titulo_4')
                            ->label('Titulo notificação N°4')
                            ->placeholder('Digite o titulo da notificação')
                            ->maxLength(1000),
                        TextInput::make('notificacao_descricao_4')
                            ->label('Descrição notificação N°4')
                            ->placeholder('Digite a descrição da notificação')
                            ->maxLength(1000),
                        FileUpload::make('notificacao_icon_5')->label("Icon de notificação N°5")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('notificacao_titulo_5')
                            ->label('Titulo notificação N°5')
                            ->placeholder('Digite o titulo da notificação')
                            ->maxLength(1000),
                        TextInput::make('notificacao_descricao_5')
                            ->label('Descrição notificação N°5')
                            ->placeholder('Digite a descrição da notificação')
                            ->maxLength(1000),
                    ])->columns(3)
                ,

                Section::make('SISTEMA DE NOTICIA')
                    ->description('Crie noticias personalizadas para seus usuários.')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        FileUpload::make('noticia_icon_1')->label("Icon de Noticia N°1")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('noticia_titulo_1')
                            ->label('Titulo Noticia N°1')
                            ->placeholder('Digite o titulo da Noticia')
                            ->maxLength(1000),
                        TextInput::make('noticia_descricao_1')
                            ->label('Descrição Noticia N°1')
                            ->placeholder('Digite a descrição da Noticia')
                            ->maxLength(1000),
                        FileUpload::make('noticia_icon_2')->label("Icon de Noticia N°2")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('noticia_titulo_2')
                            ->label('Titulo Noticia N°2')
                            ->placeholder('Digite o titulo da Noticia')
                            ->maxLength(1000),
                        TextInput::make('noticia_descricao_2')
                            ->label('Descrição Noticia N°2')
                            ->placeholder('Digite a descrição da Noticia')
                            ->maxLength(1000),
                        FileUpload::make('noticia_icon_3')->label("Icon de Noticia N°3")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('noticia_titulo_3')
                            ->label('Titulo Noticia N°3')
                            ->placeholder('Digite o titulo da Noticia')
                            ->maxLength(1000),
                        TextInput::make('noticia_descricao_3')
                            ->label('Descrição Noticia N°3')
                            ->placeholder('Digite a descrição da Noticia')
                            ->maxLength(1000),
                        FileUpload::make('noticia_icon_4')->label("Icon de Noticia N°4")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('noticia_titulo_4')
                            ->label('Titulo Noticia N°4')
                            ->placeholder('Digite o titulo da Noticia')
                            ->maxLength(1000),
                        TextInput::make('noticia_descricao_4')
                            ->label('Descrição Noticia N°4')
                            ->placeholder('Digite a descrição da Noticia')
                            ->maxLength(1000),
                        FileUpload::make('noticia_icon_5')->label("Icon de Noticia N°5")->placeholder('imagem: Pixel > 120x120')->image(),
                        TextInput::make('noticia_titulo_5')
                            ->label('Titulo Noticia N°5')
                            ->placeholder('Digite o titulo da Noticia')
                            ->maxLength(1000),
                        TextInput::make('noticia_descricao_5')
                            ->label('Descrição Noticia N°5')
                            ->placeholder('Digite a descrição da Noticia')
                            ->maxLength(1000),
                    ])->columns(3)
                ,
                Section::make('CUSTOMIZAÇÃO DE CORES PRINCIPAIS')
                    ->description('Personalize a aparência do seu site, conferindo-lhe uma identidade única.')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        ColorPicker::make('background_base')
                            ->label('Background Principal')
                            ->required(),
                        ColorPicker::make('background_base_dark')
                            ->label('Background Principal (Dark)')
                            ->required(),
                        ColorPicker::make('carousel_banners')
                            ->label('Carousel Banners')
                            ->required(),
                        ColorPicker::make('carousel_banners_dark')
                            ->label('Carousel Banners (Dark)')
                            ->required(),
                    ])->columns(4)
                ,
                Section::make('SIDEBAR & NAVBAR & FOOTER')
                    ->description('Personalize a aparência do seu site, conferindo-lhe uma identidade única.')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        ColorPicker::make('sidebar_color')
                            ->label('Sidebar')
                            ->required(),

                        ColorPicker::make('sidebar_color_dark')
                            ->label('Sidebar (Dark)')
                            ->required(),

                        ColorPicker::make('navtop_color')
                            ->label('Navtop')
                            ->required(),

                        ColorPicker::make('navtop_color_dark')
                            ->label('Navtop (Dark)')
                            ->required(),

                        ColorPicker::make('side_menu')
                            ->label('Side Menu Box')
                            ->required(),

                        ColorPicker::make('side_menu_dark')
                            ->label('Side Menu Box (Dark)')
                            ->required(),

                        ColorPicker::make('footer_color')
                            ->label('Footer Color')
                            ->required(),

                        ColorPicker::make('footer_color_dark')
                            ->label('Footer Color (Dark)')
                            ->required(),
                    ])->columns(4)
                ,
                Section::make('TODAS AS IMAGENS DA PLATAFORMA')
                    ->description('Personalize as imagens da sua plataforma, conferindo-lhe uma identidade única.')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        FileUpload::make('image_pop_up1')->label("Pagina inicial Pop-up 1")->placeholder('imagem: Pixel > 220x220')->image(),
                        FileUpload::make('image_pop_up2')->label("Pagina inicial Pop-up 2")->placeholder('imagem: Pixel > 220x220')->image(),
                        FileUpload::make('image_pop_up3')->label("Pagina inicial Pop-up 3")->placeholder('imagem: Pixel > 220x220')->image(),
                        FileUpload::make('image_agente')->label("menu lateral agente")->placeholder('imagem: Pixel > 360x110')->image(),
                        FileUpload::make('image_pedente')->label("menu lateral pendente")->placeholder('imagem: Pixel > 170x110')->image(),
                        FileUpload::make('image_eventos')->label("menu lateral eventos")->placeholder('imagem: Pixel > 170x110')->image(),
                        FileUpload::make('banner_deposito1')->label("Banner do depósito")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('banner_deposito2')->label("Banner do baixe app")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('banner_licença')->label("Banner do licença")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('banner_jackpot')->label("Banner JackPot")->placeholder('Carregue uma imagem 1420x464')->image(),
                        FileUpload::make('navbar_img_login')->label("Imagem Do perfil")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('menu_cell_inicio')->label("Imagem menu do cell inicio")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('menu_cell_promocao')->label("Imagem menu do cell promocao")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('menu_cell_agente')->label("Imagem menu do cell agente")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('menu_cell_suporte')->label("Imagem menu do cell suporte")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('menu_cell_perfil')->label("Imagem menu do cell perfil")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('menu_cell_deposito')->label("Imagem menu do cell deposito")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('footer_imagen1')->label("Imagem footer 1")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('footer_imagen2')->label("Imagem footer 2")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('footer_imagen3')->label("Imagem footer 3")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('footer_telegram')->label("Imagem telegram")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('footer_facebook')->label("Imagem facebook")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('footer_whatsapp')->label("Imagem whatsapp")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('footer_instagram')->label("Imagem instagram")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('footer_mais18')->label("Imagem +18")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('suporte_imagem')->label("Imagem perfil do suporte")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('icon_som')->label("Ícone Som")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('icon_mensagem')->label("Ícone Mensagem")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('icon_coletavel')->label("Ícone Coletável")->placeholder('Carregue uma imagem')->image(),
                        FileUpload::make('agente_afiliado')->label("Agente Afiliado")->placeholder('Carregue uma imagem')->image(),
                    ])->columns(4)
                ,
                Section::make('CUSTOMIZAÇÃO DE CORES SECUNDÁRIAS')
                    ->description('Personalize a aparência do seu site, conferindo-lhe uma identidade única.')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        ColorPicker::make('primary_color')
                            ->label('Primary Color')
                            ->required(),
                        ColorPicker::make('primary_opacity_color')
                            ->label('Primary Opacity Color')
                            ->required(),

                        ColorPicker::make('input_primary')
                            ->label('Input Primary')
                            ->required(),
                        ColorPicker::make('input_primary_dark')
                            ->label('Input Primary (Dark)')
                            ->required(),

                        ColorPicker::make('card_color')
                            ->label('Card Primary')
                            ->required(),
                        ColorPicker::make('card_color_dark')
                            ->label('Card Primary (Dark)')
                            ->required(),

                        ColorPicker::make('secundary_color')
                            ->label('Secundary Color')
                            ->required(),
                        ColorPicker::make('gray_dark_color')
                            ->label('Gray Dark Color')
                            ->required(),
                        ColorPicker::make('gray_light_color')
                            ->label('Gray Light Color')
                            ->required(),
                        ColorPicker::make('gray_medium_color')
                            ->label('Gray Medium Color')
                            ->required(),
                        ColorPicker::make('gray_over_color')
                            ->label('Gray Over Color')
                            ->required(),
                        ColorPicker::make('title_color')
                            ->label('Title Color')
                            ->required(),
                        ColorPicker::make('text_color')
                            ->label('Text Color')
                            ->required(),
                        ColorPicker::make('sub_text_color')
                            ->label('Sub Text Color')
                            ->required(),
                        ColorPicker::make('placeholder_color')
                            ->label('Placeholder Color')
                            ->required(),
                        ColorPicker::make('background_color')
                            ->label('Background Color')
                            ->required(),
                        TextInput::make('border_radius')
                            ->label('Border Radius')
                            ->required(),
                    ])->columns(4)
                ,
                Section::make('TEXTOS E MENSAGENS')
                    ->description('Customize os textos e mensagens da sua plataforma')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        TextInput::make('mensagem_home')
                            ->label('Messagem na Home')
                            ->placeholder('Messagem que aparece na Home')
                            ->maxLength(1000),
                        TextInput::make('sobre_fotter')
                            ->label('Sobre a plataforma')
                            ->placeholder('Digite messagem sobre a plataforma')
                            ->maxLength(1000),
                        TextInput::make('texto_suporte')
                            ->label('Titulo de Suporte')
                            ->placeholder('Digite o texto de suporte')
                            ->maxLength(1000),
                        TextInput::make('descricao_suporte')
                            ->label('Descrição de Suporte')
                            ->placeholder('Digite a descrição de suporte')
                            ->maxLength(1000),
                    ])->columns(2)
                ,
                Section::make('CUSTOMIZAÇÃO DA BASE')
                    ->description('Customize seu css, js, ou adicione conteúdo no corpo da sua página')
                    ->collapsible()
                    ->collapsed(true)
                     ->schema([
                         CodeField::make('custom_css')
                             ->label('Customização do CSS')
                             ->setLanguage(CodeField::CSS)
                             ->withLineNumbers()
                             ->minHeight(400),
                         CodeField::make('custom_js')
                             ->label('Customização do pop-up')
                             ->setLanguage(CodeField::JS)
                             ->withLineNumbers()
                             ->minHeight(400),
                         CodeField::make('custom_header')
                             ->label('Customização do Header')
                             ->setLanguage(CodeField::HTML)
                             ->withLineNumbers()
                             ->minHeight(400),
                         CodeField::make('custom_body')
                             ->label('Customização do Body')
                             ->setLanguage(CodeField::HTML)
                             ->withLineNumbers()
                             ->minHeight(400),
                     ])
                ,
                Section::make('TODOS OS LINKS DA PLATAFORMA')
                    ->description('Customize link das suas redes sociais')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->placeholder('Digite a URL do seu Instagram')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->placeholder('Digite a URL do seu Facebook')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('telegram')
                            ->label('Telegram')
                            ->placeholder('Digite a URL do seu Telegram')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('twitter')
                            ->label('twitter')
                            ->placeholder('Digite a URL do seu twitter')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('whastapp')
                            ->label('Whastapp')
                            ->placeholder('Digite a URL do seu Whastapp')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('youtube')
                            ->label('Youtube')
                            ->placeholder('Digite a URL do seu Youtube')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('link_app')
                            ->label('Link do app')
                            ->placeholder('Digite a URL para baixar o app')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('link_suporte')
                            ->label('Link do suporte')
                            ->placeholder('Digite a URL do suporte')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('link_lincenca')
                            ->label('Link do banner da licença')
                            ->placeholder('Digite a URL do banner da licença')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('link_footer_imagen1')
                            ->label('Link da imagem do footer 1')
                            ->placeholder('Digite a URL da imagem do footer 1')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('link_footer_imagen2')
                            ->label('Link da imagem do footer 2')
                            ->placeholder('Digite a URL da imagem do footer 2')
                            ->url()
                            ->maxLength(191),
                        TextInput::make('link_footer_imagen3')
                            ->label('Link da imagem do footer 3')
                            ->placeholder('Digite a URL da imagem do footer 3')
                            ->url()
                            ->maxLength(191),
                    ])->columns(2)
                ,
            ])
            ->statePath('data');
    }




    private function uploadFile($file)
    {
        // Se o arquivo for uma string (já existente), encapsula em um array.
        if (is_string($file)) {
            return [$file];
        }

        // Verifica se o arquivo é uma instância de TemporaryUploadedFile e o processa.
        if (!empty($file) && (is_array($file) || is_object($file))) {
            foreach ($file as $temporaryFile) {
                if ($temporaryFile instanceof TemporaryUploadedFile) {
                    // Gera um nome de arquivo único
                    $filename = uniqid() . '.' . $temporaryFile->getClientOriginalExtension();

                    // Salva o arquivo no diretório 'uploads'
                    $temporaryFile->storeAs('uploads', $filename, 'public');

                    // Retorna o nome do arquivo em um array
                    return [$filename];
                }
                return [$temporaryFile]; // Garante que sempre retorna um array
            }
        }

        // Se não for um array, objeto ou string válida, retorna null.
        return null;
    }



    /**
     * @return void
     */
    public function submit(): void
    {
        try {
            if (env('APP_DEMO')) {
                Notification::make()->title('Atenção')->body('Você não pode realizar esta alteração na versão demo')->danger()->send();
                return;
            }

            // Processar os uploads de arquivos
            $this->handleFileUploads();
            $custom = CustomLayout::first();
            $data = $this->form->getState();

            if (!empty($custom)) {
                // Use $data para garantir que está salvando os dados corretos
                if ($custom->update($data)) {

                    Cache::put('custom', $custom);

                    Notification::make()->title('Dados alterados')->body('Dados alterados com sucesso!')->success()->send();
                }
            }

        } catch (Halt $exception) {
            Notification::make()->title('Erro ao alterar dados!')->body('Erro ao alterar dados!')->danger()->send();
        }
    }






    private function handleFileUploads(): void
    {
        $this->data['image_pop_up1'] = $this->processFileUpload($this->data['image_pop_up1']);
        $this->data['image_pop_up2'] = $this->processFileUpload($this->data['image_pop_up2']);
        $this->data['banner_licença'] = $this->processFileUpload($this->data['banner_licença']);
        $this->data['image_agente'] = $this->processFileUpload($this->data['image_agente']);
        $this->data['image_pedente'] = $this->processFileUpload($this->data['image_pedente']);
        $this->data['image_eventos'] = $this->processFileUpload($this->data['image_eventos']);
        $this->data['banner_deposito1'] = $this->processFileUpload($this->data['banner_deposito1']);
        $this->data['banner_deposito2'] = $this->processFileUpload($this->data['banner_deposito2']);
        $this->data['banner_jackpot'] = $this->processFileUpload($this->data['banner_jackpot']);
        $this->data['navbar_img_login'] = $this->processFileUpload($this->data['navbar_img_login']);
        $this->data['menu_cell_inicio'] = $this->processFileUpload($this->data['menu_cell_inicio']);
        $this->data['menu_cell_promocao'] = $this->processFileUpload($this->data['menu_cell_promocao']);
        $this->data['menu_cell_agente'] = $this->processFileUpload($this->data['menu_cell_agente']);
        $this->data['menu_cell_suporte'] = $this->processFileUpload($this->data['menu_cell_suporte']);
        $this->data['menu_cell_perfil'] = $this->processFileUpload($this->data['menu_cell_perfil']);
        $this->data['menu_cell_deposito'] = $this->processFileUpload($this->data['menu_cell_deposito']);
        $this->data['footer_imagen1'] = $this->processFileUpload($this->data['footer_imagen1']);
        $this->data['footer_imagen2'] = $this->processFileUpload($this->data['footer_imagen2']);
        $this->data['footer_imagen3'] = $this->processFileUpload($this->data['footer_imagen3']);
        $this->data['footer_telegram'] = $this->processFileUpload($this->data['footer_telegram']);
        $this->data['footer_facebook'] = $this->processFileUpload($this->data['footer_facebook']);
        $this->data['footer_whatsapp'] = $this->processFileUpload($this->data['footer_whatsapp']);
        $this->data['footer_instagram'] = $this->processFileUpload($this->data['footer_instagram']);
        $this->data['footer_mais18'] = $this->processFileUpload($this->data['footer_mais18']);
        $this->data['suporte_imagem'] = $this->processFileUpload($this->data['suporte_imagem']);
        $this->data['image_pop_up3'] = $this->processFileUpload($this->data['image_pop_up3']);
        $this->data['icon_som'] = $this->processFileUpload($this->data['icon_som']);
        $this->data['icon_mensagem'] = $this->processFileUpload($this->data['icon_mensagem']);
        $this->data['icon_coletavel'] = $this->processFileUpload($this->data['icon_coletavel']);
        $this->data['agente_afiliado'] = $this->processFileUpload($this->data['agente_afiliado']);
        $this->data['notificacao_icon_1'] = $this->processFileUpload($this->data['notificacao_icon_1']);
        $this->data['notificacao_icon_2'] = $this->processFileUpload($this->data['notificacao_icon_2']);
        $this->data['notificacao_icon_3'] = $this->processFileUpload($this->data['notificacao_icon_3']);
        $this->data['notificacao_icon_4'] = $this->processFileUpload($this->data['notificacao_icon_4']);
        $this->data['notificacao_icon_5'] = $this->processFileUpload($this->data['notificacao_icon_5']);
        $this->data['noticia_icon_1'] = $this->processFileUpload($this->data['noticia_icon_1']);
        $this->data['noticia_icon_2'] = $this->processFileUpload($this->data['noticia_icon_2']);
        $this->data['noticia_icon_3'] = $this->processFileUpload($this->data['noticia_icon_3']);
        $this->data['noticia_icon_4'] = $this->processFileUpload($this->data['noticia_icon_4']);
        $this->data['noticia_icon_5'] = $this->processFileUpload($this->data['noticia_icon_5']);
    }



    private function processFileUpload($file)
    {
        // Se não houver arquivo, retorna null.
        if (!$file) {
            return null;
        }

        // Verifica se o arquivo é uma instância de TemporaryUploadedFile.
        if ($file instanceof TemporaryUploadedFile) {
            // Gera um nome de arquivo único.
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            // Salva o arquivo no diretório 'uploads' e retorna o nome do arquivo.
            $file->storeAs('uploads', $filename, 'public');
            return 'uploads/' . $filename;
        }

        // Caso o arquivo já exista (string), apenas retorna o valor original.
        return $file;
    }

}
