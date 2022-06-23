<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Validator;
use App\Models\DateLoginLog;
use App\Models\DateData;

class DateController extends Controller
{
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
            return redirect('/login');
        }

        $account = Session::get('account'); 
        $data = DateData::where('identity', $account)->get()->first();

        return view('date.data', [ 'data' => $data  ]);
    }

    public function invitation()
    {
        
        return view('date.invitation');
    }

    public function invitation_post()
    {
        
        
    }

    public function respond()
    {
       
        return view('date.respond');
    }

    public function respond_post()
    {
        
        
    }

    public function restaurant()
    {
       
        return view('date.restaurant');
    }

    public function logout()
    {
        Session::forget('account');
        return redirect('/date/login');
    }

    public function test()
    {
       echo 'test';
    }

}
