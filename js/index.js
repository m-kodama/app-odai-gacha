 // お題データ
 const odai = {
  question: [
    "好きな映画", "苦手な食べ物", "好きな飲み物"
  ],
  denpo: [
    "ハリー・ポッター", "プログラマー", "ドラえもん", "遊園地"
  ]
}
let odaiType = 'question'

// ハンドルを掴んでいるか否か
let isPicking = false
// ハンドルの中点座標
const handleCenter = {x:0, y:0}
// 1つ前のmousemoveイベント座標
let preDeg = 0
// ハンドルの回転角
let rotate = 0

// 左右中央揃えになるleft値を返す
const calcCenteringLeftParam = (element, targetElement) => {
  const targetLeft = Number(targetElement.style.left.replace('px', ''))
  return (targetElement.clientWidth - element.clientWidth) / 2 + targetLeft
}
// 角度を計算する
const clacDeg = (pos, center) => {
  const base = pos.x - center.x
  const height = pos.y - center.y
  const hypotenuse = Math.sqrt(base * base + height * height)
  const rad = Math.acos(base / hypotenuse)
  let deg = rad / Math.PI * 180
  if (height < 0) deg *= -1
  return deg
}

// 元の角度にアニメーション付きで戻す
const resetHandleRotate = () => {
  isPicking = false
  rotate = 0
  anime({
    targets: '#handle',
    rotate: 0,
    duration: 500,
  })
}
// ガチャを回す
const startGacha = () => {
  document.getElementById('touch-eater').style.display = 'block'
  isPicking = false
  const gacha = document.getElementById('gacha-body')
  const timeline = anime.timeline()
  timeline
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
    complete: () => {
      popEgg()
    }
  })
}
// カプセル排出
const popEgg = () => {
  const gacha = document.getElementById('gacha-body')
  let eggs = document.getElementsByClassName('egg')
  egg = eggs[getRandomInt(7) % 4]
  egg.style.visibility = 'visible'
  const timeline = anime.timeline()
  timeline
  .add({
    targets: '#stage',
    scale: 1.4,
    translateX: gacha.clientWidth * 0.4,
    duration: 450,
    easing: 'easeOutSine',
  })
  .add({
    targets: egg,
    translateX: {
      value: gacha.clientWidth * -0.8,
      duration: 1200,
      easing: 'easeOutSine',
    },
    translateY: {
      value: gacha.clientHeight * 0.44,
      duration: 1000,
      easing: 'easeOutBounce',
    },
    rotate: {
      value: -360,
      duration: 1200,
      easing: 'easeOutSine',
    }
  }, -450)
  .add({
    targets: '#stage',
    scale: 1,
    translateX: 0,
    duration: 250,
    easing: 'easeOutSine',
    complete: () => {
      showOdai()
    }
  },1000)
}
// お題表示
const showOdai = () => {
  document.getElementById('odai-text').innerText = odai[odaiType][getRandomInt(odai[odaiType].length)]
  document.getElementById('odai').style.display = 'block'
  anime({
    targets: '#odai',
    opacity: 1,
    translateY: -40,
    duration: 1500,
    complete: () => {
      document.getElementById('close-btn').style.pointerEvents = 'auto'
    }
  })
}

// マウスイベント
const onHandleMouseDown = (e) => {
  const handle = e.target || e.targetTouches[0].target
  isPicking = true
  handleCenter.x = handle.width / 2 + handle.x
  handleCenter.y = handle.height / 2 + handle.y
  preDeg = clacDeg(e, handleCenter)
}
const onStageMouseMove = (e) => {
  if (!isPicking) return
  // 角度を求める
  let deg = clacDeg(e, handleCenter)
  let diffDeg = deg - preDeg
  if (diffDeg < -180) diffDeg += 360
  else if (diffDeg > 180) diffDeg -=360
  rotate += diffDeg
  preDeg = clacDeg(e, handleCenter)
  if (rotate > 0) return
  if (rotate >= -35) {
    const handle = document.getElementById('handle')
    handle.style.transform = `rotate(${rotate}deg)`
    return
  }
  startGacha()
}
const onStageMouseUp = (e) => {
  if (!isPicking) return
  preDeg = 0
  resetHandleRotate()
}

const onClickCloseBtn = () => {
  document.getElementById('touch-eater').style.display = 'none'
  document.getElementById('close-btn').style.pointerEvents = 'none'
  document.getElementById('handle').style.transform = 'rotate(0deg)'
  rotate = 0
  const odaiView = document.getElementById('odai')
  odaiView.style.opacity = 0
  odaiView.style.transform = 'translateX(0px) translateY(0px) rotate(0deg)'
  odaiView.style.display = 'none'
  let eggs = document.getElementsByClassName('egg')
  for (egg of eggs) {
    egg.style.visibility = 'hidden'
    egg.style.transform = 'translateX(0px) translateY(0px) rotate(0deg)'
  }
}

// 初期化
const init = () => {
  // サイズ調整
  const stage = document.getElementById('stage')
  const gacha = document.getElementById('gacha-body')
  const widthRate = (stage.clientWidth * 0.85) / gacha.width
  const heightRate = (stage.clientHeight * 0.85) / gacha.height
  const imgScale = widthRate > heightRate ? heightRate : widthRate
  const imgs = document.getElementsByTagName('img')
  for(let img of imgs) {
    img.width *= imgScale
  }

  // 初期配置
  const handle = document.getElementById('handle')
  const eggNormal = document.getElementById('egg-normal')
  const eggSilver = document.getElementById('egg-sliver')
  const eggGold = document.getElementById('egg-gold')
  const eggPlatinum = document.getElementById('egg-platinum')
  // left
  gacha.style.right = gacha.clientWidth * -0.30 + 'px'
  handle.style.right = gacha.clientWidth * 0.1 + 'px'
  eggNormal.style.right = gacha.clientWidth * 0.4 + 'px'
  eggSilver.style.right = eggNormal.style.right
  eggGold.style.right = eggNormal.style.right
  eggPlatinum.style.right = eggNormal.style.right
  // top
  handle.style.top = gacha.clientHeight * 0.275 + 'px'
  eggNormal.style.top = gacha.clientHeight * 0.35 + 'px'
  eggSilver.style.top = eggNormal.style.top
  eggGold.style.top = eggNormal.style.top
  eggPlatinum.style.top = eggNormal.style.top

  // イベント設定
  handle.addEventListener('pointerdown', onHandleMouseDown, false)
  stage.addEventListener('pointerup', onStageMouseUp, false)
  stage.addEventListener('pointermove', onStageMouseMove, false)

  // お題
  const odaiView = document.getElementById('odai')
  const odaiText = document.getElementById('odai-text')
  const closeBtn = document.getElementById('close-btn')
  odaiView.style.height =  gacha.clientHeight * 0.3 + 'px'
  odaiText.style.lineHeight = odaiView.style.height
  odaiView.style.left = calcCenteringLeftParam(odaiView, stage) + 'px'
  odaiView.style.top = gacha.clientHeight * 0.25 + 'px'
  closeBtn.style.height = gacha.clientHeight * 0.05 + 'px'
  closeBtn.style.top = -1 * gacha.clientHeight * 0.05 - 8 + 'px'
  closeBtn.addEventListener('click', onClickCloseBtn, false)
  odaiView.style.display = 'none'
}
window.onload = init

const onSelectBoxChange = (e) => {
  var idx = e.selectedIndex;
  odaiType = e.options[idx].value;
}