<?php

namespace App\Admin\Actions\Push;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Push;

class BackMember extends BatchAction
{
    public $name = '推播退回';
    protected $selector = '.back-member';
    public function handle(Collection $collection)
    {
        foreach ($collection as $model){
            $identity = $model->identity;
            $pushes_user_latest = Push::where('identity', $identity)->pluck('pushes_user_latest')->first();
            $pushes_user_latest_ary = explode("、", $pushes_user_latest);
            $pushes_user = Push::where('identity', $identity)->pluck('pushes_user')->first();
            $pushes_user_ary = explode("、", $pushes_user);

            $result = array_diff($pushes_user_ary, $pushes_user_latest_ary);
            $result = implode("、", $result);

            Push::where('identity', $identity)->update([
                'pushes_user' => $result,
                'pushes_user_latest' => null
            ]);
        }

        return $this->response()->success('Success')->refresh();
    }

}