# お題ガチャ｜Odai Gacha

![localhost_3000_gacha_](https://user-images.githubusercontent.com/28724739/74842408-b61b3b00-536d-11ea-869c-abfc83c06bb3.png)

## 🦖 About
お題ガチャは「**お題**」と「**排出率**」を自由に設定して、**自分だけのガチャを作れる**サービスです。

**アイスブレイク**や**くじ引き**、**ソーシャルゲームのガチャシミュレータ**など、様々な場面で利用できるかもしれません。

<br>

## 🦖 Usage

事前にインストールが必要なもの
- dcoker
- docker-compose
- node v12.4.0
- npm 6.13.6

[任意のディレクトリ]
- `git clone https://github.com/m-kodama/app-odai-gacha.git`
- `cd app-odai-gacha`
- `cp odai-gacha/.env.example odai-gacha/.env`
- `docker-compose up -d`

[appコンテナ]
- `docker-compose exec app bash`
- `cd odai-gacha`
- `composer install`
  - エラがー出る場合：ttps://qiita.com/ma_me/items/7d1823c27d6ef45cdf9f
- `php artisan migrate` 
  - エラーが出る場合： `exit` で一旦コンテナを抜け、 `docker-compose start` でmysqlコンテナを再起動してください
- `php artisan db:seed`
- `exit`

[ローカル]
- `cd odai-gacha`
- `npm install`
- `npm run watch` or `npm run watch-with-fmt`

[ブラウザ]
- http://localhost:3000 にアクセスでガチャ一覧画面表示
<br>

## 🦖 Features

### 1.ガチャ作成・編集
#### 1.1 ガチャから出るお題を自由に設定できる
#### 1.2 お題の排出率を自由に設定できる

### 2.ガチャ一覧
#### 2.1 ガチャの使用や編集にパスワードを設定できる

### 3.ガチャ起動
#### 3.1 
