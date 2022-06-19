<?php

use Illuminate\Database\Seeder;

class DateDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ary = [
            [  
                'username'=>'luke',
                'identity'=>'a123456789',
                'phone'=>'0912345678',
                'gender'=>'m',
                'consultant'=>'sam',
                'data_url'=>'https://drive.google.com/drive/folders/luke',
                'data_url_simple'=>'https://drive.google.com/drive/folders/luke',
                'plan'=>'G',
                'live_place'=>'台北',
                'birth_place'=>'桃園',
                'for_light_plan'=>'Y',
                'record'=>'123', 
            ],
           
        ];
          
        foreach($ary as $value){
            DB::table('date_data')->insert(
                [
                    'phone'    => $value['phone'],
                    'username'   => $value['username'],
                    'identity'   => $value['identity'],
                    'gender'     => $value['gender'],
                    'consultant' => $value['consultant'],
                    'data_url'   => $value['data_url'],
                    'data_url_simple'   => $value['data_url_simple'],
                    'plan'   => $value['plan'],
                    'live_place'   => $value['live_place'],
                    'birth_place'   => $value['birth_place'],
                    'for_light_plan'   => $value['for_light_plan'],
                    'record'   => $value['record'],
                ]
            );
        }
    }
}
