<?php

namespace App\Orchid\Layouts;

use App\Models\Check;
use App\Models\Lead;
use Carbon\Carbon;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CheckCronLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'check';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('created_at', 'Создан')->render(function (Check $check) {

                return Carbon::createFromFormat('Y-m-d H:i:s', $check->created_at)->timezone('Europe/Moscow');
            }),
            TD::make('source_name', 'Источник'),
            TD::make('result', 'Результат'),
        ];
    }
}
