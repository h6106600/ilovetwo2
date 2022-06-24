@include('date.components.head')
  <style>
        body{
            background-color:#2b2b2b;
            color:#c3a367;
        }
    </style>
</head>
<body>


<br><br>
<div class="container" style="max-width:500px;">
	<h2 class="text-center"><strong>愛樂Two排約會員登入</strong></h2>
	<br>
	@if(Session::has('error_msg'))
		<div class="alert alert-danger">{{Session::get('error_msg')}}</div>
	@endif
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<form action="/date/login_post" method="post">
		@csrf
		<div class="form-group">
		  <label for="account">帳號:</label>
		  <input type="text" class="form-control" id="account" placeholder="輸入帳號" name="account" value="{{old('account')}}" required>
		</div>
		<div class="form-group">
		  <label for="password">密碼:</label>
		  <input type="password" class="form-control" id="password" placeholder="輸入密碼" name="password" value="{{old('password')}}" required>
		</div>
		<br>
		<div class="text-center">
			<button type="submit" class="btn btn-primary"
            style="width:100px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">登入</button>
		</div>
	</form>
</div>

</body>
</html>