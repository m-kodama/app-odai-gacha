// 初期化
const init = () => {
  // サイズ調整
  const stage = document.getElementById('stage');
  const gacha = document.getElementById('gacha-body');
  const widthRate = (stage.clientWidth * 0.85) / gacha.width;
  const heightRate = (stage.clientHeight * 0.85) / gacha.height;
  const imgScale = widthRate > heightRate ? heightRate : widthRate;
  const imgs = document.getElementsByTagName('img');
  for (let img of imgs) {
    img.width *= imgScale;
  }

  // 初期配置
  const handle = document.getElementById('handle');
  const eggNormal = document.getElementById('egg-normal');
  const eggSilver = document.getElementById('egg-sliver');
  const eggGold = document.getElementById('egg-gold');
  const eggPlatinum = document.getElementById('egg-platinum');
  // left
  gacha.style.right = gacha.clientWidth * -0.3 + 'px';
  handle.style.right = gacha.clientWidth * 0.1 + 'px';
  eggNormal.style.right = gacha.clientWidth * 0.4 + 'px';
  eggSilver.style.right = eggNormal.style.right;
  eggGold.style.right = eggNormal.style.right;
  eggPlatinum.style.right = eggNormal.style.right;
  // top
  handle.style.top = gacha.clientHeight * 0.275 + 'px';
  eggNormal.style.top = gacha.clientHeight * 0.35 + 'px';
  eggSilver.style.top = eggNormal.style.top;
  eggGold.style.top = eggNormal.style.top;
  eggPlatinum.style.top = eggNormal.style.top;

  // お題
  const odaiView = document.getElementById('odai');
  const odaiText = document.getElementById('odai-text');
  const closeBtn = document.getElementById('close-btn');
  odaiView.style.left = calcCenteringLeftParam(odaiView, stage) + "px";
  odaiView.style.top = gacha.clientHeight * 0.25 + "px";
  closeBtn.style.top = -1 * gacha.clientHeight * 0.05 - 8 + "px";
  closeBtn.addEventListener("click", onClickCloseBtn, false);
  odaiView.style.display = "none";

  // クラス生成
  const handleAnime = new Handle(document.getElementById('handle'));

  // イベント設定
  handle.addEventListener(
    'pointerdown',
    event => {
      handleAnime.pickStart(event.x, event.y);
    },
    false
  );
  stage.addEventListener(
    'pointerup',
    event => {
      handleAnime.resetRotate();
    },
    false
  );
  stage.addEventListener(
    'pointermove',
    event => {
      if (handleAnime.turnOver(event.x, event.y)) {
        startGacha();
      }
    },
    false
  );
};
window.onload = init;

// 左右中央揃えになるleft値を返す
const calcCenteringLeftParam = (element, targetElement) => {
  const targetLeft = Number(targetElement.style.left.replace('px', ''));
  return (targetElement.clientWidth - element.clientWidth) / 2 + targetLeft;
};

// ガチャを回す
const startGacha = () => {
  document.getElementById('touch-eater').style.display = 'block';
  const gacha = document.getElementById('gacha-body');
  const odai = GACHA.getOdai();
  const eggs = document.getElementsByClassName('egg');
  egg = eggs[odai.rarity];

  // アニメーション開始
  const timeline = anime.timeline();
  timeline
    // ハンドルのアニメーション
    .add({
      targets: '#handle',
      rotate: 360,
      duration: 1000,
      easing: 'easeOutBounce'
    })
    .add({
      targets: '#handle',
      rotate: 0,
      duration: 450,
      easing: 'easeOutBounce',
      update: (anim) => {
        if (anim.progress > 50 && anim.progress < 60) {
          egg.style.visibility = 'visible';
        }
      }
    })
    // カプセル排出アニメーション
    .add({
      targets: '#stage',
      scale: 1.4,
      translateX: gacha.clientWidth * 0.4,
      duration: 450,
      easing: 'easeOutSine'
    })
    .add({
        targets: egg,
        delay: -1 * (450 * 0.5 + 450),
        translateX: {
          value: gacha.clientWidth * -0.8,
          duration: 1200,
          easing: 'easeOutSine'
        },
        translateY: {
          value: gacha.clientHeight * 0.44,
          duration: 1000,
          easing: 'easeOutBounce'
        },
        rotate: {
          value: -360,
          duration: 1200,
          easing: 'easeOutSine'
        }
    })
    .add({
      targets: '#stage',
      scale: 1,
      translateX: 0,
      duration: 250,
      delay: 200,
      easing: 'easeOutSine',
      complete: () => {
        showOdai(odai);
      }
    });
};
// お題表示
const showOdai = odai => {
  const odaiText = document.getElementById("odai-text");
  odaiText.innerText = odai.text;
  document.getElementById('odai').style.display = 'flex';

  // 1行に収める
  odaiTextFontSize = 48;
  odaiText.style.fontSize = odaiTextFontSize + "px";
  while (odaiText.clientHeight > 62) {
    odaiTextFontSize -= 1;
    odaiText.style.fontSize = odaiTextFontSize + "px";
  }

  anime({
    targets: '#odai',
    opacity: 1,
    translateY: -40,
    duration: 1500,
    complete: () => {
      document.getElementById('close-btn').style.pointerEvents = 'auto';
    }
  });
};

const onClickCloseBtn = () => {
  document.getElementById('touch-eater').style.display = 'none';
  document.getElementById('close-btn').style.pointerEvents = 'none';
  document.getElementById('handle').style.transform = 'rotate(0deg)';
  rotate = 0;
  const odaiView = document.getElementById('odai');
  odaiView.style.opacity = 0;
  odaiView.style.transform = 'translateX(0px) translateY(0px) rotate(0deg)';
  odaiView.style.display = 'none';
  let eggs = document.getElementsByClassName('egg');
  for (egg of eggs) {
    egg.style.visibility = 'hidden';
    egg.style.transform = 'translateX(0px) translateY(0px) rotate(0deg)';
  }
};

const onSelectBoxChange = e => {
  var idx = e.selectedIndex;
  odaiType = e.options[idx].value;
};
