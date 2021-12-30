<?php

namespace App\Orchid\Screens;

use App\Models\Setting;
use Carbon\Carbon;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Switcher;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CronSettingsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Настройка кронов';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'settings' => Setting::all(),
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
            Layout::rows([
                Matrix::make('settings')
                    ->title('Кроны')
                    ->columns([
                        'source_name',
                        'utm_source',
                        'utm_medium',
                        'utm_campaign',
                        'utm_term',
                        'utm_content',
                        'telephony',
                        'cron_time',
                        'cron_status'
                    ])->fields([
                        'source_name'  => TextArea::make(),
                        'utm_source'   => TextArea::make(),
                        'utm_medium'   => TextArea::make(),
                        'utm_campaign' => TextArea::make(),
                        'utm_term'     => TextArea::make(),
                        'utm_content'  => TextArea::make(),
                        'telephony'    => TextArea::make(),
                        'cron_time'    => Input::make()->type('number'),
                        'cron_status'  => Switcher::make('free-switch')
                            ->sendTrueOrFalse()
                            ->horizontal(),
                    ]),

                Button::make('Сохранить')
                    ->method('buttonClickProcessing')
                    ->type(Color::DEFAULT()),
            ]),
        ];
    }

    public function buttonClickProcessing(Request $request)
    {
        try {

            if($request->toArray()) {

                foreach (Setting::all()->toArray() as $setting) {

                    if(!isset($setting['source_name'], $array)) {

                        Setting::find($setting['id'])->delete();
                        }
                    }

                    foreach ($request->toArray()['settings'] as $array) {

                        $setting = Setting::where('source_name', $array['source_name'])->first();

                        if(!$setting)
                            Setting::create($array + ['current_check' => Carbon::now()->format('Y-m-d H:i:s')]);
                        else {
                            $setting->fill(['current_check' => Carbon::now()->format('Y-m-d H:i:s')]);
                            $setting->save();
                        }
                    }
                }

                Alert::success('Сохранено');

        } catch (\Exception $exception) {

            Alert::error($exception->getMessage());
        }
    }
}
