<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Validator;
use App\Models\DateLoginLog;
use App\Models\DateData;
use App\Models\Push;
use App\Models\Restaurant;
use App\Models\RestaurantDate;
use App\Models\VideoDate;
use App\Models\Invitation;
use App\Models\Respond;
use App\Services\PushRuleService;

class DateController extends Controller
{
    private $pushRuleService;

    public function __construct(PushRuleService $pushRuleService)
    {
        $this->pushRuleService = $pushRuleService;
    }

    public function login()
    {
        if(Session::has('account')){
            return redirect('/date/data');
        }
        return view('date.login');
    }

    public function login_post(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');
        $ip_address = $request->ip();

        $rules = [
            'account' => 'required', 
            'password' => 'required',
        ];
        $messages = [
            'account.required' => '帳號為必填',
            'password.required' => '密碼為必填',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('/date/login')->withErrors($validator)->withInput();
        }

        $login = DateData::where([
            'identity' => $account,
            'phone' => $password
        ])->first();

        if($login != null){
            $DateLoginLog = new DateLoginLog();
            $DateLoginLog->identity = $account;
            $DateLoginLog->phone = $password;
            $DateLoginLog->ip_address = $ip_address;
            $DateLoginLog->status = 'success';
            $DateLoginLog->save();
            Session::put('account', $account);
            return redirect('/date/data');
        }else{
            $DateLoginLog = new DateLoginLog();
            $DateLoginLog->identity = $account;
            $DateLoginLog->phone = $password;
            $DateLoginLog->ip_address = $ip_address;
            $DateLoginLog->status = 'fail';
            $DateLoginLog->save();
            Session::flash('error_msg', '帳號或密碼登入錯誤');
            return redirect('/date/login');
        }
    }

    public function data()
    {
        if(!Session::has('account')){
            return redirect('/date/login');
        }

        $identity = Session::get('account'); 
        $data = [];

        //會員名稱
        $data['username'] = DateData::where('identity', $identity)->pluck('username')->first();

        //推播對象
        $data['push_data'] = $this->pushRuleService->pushMember($identity);

        //會員資料連結顯示
        $check = DateData::where('identity', $identity)->get(['gender','plan'])->toArray();
        if($check[0]['gender'] == 'm'){
            if($check[0]['plan'] == 'G' || $check[0]['plan'] == 'C' || $check[0]['plan'] == 'D'){
                $data['show'] = 'd';
            }else{
                $data['show'] = 's';
            }
        }
        if($check[0]['gender'] == 'g'){
            if($check[0]['plan'] == 'D'){
                $data['show'] = 'd';
            }else{
                $data['show'] = 's';
            }
        }
        

        return view('date.data', [ 'data' => $data ]);
    }

    public function invitation()
    {
        if(!Session::has('account')){
            return redirect('/date/login');
        }
        
        $identity = Session::get('account');
        $data = [];

        //約會餐廳
        $plan = DateData::where('identity', $identity)->pluck('plan')->first();
        if($plan != 'G'){
            $data['restaurant'] = Restaurant::where('qualification', 'no')->get(['place', 'url'])->toArray();
        }else{
            $data['restaurant'] = Restaurant::get(['place', 'url'])->toArray();
        }
       
        //顯示餐廳約會時間
        $data['restaurant_date'] = RestaurantDate::get(['datetime'])->toArray();

        //顯示視訊約會時間
        $data['video_date'] = VideoDate::get(['datetime'])->toArray();

        //推播對象
        $data['push_data'] = $this->pushRuleService->pushMember($identity);

        return view('date.invitation', [ 'data' => $data ]);
    }

