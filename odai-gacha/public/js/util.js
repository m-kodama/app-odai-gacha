/**
 * 0からmax-1までの範囲でランダムな数値を生成
 * @param {Number} max 生成する数値の最大値+1
 * @return {Number} 0からmax-1までの間の整数
 */
const getRandomInt = (max) => {
  return Math.floor(Math.random() * Math.floor(max));
}