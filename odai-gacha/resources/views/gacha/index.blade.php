<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>お題ガチャ</title>

  <script src="{{ mix('js/gacha/app.js') }}" defer></script> 
</head>
<body>
  <div id="app">
    <App _gachas="{{ $gachas }}"></App>
  </div>
</body>
</html>