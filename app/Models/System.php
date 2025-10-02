<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class System extends Model
{
    use HasFactory;

    protected static $events = [
        [
            'id' => 1,
            'name' => 'Bhayangkara RUN',
            'date' => '2025-07-20',
            'category' => ['5k'],
            'link_api' => '',
            'active' => true,
        ],
        [
            'id' => 2,
            'name' => 'Merdeka RUN',
            'date' => '2025-09-28',
            'category' => ['5k', '10k', '21k'],
            'link_api' => '',
            'active' => true,
        ],
        [
            'id' => 3,
            'name' => 'Seruling Mas RUN for Animals',
            'date' => '2025-09-14',
            'category' => ['10k'],
            'link_api' => '',
            'active' => true,
        ],
        [
            'id' => 4,
            'name' => 'Mexolie',
            'date' => '2025-09-28',
            'category' => ['8k'],
            'link_api' => '',
            'active' => true,
        ],
        [
            'id' => 5,
            'name' => 'BJR 2026',
            'date' => '2026-02-22',
            'category' => ['10k'],
            'link_api' => '',
            'active' => false,
        ],
    ];

    public static function getEvents(){
        $data = array_filter(self::$events, function ($item) {
            return $item['active'] === true;
        });

        $data = array_values($data);

        return $data;
    }

    public static function getEvent($id){
        $collection = collect(self::$events);
        $data = $collection->firstWhere('id', $id);

        return $data;
    }
}
