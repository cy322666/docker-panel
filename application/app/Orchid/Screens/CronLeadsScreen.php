<?php

namespace App\Orchid\Screens;

use App\Models\Lead;
use App\Orchid\Layouts\CronLeadsLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class CronLeadsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Созданные лиды';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'leads' => Lead::orderBy('created_at', 'desc')->paginate(15),
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            CronLeadsLayout::class,
        ];
    }
}
