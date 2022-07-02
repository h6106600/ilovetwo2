@include('date.components.head')

    <style>
        .jumbotron{
            background-color:#c3a367;
            color:#2b2b2b;
        }
        body{
            background-color:#2b2b2b;
            color:#c3a367;
        }

    </style>
</head>
<body>

<div style="padding-top:20px;padding-right:20px;" class="float-right">
    <a href="/date/data" class="btn btn-primary">回上頁</a>
</div>
<div class="jumbotron text-center">
    <h2><strong>約會回應表</strong></h2>
</div>
        @if(count($data['invitation_data']) < 1)
            <h2  class='text-center' style="color:red;">目前沒有可回應的對象</h2>
        @endif
        <form action="/date/respond_post" method="post" id="respond_form">
            @csrf
            <br>
                @if(count($data['invitation_data']) >= 1)
                <div class="container">
                    <div class="box">
                        <h5>選擇回應對象 : </h5>
                        <hr style="background-color:#c3a367;">
                        @foreach($data['invitation_data'] as $key => $value)
                            <input type="hidden" name="id[]" value="{{ $value['id'] }}" >
                            <div class="col-md-12">
                                <h3 style="">
                                    {{ $value['username'] }}
                                </h3>
                                @if($data['show'] == 'd' || empty($value['data_url_simple']))
                                    <div>{{ $value['data_url'] }}</div>
                                @else
                                    <div>{{ $value['data_url_simple'] }}</div>
                                @endif
                                <div>約會形式 : {{ $value['type'] }}</div>
                                @if($value['type'] == '餐廳約會')
                                    <span>餐廳地點 : {{ $value['restaurant'] }}</span>
                                    <div>選擇可以排約的時間(可複選)或選擇其他回應 : </div>
                                    <?php $datetime = explode('、', $value['datetime']); ?>
                                    @foreach($datetime as $val)
                                        <label>
                                            <input type="checkbox" class="get{{$key+1}}" item={{$key+1}} onClick="getTime(event,this);" name="respond{{$key}}[]"  value="{{ $val }}">
                                            @php 
                                                $week = date('w',strtotime($val)); 
                                                if($week == 0) $week = '日';
                                                if($week == 1) $week = '一';
                                                if($week == 2) $week = '二';
                                                if($week == 3) $week = '三';
                                                if($week == 4) $week = '四';
                                                if($week == 5) $week = '五';
                                                if($week == 6) $week = '六';
                                            @endphp
                                            {{ date('Y/m/d', strtotime($val)) }} ({{$week}}) {{ date('H點i分', strtotime($val)) }} ~ {{ date('H點i分', strtotime($val)+2*60*60) }}
                                        </label>
                                    @endforeach
                                @endif
                                @if($value['type'] == '視訊約會')
                                    <span>聊天方式 : {{ $value['chat_option'] }}</span>
                                    <div>選擇可以排約的時間(可複選)或選擇其他回應 : </div>
                                    <?php $datetime = explode('、', $value['datetime']); ?>
                                    @foreach($datetime as $val)
                                        <label>
                                            <input type="checkbox" class="get{{$key+1}}" item={{$key+1}} onClick="getTime(event,this);" name="respond{{$key}}[]"  value="{{ $val }}">
                                            @php
                                                $week = date('w',strtotime($val)); 
                                                if($week == 0) $week = '日';
                                                if($week == 1) $week = '一';
                                                if($week == 2) $week = '二';
                                                if($week == 3) $week = '三';
                                                if($week == 4) $week = '四';
                                                if($week == 5) $week = '五';
                                                if($week == 6) $week = '六';
                                            @endphp
                                            {{ date('Y/m/d', strtotime($val)) }} ({{$week}}) {{ date('H點i分', strtotime($val)) }} ~ {{ date('H點i分', strtotime($val)+1*60*30) }}
                                        </label>
                                    @endforeach
                                @endif
                                
                                <br>
                                <label>
                                    <input type="checkbox" class="no{{$key+1}}" item={{$key+1}} onClick="noTime(event,this);" name="respond{{$key}}[]"  value="noTime">
                                    <span>以上時間無法配合，要另約時間</span>
                                </label>
                                <br>
                                <label>
                                    <input type="checkbox" class="del{{$key+1}}" item={{$key+1}} onClick="delUser(event,this);" name="respond{{$key}}[]"  value="delete">
                                    <span>沒有意願排約</span>
                                </label>
                                <br><br>
                                @if(!empty($value['respond']))
                                    @if($value['respond'] == 'delete')
                                        <h3 style="color:green">已回復 : 沒有意願排約</h3>
                                    @elseif($value['respond'] == 'noTime')
                                        <h3 style="color:green">已回復 : 以上時間無法配合，要另約時間</h3>
                                    @else
                                        <h3 style="color:green">已回復 : {{ $value['respond'] }}</h3>
                                    @endif
                                @endif
                                <!-- <label>
                                    <input type="checkbox" class="nosel{{$key+1}}" item={{$key+1}} onClick="nosel(event,this);" name="respond{{$key}}[]"  value="nosel">
                                    <span>暫不回應</span>
                                </label> -->
                                <br>
                            </div>

                            <hr style="border:1px solid #c3a367;width:100%;">
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary"
                    style="width:100px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">送出</button>
                    <a type="button" class="btn btn-danger" href="/date/data"
                    style="width:100px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">取消</a>
                </div>
                @endif
            <br>
        </form>

<br><br>

<script>
    function getTime(e){
        var item = e.target.getAttribute('item');
        if(e.target.checked){
            if(!$(".sel"+ item).is(':checked')){
                $(".sel" + item).prop('checked',true);
            }
            $(".no" + item).prop('checked',false);
            $(".del" + item).prop('checked',false);
            $(".nosel" + item).prop('checked',false);
        }
        
    }
    function noTime(e){
        var item = e.target.getAttribute('item');
        if(e.target.checked){
            if(!$(".sel"+ item).is(':checked')){
                $(".sel" + item).prop('checked',true);
            }
            $(".get" + item).prop('checked',false);
            $(".del" + item).prop('checked',false);
            $(".nosel" + item).prop('checked',false);
        }
    }
    function delUser(e){
        var item = e.target.getAttribute('item');
        if(e.target.checked){
            if(!$(".sel"+ item).is(':checked')){
                $(".sel" + item).prop('checked',true);
            }
            $(".get" + item).prop('checked',false);
            $(".no" + item).prop('checked',false);
            $(".nosel" + item).prop('checked',false);
        }
    }
        
    function nosel(e){
        var item = e.target.getAttribute('item');
        if(e.target.checked){
            if(!$(".sel"+ item).is(':checked')){
                $(".sel" + item).prop('checked',true);
            }
            $(".get" + item).prop('checked',false);
            $(".no" + item).prop('checked',false);
            $(".del" + item).prop('checked',false);
        }
    }
</script>
</body>
</html>