<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Check;
use App\Models\Lead;
use App\Models\Setting;
use App\Services\amoCRM\Client;
use App\Services\amoCRM\EloquentStorage;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CronController extends Controller
{
    /**
     * крон проверки лидов у источников
     *
     * @throws GuzzleException
     */
    public function check()
    {
        $settings = Setting::where('cron_status', 1)->get();

        if($settings->count() > 0) {

            foreach ($settings as $setting) {

                $now_date = Carbon::now()->format('Y-m-d H:i:s');

                $current_check_date = Carbon::createFromFormat('Y-m-d H:i:s', $setting->current_check);

                $current_add_timestamp = $current_check_date->addMinutes($setting->cron_time);

                if($current_add_timestamp < $now_date) {

                    $setting->current_check = $now_date;
                    $setting->save();

                    $check = new Check();
                    $check->source_name = $setting->source_name;
                    $check->setting_id = $setting->id;

                    if($setting->checkFail($current_check_date)) {

                        $check->result = 'exists';
                        $check->save();

                    } else {

                        $check->result = 'not found';
                        $check->save();

                        \App\Services\Slack\Client::send(
                            $setting->source_name,
                            Check::where('result', 'leads exists')->first()?->setting->current_check,
                        );
                    }
                }
            }
        }
    }

    /**
     * хук от амо о создании сделки
     *
     * @param Request $request
     * @throws Exception
     */
    public function hook(Request $request)
    {
        $access = Access::all()->first() ?? Access::create([
                'subdomain'     => env('AMO_DOMAIN'),
                'client_id'     => env('AMO_CLIENT_ID'),
                'client_secret' => env('AMO_CLIENT_SECRET'),
                'redirect_uri'  => env('AMO_REDIRECT_URI'),
                'code'          => env('AMO_CODE'),
            ]);

        $amocrm = (new Client())->init(new EloquentStorage([], $access));

        $lead = $amocrm->service
            ->leads()
            ->find($request->toArray()['add'][0]['id']);

        if($lead) {

            Lead::create([
                'lead_id'      => $lead->id,
                'utm_source'   => $lead->cf('utm_source')->getValue(),
                'utm_content'  => $lead->cf('utm_content')->getValue(),
                'utm_term'     => $lead->cf('utm_term')->getValue(),
                'utm_campaign' => $lead->cf('utm_campaign')->getValue(),
                'utm_medium'   => $lead->cf('utm_medium')->getValue(),
                'responsible_user_id' => $lead->responsible_user_id,
                'telephony'    => $lead->cf('Телефония')->getValue(),
                'status_id'    => $lead->status_id,
                'pipeline_id'  => $lead->pipeline_id,
                'tags'         => json_encode($lead->tags),
                'contact_id'   => $lead->contact?->id,
            ]);
        } else
            Log::error(__METHOD__.' : not found lead : '.$request->toArray()['leads']['add'][0]['id']);
    }
}