    public function invitation_post(Request $request)
    {
        if(!Session::has('account')){
            return redirect('/date/login');
        }

        $identity = Session::get('account');
        $type = $request->input()['type'];

        if($request->input()['type'] == 'type1'){
            $rules = [
                'chat_option' => 'required',
                'datetime' => 'required',
                'push_user' => 'required'
            ];
            $messages = [
                'chat_option.required' => '請選擇視訊約會流程',
                'datetime.required' => '請選擇視訊聊天時間',
                'push_user.required' => '請選擇排約對象'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect('member_data')->withErrors($validator)->withInput();
            }
        }
        if($request->input()['type'] == 'type2'){
            $rules = [
                'date_restaurant' => 'required',
                'datetime2' => 'required',
                'push_user' => 'required'
            ];
            $messages = [
                'date_restaurant.required' => '請選擇約會餐廳',
                'datetime2.required' => '請選擇餐廳約會時間',
                'push_user.required' => '請選擇排約對象'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect('member_data')->withErrors($validator)->withInput();
            }
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('member_data')->withErrors($validator)->withInput();
        }

        $push_ary = $request->input()['push_user'];
        foreach($push_ary as $value){
            Invitation::where('invitation_identity', $value)->where('identity', $identity)->delete();
            $invitation = new Invitation();
            $invitation->identity = $identity;
            if($type == "type1"){
                $invitation->type = '視訊約會';
                $datetime = implode("、",$request->input()['datetime']);
                switch ($request->input()['chat_option']){
                    case 'v_1':
                        $invitation->chat_option = '自由聊天';
                        break;
                    case 'v_2':
                        $invitation->chat_option = '選擇話題聊天';
                        break;
                    case 'v_3':
                        $invitation->chat_option = '破冰遊戲>聊天';
                        break;
                }
                //$AppointmentRegistration->restaurant = '0';
                $invitation->datetime = $datetime;
            }
            if($type == "type2"){
                $invitation->type = '餐廳約會';
                $datetime = implode("、",$request->input()['datetime2']);
                //$AppointmentRegistration->chat_option = '0';
                $invitation->restaurant = $request->input()['date_restaurant'];
                $invitation->datetime = $datetime;
            }
            $invitation->invitation_identity = $value;
            $invitation->save();
        }

        
        return redirect('/date/data');
    }

    public function respond()
    {
        if(!Session::has('account')){
            return redirect('/date/login');
        }

        $identity = Session::get('account');
        $data = [];
        
        $invitation_data = Invitation::where('invitation_identity', $identity)->get()->toArray();
        foreach($invitation_data as $key => $value){
            $data = DateData::where('identity', $value['identity'])->get(['username', 'data_url', 'data_url_simple'])->toArray();
            $invitation_data[$key]['username'] = $data[0]['username'];
            $invitation_data[$key]['data_url'] = $data[0]['data_url'];
            $invitation_data[$key]['data_url_simple'] = $data[0]['data_url_simple'];
        }
        $data['invitation_data'] = $invitation_data;

        //會員資料連結顯示
        $check = DateData::where('identity', $identity)->get(['gender','plan'])->toArray();
        if($check[0]['gender'] == 'm'){
            if($check[0]['plan'] == 'G' || $check[0]['plan'] == 'C' || $check[0]['plan'] == 'D'){
                $data['show'] = 'd';
            }else{
                $data['show'] = 's';
            }
        }
        if($check[0]['gender'] == 'g'){
            if($check[0]['plan'] == 'D'){
                $data['show'] = 'd';
            }else{
                $data['show'] = 's';
            }
        }



        return view('date.respond', [ 'data' => $data ]);
    }

    public function respond_post(Request $request)
    {
        if(!Session::has('account')){
            return redirect('/date/login');
        }

        $identity = Session::get('account');

        $input = $request->input();

        foreach($input['id'] as $key => $value){
            if(!isset($input['respond'.$key])){
                continue;
            }
            $respond = implode("、", $request->input()['respond'.$key]);
            Invitation::where('id', $value)->update(['respond' => $respond]);
        }
    
        return redirect('/date/data');
    }

    public function restaurant()
    {
        if(!Session::has('account')){
            return redirect('/date/login');
        }
        $restaurant = Restaurant::get(['place', 'url'])->toArray();
        return view('date.restaurant', [ 'restaurant' => $restaurant ]);
    }

    public function logout()
    {
        Session::forget('account');
        return redirect('/date/login');
    }

    public function test()
    {
        if(!Session::has('account')){
            return redirect('/date/login');
        }
        $identity = Session::get('account');
        $data = Invitation::whereRaw("respond IS NOT NULL 
                            AND result IS NULL 
                            AND identity = '{$identity}' 
                            ORDER BY LENGTH(respond) ASC")         
                            ->get([
                                'type',
                                'identity',
                                'invitation_identity',
                                'respond',
                                'result'
                            ])
                            ->toArray();
        dd($data);
    }

    public function pair_time()
    {

        \Log::info('排約資料已設定');
        return redirect()->back();
    }

}
