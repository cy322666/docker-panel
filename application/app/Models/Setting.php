<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'cron_status',
        'cron_time',
        'source_name',
        'status',
        'current_check',
        'telephony',
    ];

    private array $search_fields = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'telephony',
    ];

    /**
     * проверка на отсутсвие лидов
     */
    public function checkFail($current_check_date) : bool
    {
        return $this->getLeads($this->search_fields, $current_check_date);
    }

    /**
     * @param array $search_fields массив ключей для поиска
     * @param $current_check_date
     * @return bool
     */
    private function getLeads(array $search_fields, $current_check_date) : bool
    {
        $query = (new Lead)
            ->getConnection()
            ->table('leads')
            ->select('*');

        foreach ($search_fields as $search_field) {

            //$search_field значение в настройке по ключу в массиве поиска
            if($this->$search_field !== null) {

                $query = $this->buildQuery($query, $search_field, $this->$search_field);
            }
        }

        $result = $query->where('created_at', '>', $current_check_date)->first();

        return $result == true;
    }

    private function buildQuery($query, string $search_field, string $search_field_value)
    {
        if(strripos($search_field_value, 'search') !== false) {

            $search_value = str_replace(['{', '}'], '', $search_field_value);

            return $query->where($search_field, 'like', '%'.explode(':', $search_value)[1].'%');
        }

        return match ($search_field_value) {

            default    => $query->where($search_field, $this->$search_field),
            '{exist}'  => $query->where($search_field, '!=', null),
            '{!exist}' => $query->where($search_field, '=', null),
        };
    }
}
