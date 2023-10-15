<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Filament\Resources\JobResource\RelationManagers;
use App\Models\Job;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
/*                Forms\Components\TextInput::make('user_id')
                    ->numeric()
                    ->required(),*/
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('company')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TagsInput::make('tags')
                    ->separator(',')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/webp'])
                    ->disk('public')
                    ->directory('jobs/posts')
                    ->visibility('public')
                    ->enableDownload()
                    ->enableOpen()
                    ->imagePreviewHeight('100px')
                    ->maxSize(10240),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->label(__('user name'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->getStateUsing(fn($record)=> User::query()->find($record->user_id)?->name),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('tags'),
                Tables\Columns\TextColumn::make('company'),
                Tables\Columns\TextColumn::make('location'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('website'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('logo'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
