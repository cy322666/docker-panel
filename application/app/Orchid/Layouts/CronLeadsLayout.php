<?php

namespace App\Orchid\Layouts;

use App\Models\Lead;
use Carbon\Carbon;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CronLeadsLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'leads';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('created_at', 'Создан')->render(function (Lead $lead) {

                return Carbon::createFromFormat('Y-m-d H:i:s', $lead->created_at)->timezone('Europe/Moscow');
            }),
            TD::make('lead_id', 'ID сделки'),

            TD::make('utm_source', 'utm_source'),
            TD::make('utm_medium', 'utm_medium'),
            TD::make('utm_content', 'utm_content'),
            TD::make('utm_campaign', 'utm_campaign'),
            TD::make('utm_term', 'utm_term'),
            TD::make('telephony', 'Телефония'),

            TD::make('pipeline_id', 'Воронка'),
            TD::make('status_id', 'Этап')->defaultHidden(true),
            TD::make('contact_id', 'Контакт')->defaultHidden(true),
            TD::make('responsible_user_id', 'Ответственный')->defaultHidden(true),
            TD::make('tags', 'Теги')->defaultHidden(true),
        ];
    }
}
