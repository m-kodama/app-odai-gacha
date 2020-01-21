<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>お題ガチャ</title>
  <script src="js/lib/anime.min.js"></script>
  <script src="js/util.js"></script>
  <script src="js/class/Handle.js"></script>
  <script src="js/class/Gacha.js"></script>
  <script src="js/index.js"></script>
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <div>
  これは新規作成/編集のページです。
  @if(isset($gacha))
  <p>これ編集するやつ: {{$gacha->gacha_name}}<p>
  @endif
  </div>
  @if(isset($gacha))
  <form action="/gacha/{{$gacha->gacha_id}}" method="post">
    <input name="_method" type="hidden" value="PUT">
  @else
  <form action="/gacha" method="post">
  @endif

    @csrf
    <p>
      ガチャの名前：<input type="text" name="gacha_name" size="50" value="{{$gacha->gacha_name ?? ''}}">
    </p>
    <input type="submit" value="登録">
  </form>

  @if(isset($gacha))
  <form action="/gacha/{{$gacha->gacha_id}}" method="post">
    @csrf
    <input name="_method" type="hidden" value="DELETE">
    <input type="submit" value="消す">
  </form>
  @endif
</body>
</html>