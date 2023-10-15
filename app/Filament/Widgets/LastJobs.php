<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Job;
use App\Models\user;
use Filament\Widgets\TableWidget as BaseWidget;

class LastJobs extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Job::latest()->take(5)
            )
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
            Tables\Columns\TextColumn::make('website')
           
                
            ]);
    }
}
 