class Handle {
  constructor(element) {
    this.element = element;
    // ハンドルを掴んでいるか否か
    this.isPicking = false;
    // ハンドルの中点座標
    this.center = { x: 0, y: 0 };
    // 1つ前のmousemoveイベント座標
    this.preDeg = 0;
    // ハンドルの回転角
    this.rotate = 0;
  }

  // 角度を計算する
  calcDeg(pos, center) {
    const base = pos.x - center.x;
    const height = pos.y - center.y;
    const hypotenuse = Math.sqrt(base * base + height * height);
    const rad = Math.acos(base / hypotenuse);
    let deg = (rad / Math.PI) * 180;
    if (height < 0) deg *= -1;
    return deg;
  }

  // 元の角度にアニメーション付きで戻す
  resetRotate() {
    if (!this.isPicking) return;
    this.reset();
    anime({
      targets: this.element,
      rotate: this.rotate,
      duration: 500
    });
  }
  //　掴み始め
  pickStart(x, y) {
    this.isPicking = true;
    this.center.x = this.element.width / 2 + this.element.x;
    this.center.y = this.element.height / 2 + this.element.y;
    this.preDeg = this.calcDeg({ x: x, y: y }, this.center);
  }
  turnOver(x, y) {
    if (!this.isPicking) return false;
    let deg = this.calcDeg({ x: x, y: y }, this.center);
    let diffDeg = deg - this.preDeg;
    if (diffDeg < -180) diffDeg += 360;
    else if (diffDeg > 180) diffDeg -= 360;
    this.rotate += diffDeg;
    this.preDeg = deg;
    if (this.rotate > 0) return false;
    if (this.rotate >= -45) {
      this.element.style.transform = `rotate(${this.rotate}deg)`;
      return false;
    }
    this.reset();
    return true;
  }
  reset() {
    this.preDeg = 0;
    this.isPicking = false;
    this.rotate = 0;
  }
}
