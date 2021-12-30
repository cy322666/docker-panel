<?php

namespace App\Orchid\Screens;

use App\Models\Check;
use App\Orchid\Layouts\CheckCronLayout;
use Orchid\Screen\Screen;

class CheckCronScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Список проверок';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'check' => Check::orderBy('created_at', 'desc')->paginate(15),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            CheckCronLayout::class,
        ];
    }
}
