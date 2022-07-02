<?php
namespace App\Services;

use App\Models\Push;
use App\Models\DateData;

class PushRuleService
{
    //推播對象
    public function pushMember($identity)
    {
        $push_data = Push::where('identity', $identity)->pluck('pushes_user')->first();
        $push_data = explode('、', $push_data);
        $data = DateData::whereIn('identity', $push_data)->get(['identity', 'gender','username','data_url','data_url_simple', 'plan'])->toArray();
        return $data;
    }
}