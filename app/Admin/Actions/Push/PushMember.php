<?php

namespace App\Admin\Actions\Push;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Push;


class PushMember extends BatchAction
{
    public $name = '確認推播';
    protected $selector = '.push-member';

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $identity = $model->identity;
            $pushes_user = Push::where('identity', $identity)->pluck('pushes_user')->first();
            $pushes_user_new = Push::where('identity', $identity)->pluck('pushes_user_new')->first();
            if($pushes_user != null){
                $pushes_user = $pushes_user.'、';
            }
            $update = [
                'pushes_user' => $pushes_user.$pushes_user_new,
                'pushes_user_new' => '',
                'pushes_user_latest' => $pushes_user_new
            ];
            Push::where('identity', $identity)->update($update);
        }

        return $this->response()->success('Success')->refresh();
    }

}