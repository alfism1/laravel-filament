<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected static ?int $sort = 2;


    protected function getStats(): array
    {
        return [
            Stat::make('New Users', User::count())
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->description('The number of new users in the system.')
                ->chart([1, 6, 2, 8, 3, 9, 1, 12])
                ->color('success')
        ];
    }

    public function getColumns(): int
    {
        return 1;
    }
}
