@include('date.components.head')

    <style>
        .jumbotron{
            background-color:#c3a367;
            color:#2b2b2b;
            border-radius:0px;
        }
        body{
            background-color:#2b2b2b;
            color:#c3a367;
        }
    </style>
</head>
<body>
			
<div style="padding-top:20px;padding-right:20px;" class="float-right">
    <a href="/date/logout" class="btn btn-danger">登出</a>
</div>

<div class="jumbotron text-center">
    <h2><strong>會員暱稱：{{ $data['username'] }}</strong></h2>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
		<h5><strong>為了更加速服務大家，促成大家多多約會，請詳讀以下"約會配對"流程內容：</strong></h5>
		<h5>Setp1 . 週一中午前：公布異性資料於專屬資料夾。</h5>
		<h5>Step2 . 週一~週二：您若有想約的異性，請直接填寫下方的約會時間表，未填則代表都沒意願。</h5>
		<h5>Step3 . 週三~週四：我們會私訊被約者是否有約會意願，若有意願，請直接填寫下方的約會回應表，未填則代表目前沒意願。</h5>
		<h5>Step4 . 週五：我們會公布約會結果與時間。	</h5>
		<br>

        <a class="btn btn-primary" href="/date/invitation"
        style="width:150px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">
            約會邀請表
        </a>

        <a class="btn btn-primary" href="/date/respond"
        style="width:150px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">
            約會回應表
        </a>
        
        <br><br>
    </div>
    <div class="col-sm-12">
        <h3>推播會員 :</h3>
        @foreach($data['push_data'] as $value)
        <div>
            <span>{{ $value['username'] }}</span>&nbsp;&nbsp;
            <br>
            <a href="" target="_blank"
            style="color:#c3a367;">
                詳細資料 : {{ $value['data_url'] }}
            </a>
            <br>
            <a href="" target="_blank"
            style="color:#c3a367;">
                刪減版資料 : {{ $value['data_url_simple'] }}
            </a>
        </div>&nbsp;
        @endforeach
    </div>
  </div>
</div>
<br><br>

<script>
    

</script>
</body>
</html>
