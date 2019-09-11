class Handle extends ImageElement {
    constructor(element) {
        this.element = element
        // ハンドルを掴んでいるか否か
        this.isPicking = false
        // ハンドルの中点座標
        this.center = {x:0, y:0}
        // 1つ前のmousemoveイベント座標
        this.preDeg = 0
        // ハンドルの回転角
        this.rotate = 0
    }

    // 角度を計算する
    calcDeg(pos, center) {
        const base = pos.x - center.x
        const height = pos.y - center.y
        const hypotenuse = Math.sqrt(base * base + height * height)
        const rad = Math.acos(base / hypotenuse)
        let deg = rad / Math.PI * 180
        if (height < 0) deg *= -1
        return deg
    }

    // 元の角度にアニメーション付きで戻す
    resetHandleRotate() {
        this.isPicking = false
        this.rotate = 0
        anime({
            targets: this.element,
            rotate: 0,
            duration: 500,
        })
    }
}