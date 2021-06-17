<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <script src="js/jquery-1.11.0.min.js"></script>
</head>
<body>
<!-- 代码 begin -->
<div id="applyFor" style="text-align: center;display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh;">

  <div style="width: 100%;">
    <p> {{$message}}</p>
  </div>
	<div style="width: 100%;">
        <p>
            <a href="{{$url}}" style="color: red">GO BACK</a>
    	</p>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
   
</script>