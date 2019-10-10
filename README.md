# app-odai-gacha

--- 以下メモ ---

## 必要な情報

- ガチャの種類
- ガチャの種類の名前（デンポー、シンクロナイズド・シンキング）
- お題
- レアリティ
- 確率

- ユーザー ID
- パスワード

## 実際のテーブル構成

### users（Laravel デフォルトのやつ使う）

### gacha_master

- ガチャ ID gacha_id integer
- ガチャ名 gacha_name varchar(30)
- 所有者（ユーザ ID）user_id integer

### topics

- ガチャ ID gacha_id integer
- お題 ID topic_id integer
- お題 topic varchar(255)
- レアリティ rarity int

### rarity

- レアリティ rarity int
- 確率 probability int

### migrate ファイル作り方

- php artisan make:migration create_gacha_master_table --create=gacha_master
- php artisan make:migration create_topics_table --create=topics
- php artisan make:migration create_rarity_table --create=rarity

### なんかコマンド打ったログ

docker-compose ps
docker-compose exec mysql bash
mysql -u root -p

docker volume rm mysql_mysql-data
docker volume ls
docker-compose stop
docker-compose down

mysql -u root -p
use odai_gacha
drop table gacha_master
General error: 1215 Cannot add foreign key constraint 　 int

- 参照元の PRIMARY KEY と、外部キーのデータ型が違う
  Syntax error or access violation: 1072 Key column 'gacha_id' doesn't exist in table
- まずテーブルを作る

show tables;
select \* from テーブル名

Syntax error or access violation: 1075 Incorrect table definition; there can be only one auto column and it must be defined as a key

- auto increment ２個だめ
