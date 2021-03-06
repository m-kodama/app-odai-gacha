<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>お題ガチャ</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <script src="../../js/lib/anime.min.js"></script>
  <script src="../../js/util.js"></script>
  <script src="../../js/class/Handle.js"></script>
  <script src="../../js/class/Gacha.js"></script>
  <script src="../../js/index.js"></script>
  <link rel="stylesheet" href="../../css/index.css">
</head>
<body>
  <div id="stage">
      <div id="touch-eater"></div>
      <img src="../../img/gacha_body.png" alt="" id="gacha-body" class="gacha" draggable="false">
      <img src="../../img/gacha_handle.png" alt="" id="handle" class="gacha" draggable="false">
      <img src="../../img/arrow.png" alt="" id="arrow" class="arrow" draggable="false">
      <div id="arrow-text">後ろに回してね</div>
      <img src="../../img/egg_01.png" alt="" id="egg" class="egg" draggable="false">
      <div id="odai">
        <div id="odai-text"></div>
        <div style="height: 8px;"></div>
        <button id="close-btn">閉じる</button>
      </div>
  </div>

  <script>
    // お題を読み込む
    GACHA.odai = @json($odai);
  </script>
</body>
</html>