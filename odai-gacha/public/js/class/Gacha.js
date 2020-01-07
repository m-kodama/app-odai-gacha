/**
 * 排出物決定ロジックを担当
 */
const GACHA = {
  // お題データ
  odai: {},
  // お題を取得
  getOdai: () => {
    const config = GACHA.odai;
    const rval = getRandomInt(1001);
    let odaiCount = 0;
    for (const key of Object.keys(config)) {
      const entry = config[key];
      odaiCount += entry.texts.length;
    }
    if (odaiCount === 0) {
      alert('お題がなくなりました。ブラウザを再読み込みしてください。');
    }
    let accum = 0;
    let groupIndex = 0;
    for (const key of Object.keys(config)) {
      const entry = config[key];
      let textIndex = 0;
      for (const text of entry.texts) {
        accum += entry.prob / entry.texts.length;
        if (rval < accum)
          return new Odai(
            config[groupIndex].texts[textIndex],
            config[groupIndex].rarity
          );
        textIndex += 1;
      }
      groupIndex += 1;
    }
    return GACHA.getOdai();
  }
};

class Odai {
  constructor(text, rarity) {
    this.text = text;
    this.rarity = rarity;
  }
}
