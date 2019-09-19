/**
 * 排出物決定ロジックを担当
 */
const GACHA = {
  // お題データ
  odai: {
    question: [
      {
        rarity: 3,
        prob: 20, // 2%
        texts: ['好きな仮面ライダー', '好きなウルトラマン']
      },
      {
        rarity: 2,
        prob: 130, // 13%
        texts: ['好きなアルファベット', '好きなファミレス', 'チャームポイント']
      },
      {
        rarity: 1,
        prob: 350, // 35%
        texts: [
          '好きな映画',
          '好きな芸能人',
          '好きな場所',
          '好きな色',
          'お風呂ではどこから洗う',
          'ストレス発散法',
          'ドラえもんから秘密道具を1つもらえるとしたら何をもらう？',
          '無人島に1つだけ持っていくとしたら？',
          '好きなアニメ',
          '今、一番行きたいところ'
        ]
      },
      {
        rarity: 0,
        prob: 500, // 50%
        texts: [
          '苦手な食べ物',
          '好きな飲み物',
          '好きなお笑い芸人',
          '好きな動物',
          '好きな店',
          'これだけはゆずれないこだわり',
          '最近イラついたこと',
          '最近楽しかったこと',
          '最近買ったもの',
          '最近欲しいもの',
          '今、外国に行くならどこに行く？',
          'お酒で酔うとどうなる？',
          '休日は何してる？',
          'もしも100万円あったら？',
          '好きなスポーツ'
        ]
      }
    ],
    denpo: [
      {
        rarity: 3,
        prob: 20, // 2%
        texts: ['織田信長', '世界平和', '聖徳太子']
      },
      {
        rarity: 2,
        prob: 130, // 13%
        texts: ['モンスト', 'パズドラ', 'iPhone']
      },
      {
        rarity: 1,
        prob: 350, // 35%
        texts: [
          'ハリー・ポッター',
          'プログラマー',
          'ONE PIECE（漫画）',
          '宇宙飛行士',
          'パイロット',
          '警察官',
          'キットカット',
          'マクドナルド',
          'ケンタッキー',
          'サーティーワンアイスクリーム'
        ]
      },
      {
        rarity: 0,
        prob: 500, // 50%
        texts: [
          'ドラえもん',
          '遊園地',
          'サッカー',
          '組体操',
          'スキー',
          '野球',
          'となりのトトロ',
          '天空の城ラピュタ',
          'ハロウィン',
          'クリスマス',
          'ひな祭り',
          'アンパンマン',
          '木村拓哉',
          'お正月',
          'きのこの山',
          'たけのこの里',
          '日本',
          '台湾',
          'アメリカ'
        ]
      }
    ]
  },
  // お題の種類
  odaiType: 'question',
  setOdaiType: odaiType => {
    GACHA.odaiType = odaiType;
  },
  // お題を取得
  getOdai: () => {
    const config = GACHA.odai[GACHA.odaiType];
    const rval = getRandomInt(1001);
    let odaiCount = 0;
    for (const entry of config) {
      odaiCount += entry.texts.length;
    }
    if (odaiCount === 0)
      alert('お題がなくなりました。ブラウザを再読み込みしてください。');

    let accum = 0;
    let groupIndex = 0;
    for (const entry of config) {
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
    return getOdaiIndex();
  }
};

class Odai {
  constructor(text, rarity) {
    this.text = text;
    this.rarity = rarity;
  }
}
