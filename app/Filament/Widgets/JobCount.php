<?php

namespace App\Filament\Widgets;

use App\Models\Job;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Spatie\Permission\Models\Role;

class JobCount extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Jobs', Job::query()->count())
                ->description('Jobs Created')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Card::make('Users', User::query()->count())
                ->description('Users Created')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('warning'),
            Card::make('Roles', Role::query()->count())
                ->description('Roles Created')
                ->descriptionIcon('heroicon-o-lock-closed')
                ->color('danger'),
        ];
    }

}
