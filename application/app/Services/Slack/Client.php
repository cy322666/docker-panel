<?php

namespace App\Services\Slack;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

abstract class Client
{
    /**
     * @throws GuzzleException
     */
    public static function send(string $source, string $date = null)
    {
        $body = [
            'title' => 'amoCRM',
            'alert' => 'Не приходят лиды с источника. Название источника: '.$source.' Последняя успешная проверка: '.$date,
            'color' => '0000ff',
        ];

        $response = (new \GuzzleHttp\Client())->get('https://gigwork.space/webhooks/amo/alerting.txt?'.http_build_query($body));

        if($response->getStatusCode() != 200) {

            Log::error(__METHOD__, [$response->getBody()]);
        }
    }
}
