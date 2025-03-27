<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WithdrawalResource\Pages;
use App\Models\User;
use App\Models\Withdrawal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'SAQUES DE USUÁRIOS';

    protected static ?string $modelLabel = 'SAQUE';

    protected static ?string $navigationGroup = 'GESTÃO E FINANÇAS';

    protected static ?string $slug = 'todos-saques';

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['type', 'bank_info', 'user.name', 'user.last_name', 'user.cpf', 'user.phone',  'user.email'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 0)->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('status', 0)->count() > 5 ? 'success' : 'warning';
    }


    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('USUÁRIO')
                    ->searchable(['users.name', 'users.last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('VALOR')
                    ->formatStateUsing(fn(Withdrawal $record): string => 'R$ ' . number_format($record->amount, 2, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('pix_type')
                    ->label('TIPO DE CHAVE')
                    ->formatStateUsing(fn(string $state): string => \Helper::formatPixType($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('pix_key')
                    ->label('CHAVE PIX'),
                Tables\Columns\TextColumn::make('status')
                    ->label('STATUS')
                    ->formatStateUsing(fn(Withdrawal $record): string => match ($record->status) {
                        0 => 'Pendente',
                        1 => 'Aprovado',
                        2 => 'Cancelado',
                        default => 'Desconhecido'
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('CRIADO EM')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('ATUALIZADO EM')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('created_at')
                    ->label('Data de Criação')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('De'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Até'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($query) => $query->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn($query) => $query->whereDate('created_at', '<=', $data['created_until']));
                    }),
                Filter::make('status')
                    ->label('Status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                0 => 'Pendente',
                                1 => 'Aprovado',
                                2 => 'Cancelado',
                            ])
                            ->placeholder('Selecione um status'),
                    ])
                    ->query(fn($query, $data) => isset($data['status']) ? $query->where('status', $data['status']) : $query),
            ])
            ->actions([
                Action::make('refund_payment')
                    ->label('Reembolsar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn(Withdrawal $withdrawal): bool => !$withdrawal->status)
                    ->action(function (Withdrawal $withdrawal) {
                        $route = route('suitpay.cancelwithdrawal', ['id' => $withdrawal->id]);
                        \Filament\Notifications\Notification::make()
                            ->title('Reembolsar Saque')
                            ->success()
                            ->persistent()
                            ->body('Você está reembolsando o saque de ' . \Helper::amountFormatDecimal($withdrawal->amount))
                            ->actions([
                                \Filament\Notifications\Actions\Action::make('view')
                                    ->label('Confirmar')
                                    ->button()
                                     ->extraAttributes([
                                        'onclick' => <<<JS
                                            var apertou = false;
                                            this.disabled = true;
                                            if (!apertou) {
                                                apertou = true;
                                                var url = `$route`;
                                                window.location.href = url;
                                            }
                                        JS,
                                    ])     
                                    ->close(),
                                \Filament\Notifications\Actions\Action::make('undo')
                                    ->color('gray')
                                    ->label('Cancelar')
                                    ->action(function (Withdrawal $withdrawal) {
                                        // Ação de cancelamento se necessário
                                    })
                                    ->close(),
                            ])
                            ->send();
                    }),
                Action::make('approve_payment')
                    ->label('Fazer pagamento')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Withdrawal $withdrawal): bool => !$withdrawal->status)
                    ->action(function (Withdrawal $withdrawal) {
                        $route = route('withdrawal', ['id' => $withdrawal->id]);
                        \Filament\Notifications\Notification::make()
                            ->title('Saque')
                            ->success()
                            ->persistent()
                            ->body('Você está solicitando um saque de ' . \Helper::amountFormatDecimal($withdrawal->amount))
                            ->actions([
                                \Filament\Notifications\Actions\Action::make('view')
                                    ->label('Confirmar')
                                    ->button()
                                    ->extraAttributes([
                                        'onclick' => <<<JS
                                            var apertou = false;
                                            this.disabled = true;
                                            if (!apertou) {
                                                apertou = true;
                                                var url = `$route`;
                                                window.location.href = url;
                                            }
                                        JS,
                                    ])         
                                    ->close(),
                                \Filament\Notifications\Actions\Action::make('undo')
                                    ->color('gray')
                                    ->label('Cancelar')
                                    ->action(function (Withdrawal $withdrawal) {
                                        // Ação de cancelamento se necessário
                                    })
                                    ->close(),
                            ])
                            ->send();
                    }),
                Action::make('delete')
                    ->label('Excluir')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->visible(fn(Withdrawal $withdrawal): bool => in_array($withdrawal->status, [0, 1, 2]))
                    ->action(function (Withdrawal $withdrawal) {
                        $withdrawal->delete();
                        \Filament\Notifications\Notification::make()
                            ->title('Saque Excluído')
                            ->success()
                            ->persistent()
                            ->body('O saque foi excluído com sucesso.')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawals::route('/'),
        ];
    }
}
