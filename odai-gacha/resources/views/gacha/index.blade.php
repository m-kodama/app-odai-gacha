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
  @foreach($gachas as $gacha)
  <p><a href="http://localhost:8000/gacha/{{$gacha->gacha_id}}/edit">{{$gacha->gacha_name}}</a></p>
  @endforeach
  </div>
</body>
</html>