# お題ガチャ｜Odai Gacha

![localhost_3000_gacha_](https://user-images.githubusercontent.com/28724739/74842408-b61b3b00-536d-11ea-869c-abfc83c06bb3.png)

## 🦖 About
お題ガチャは「**お題**」と「**排出率**」を自由に設定して、**自分だけのガチャを作れる**サービスです。

**アイスブレイク**や**くじ引き**、**ソーシャルゲームのガチャシミュレータ**など、様々な場面で利用できるかもしれません。

<br>

## 🦖 Usage

事前に `dcoker` と `docker-compose` をインストールしてください。

- `git clone https://github.com/m-kodama/app-odai-gacha.git`
- `cp .env.example .env`
- `docker-compose up -d`
- `docker-compose exec app bash`
- `cd odai-gacha`
- `composer install`
- `php artisan migrate`
- `php artisan db:seed`
- `npm install`
- `npm run watch`

<br>

## 🦖 Features

### 1.ガチャ作成・編集
#### 1.1 ガチャから出るお題を自由に設定できる
#### 1.2 お題の排出率を自由に設定できる

### 2.ガチャ一覧
#### 2.1 ガチャの使用や編集にパスワードを設定できる

### 3.ガチャ起動
#### 3.1 
