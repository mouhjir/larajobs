<?php

namespace App\Filament\Resources;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;

class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public static function getNavigationLabel(): string
    {
        return trans('User');
    }

    public static function getPluralLabel(): string
    {
        return trans('Users');
    }

    public static function getLabel(): string
    {
        return trans('User');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('settings');
    }

    protected function getTitle(): string
    {
        return trans('User');
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'impersonate'
        ];
    }

    public static function form(Form $form): Form
    {
        $rows = [
            TextInput::make('name')->required()->label(trans('Name')),
            TextInput::make('email')->email()->required()->label(trans('Email')),
            Forms\Components\TextInput::make('password')->label(trans('Password'))
                ->password()
                ->maxLength(255)
                ->dehydrateStateUsing(static function ($state) use ($form){
                    if(!empty($state)){
                        return Hash::make($state);
                    }

                    $user = User::find($form->getColumns());
                    if($user){
                        return $user->password;
                    }
            }),
        ];

        if(config('filament-user.shield')){
            $rows[] = Forms\Components\MultiSelect::make('roles')->relationship('roles', 'name')->label(trans('Roles'));
        }

        $form->schema($rows);

        return $form;
    }

    public static function table(Table $table): Table
    {
        $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(trans('Id')),
                TextColumn::make('name')
                    ->sortable()->searchable()
                    ->label(trans('Name')),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label(trans('Email')),
                BooleanColumn::make('email_verified_at')
                    ->sortable()
                    ->searchable()
                    ->label(trans('Email verified at')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('created at'))
                    ->dateTime('M j, Y')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('updated at'))
                    ->dateTime('M j, Y')->sortable(),

            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->label(trans('Verified'))
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('unverified')
                    ->label(trans('Unverified'))
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Impersonate::make('impersonate')
                    ->visible(auth()->user()->can('impersonate_user'))
            ]);





        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
