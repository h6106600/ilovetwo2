<?php

namespace App\Admin\Actions\Push;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\DateData;
use App\Models\Push;

class AddMember extends BatchAction
{
    public $name = '新增推播';
    protected $selector = '.add-member';
    public function handle(Collection $collection)
    {
        $str = '';
        foreach ($collection as $model) {
            $identity = $model->identity;
            $pushes_user = $model->pushes_user;
            $pushes_user_new = $model->pushes_user_new;
            $pushes_user_excluded = $model->pushes_user_excluded;
            $gender = DateData::where('identity', $identity)->pluck('gender')->first();
            $pushes_user_ary = explode('、', $pushes_user);
            $pushes_user_new_ary = explode('、', $pushes_user_new);
            $pushes_user_excluded_ary = explode('、', $pushes_user_excluded);
            $ary = array_merge($pushes_user_ary, $pushes_user_new_ary, $pushes_user_excluded_ary);
            $data = DateData::whereNotIn('identity',$ary)->where('gender', '!=' ,  $gender)->pluck('identity')->toArray();
            if(count($data) > 1){
                $rand_keys = array_rand ($data, 2); 
                $str = $data[$rand_keys[0]].'、'.$data[$rand_keys[1]];
            }
            if(count($data) == 1){
                $str = $data[0];
            } 
            if(count($data) == 0){
                $str = '';
            } 
            Push::where('identity', $identity)->update(['pushes_user_new' => $str]);
        }

        return $this->response()->success('Success')->refresh();
    }

}