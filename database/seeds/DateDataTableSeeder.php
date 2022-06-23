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
            '2022-05-11 20:00:00',
            '2022-05-13 20:00:00',
            '2022-05-14 15:00:00',
            '2022-05-14 20:00:00',
            '2022-05-15 20:00:00',
            '2022-05-18 20:00:00',
            '2022-05-20 20:00:00',
            '2022-05-21 15:00:00',
            '2022-05-21 20:00:00',
            '2022-05-22 20:00:00'
        ];
        foreach($ary as $value){
            DB::table('restaurant_dates')->insert(
                ['datetime' => $value]
            );
        }

        $ary = [
            '2022-05-11 20:00:00',
            '2022-05-13 20:00:00',
            '2022-05-14 15:00:00',
            '2022-05-14 20:00:00',
            '2022-05-15 20:00:00',
            '2022-05-18 20:00:00',
            '2022-05-20 20:00:00',
            '2022-05-21 15:00:00',
            '2022-05-21 20:00:00',
            '2022-05-22 20:00:00'
        ];
        foreach($ary as $value){
            DB::table('video_dates')->insert(
                ['datetime' => $value]
            );
        }

        $ary = [
            ['place'=>'K.D Bistro Taipei(國父紀念館)(晚餐)(週一公休)', 'url'=>'https://2afoodie.com/k-dbistrotaipei/'],
            ['place'=>'Campus cafe忠孝店(忠孝復興)(下午茶&晚餐)', 'url'=>'https://masaharuwu.pixnet.net/blog/post/66338151'],
            ['place'=>'無聊咖啡AMBI-CAFE(忠孝敦化站)(下午茶)(晚上7點不供餐)(8點打烊)', 'url'=>'https://www.liviatravel.com/2018/07/ambi-cafe.html'],
            ['place'=>'Les Piccola Info.(東門站)(下午茶最晚訂位3點)(晚餐只能訂6點、6點半)(週一、週二公休)', 'url'=>'https://lingling.blog/les-p'],
            ['place'=>'Les Africot(東門站)(下午茶)(營業時間11點至5點)', 'url'=>'https://www.tiffany0118.com/les-africot/'],
            ['place'=>'BUNA CAFE布納咖啡館(內湖店&101站)(下午茶&晚餐)', 'url'=>'https://saliha.pixnet.net/blog/post/469428374'],
            ['place'=>'A Fabules Day(東門站)(下午茶&晚餐)', 'url'=>'https://tenjo.tw/afabulesday/'],
            ['place'=>'COFFEE FLAIR(中山國小站)(下午茶)', 'url'=>'https://reurl.cc/a9mK07'],
            ['place'=>'CIN CIN Osteria請請義大利慶城店(南京復興站)(下午茶只到4點&晚餐)', 'url'=>'https://reurl.cc/pg0enb'],
            ['place'=>'CIN CIN Osteria請請義大利逸仙店(國父紀念館)(下午茶只到4點&晚餐)', 'url'=>'https://aniseblog.tw/192073'],
            ['place'=>'誠品行旅the-chapter-cafe(松山站，下午茶&晚餐)', 'url'=>'https://peipei.tw/the-chapter-cafe/'],
            ['place'=>'MUGI木屐(忠孝敦化站，平日晚餐，假日中餐晚餐)', 'url'=>'https://wing1209.pixnet.net/blog/post/47204111'],
            ['place'=>'Muzeo餐酒館(忠孝敦化站，平日晚餐，假日中餐晚餐)', 'url'=>'https://kenalice.tw/blog/post/muzeo'],
            ['place'=>'木門咖啡 Wooden Door(下午茶&晚餐)', 'url'=>'https://sunnylife.tw/wd/'],
            ['place'=>'午街貳拾 Café Bistro(精明商圈，下午茶&晚餐)', 'url'=>'https://mercury0314.pixnet.net/blog/post/463363799-wjno20.cafe.bistro'],
            ['place'=>'KOI® PLUS (學士店)(下午茶&晚餐)', 'url'=>'https://w00243413.pixnet.net/blog/post/354296875'],
            ['place'=>'禾間糧倉(近科博館，晚餐)', 'url'=>'https://ants.tw/middle-restro/'],
            ['place'=>'薩克森餐酒館 Sachsen Beer Bar(近逢甲商圈，晚餐)', 'url'=>'https://ifoodie.tw/post/5fc8af6702935e4db5fbe19d'],
        ];
       
        foreach($ary as $value){
            DB::table('restaurants')->insert(
                ['place' => $value['place'], 'url' => $value['url']]
            );
        }


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


        $ary = [
            [
                'parent_id'=>'0',
                'order'=>'8',
                'title'=>'推播系統',
                'icon'=>'fa-bars',
                'uri'=>'',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'9',
                'title'=>'會員資料',
                'icon'=>'fa-bars',
                'uri'=>'/DateData',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'10',
                'title'=>'會員推播表',
                'icon'=>'fa-bars',
                'uri'=>'/Push',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'11',
                'title'=>'排約邀約表',
                'icon'=>'fa-bars',
                'uri'=>'/Invitation',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'12',
                'title'=>'排約回應表',
                'icon'=>'fa-bars',
                'uri'=>'/Respond',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'13',
                'title'=>'餐廳地點設定',
                'icon'=>'fa-bars',
                'uri'=>'/Restaurant',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'14',
                'title'=>'餐廳約會時間設定',
                'icon'=>'fa-bars',
                'uri'=>'/RestaurantDate',
                'permission'=>null,
            ],
            [
                'parent_id'=>'8',
                'order'=>'15',
                'title'=>'視訊約會時間設定',
                'icon'=>'fa-bars',
                'uri'=>'/VideoDate',
                'permission'=>null,
            ],

        ];
       
        foreach($ary as $value){
            DB::table('admin_menu')->insert(
                [
                    'parent_id' => $value['parent_id'],
                    'order' => $value['order'],
                    'title' => $value['title'],
                    'icon' => $value['icon'],
                    'uri' => $value['uri'],
                    'permission' => $value['permission'],
                ]
            );
        }
    }
}
