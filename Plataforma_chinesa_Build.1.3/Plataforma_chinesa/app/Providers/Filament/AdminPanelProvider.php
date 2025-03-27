<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Admin\Pages\AdvancedPage;
use App\Filament\Admin\Pages\DashboardAdmin;
use App\Filament\Admin\Pages\DigitoPayPaymentPage;
use App\Filament\Admin\Pages\GamesKeyPage;
use App\Filament\Admin\Pages\GatewayPage;
use App\Filament\Admin\Pages\LayoutCssCustom;
use App\Filament\Admin\Pages\SettingMailPage;
use App\Filament\Admin\Pages\SettingSpin;
use App\Filament\Admin\Pages\SuitPayPaymentPage;
use App\Filament\Admin\Resources\AffiliateWithdrawResource;
use App\Filament\Admin\Resources\BannerResource;
use App\Filament\Admin\Resources\DepositResource;
use App\Filament\Admin\Resources\GameResource;
use App\Filament\Admin\Resources\MissionResource;
use App\Filament\Admin\Resources\OrderResource;
use App\Filament\Admin\Resources\ProviderResource;
use App\Filament\Admin\Resources\SettingResource;
use App\Filament\Admin\Resources\UserResource;
use App\Filament\Admin\Resources\VipResource;
use App\Filament\Admin\Resources\WalletResource;
use App\Filament\Admin\Resources\WithdrawalResource;
use App\Livewire\AdminWidgets;
use App\Livewire\WalletOverview;
use App\Livewire\LatestAdminComissions;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route; // Importação da classe Route

class AdminPanelProvider extends PanelProvider
{
    /**
     * @param Panel $panel
     * @return Panel
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path(env("FILAMENT_BASE_URL"))
            ->login()
            ->colors([
                'danger' => Color::Red,
                'gray' => Color::Slate,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])

            ->font('Roboto Condensed')
            ->brandLogo(fn () => view('filament.components.logo'))
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                DashboardAdmin::class,
            ])
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->sidebarCollapsibleOnDesktop()
            ->collapsibleNavigationGroups(true)
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                WalletOverview::class,
                AdminWidgets::class,
                LatestAdminComissions::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make()
                        ->items([
                            NavigationItem::make('dashboard')
                                ->icon('heroicon-o-home')
                                ->label(fn (): string => __('filament-panels::pages/dashboard.title'))
                                ->url(fn (): string => DashboardAdmin::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.pages.dashboard')),
                        ]),

                    NavigationGroup::make('DEFINIÇÕES DA PLATAFORMA')
                        ->items([
                            NavigationItem::make('settings')
                            ->icon('heroicon-o-cog')
                            ->label(fn (): string => 'DEFINIÇÕES DA PLATAFORMA')
                            ->url(fn (): string => SettingResource::getUrl())
                            ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.settings.*'))
                            ->visible(fn(): bool => auth()->user()->hasRole('admin')),


                            NavigationItem::make('custom-layout')
                                ->icon('heroicon-o-paint-brush')
                                ->label(fn (): string => 'DEFINIÇÕES DE CSS E IMAGENS GERAL')
                                ->url(fn (): string => LayoutCssCustom::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.layout-css-custom.*'))
                                ->visible(fn(): bool => auth()->user()->hasRole('admin')),

                            NavigationItem::make('gateway')
                                ->icon('heroicon-o-credit-card')
                                ->label(fn (): string => 'DEFINIÇÕES DE PAGAMENTO')
                                ->url(fn (): string => GatewayPage::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.gateway-page.*'))
                                ->visible(fn(): bool => auth()->user()->hasRole('admin')),

                            NavigationItem::make('games-key')
                                ->icon('heroicon-o-cpu-chip')
                                ->label(fn (): string => 'DEFINIÇÕES DA PLAYFIVER')
                                ->url(fn (): string => GamesKeyPage::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.games-key.*'))
                                ->visible(fn(): bool => auth()->user()->hasRole('admin')),



                            ...BannerResource::getNavigationItems(),


                            NavigationItem::make('setting-mail')
                                ->icon('heroicon-o-inbox-stack')
                                ->label(fn (): string => 'DEFINIÇÕES DE E-MAIL')
                                ->url(fn (): string => SettingMailPage::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.setting-mail.*'))
                                ->visible(fn(): bool => auth()->user()->hasRole('admin')),
                        ]),



                    NavigationGroup::make('GESTÃO DA PLATAFORMA')
                        ->items([

                            ...UserResource::getNavigationItems(),
                            ...WalletResource::getNavigationItems(),
                            ...DepositResource::getNavigationItems(),

                        ]),
                    NavigationGroup::make('SAQUES DA PLATAFORMA')
                        ->items([
                            NavigationItem::make('withdraw_affiliates')
                                ->icon('heroicon-o-banknotes')
                                ->label(fn (): string => 'SAQUES AFILIADOS')
                                ->url(fn (): string => AffiliateWithdrawResource::getUrl())
                                ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.withdraw-affiliates.*'))
                                ->visible(fn(): bool => auth()->user()->hasRole('admin')),
                            ...WithdrawalResource::getNavigationItems(),
                        ]),

                    NavigationGroup::make('JOGOS DA PLATAFORMA')
                        ->items([
                            ...ProviderResource::getNavigationItems(),
                            ...GameResource::getNavigationItems(),
                        ]),

                    NavigationGroup::make('Otimização')
                        ->label('SISTEMA')
                        ->items([
                            NavigationItem::make('LIMPAR CACHE')
                                ->url(url('/clear'), shouldOpenInNewTab: false)
                                ->icon('heroicon-o-trash'),
                        ]),
                ]);
            })
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make());
    }
}
