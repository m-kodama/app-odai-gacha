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
      return false;
    }
    let accum = 0;
    let groupIndex = 0;
    for (const key of Object.keys(config)) {
      const entry = config[key];
      let textIndex = 0;
      for (const text of entry.texts) {
        accum += entry.prob / entry.texts.length;
        if (rval < accum) {
          const odai = new Odai(
            config[groupIndex].texts[textIndex],
            config[groupIndex].rarity,
            config[groupIndex].rarityImage
          );
          config[groupIndex].texts.splice(textIndex, 1);
          return odai;
        }
        textIndex += 1;
      }
      groupIndex += 1;
    }
    return GACHA.getOdai();
  }
};

class Odai {
  constructor(text, rarity, rarityImage) {
    this.text = text;
    this.rarity = rarity;
    this.rarityImage = rarityImage;
  }
}
