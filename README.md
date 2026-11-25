# BookShelf

## 概要

書籍の登録・管理をはじめ、レビューの投稿やお気に入り登録などのサービスをご利用いただけます。

![ホーム画面](https://github.com/user-attachments/assets/3257eadb-3181-4a7f-8b99-37980e51eddc)

## 機能一覧

- **会員登録・ログイン**
- **書籍一覧取得**
- **書籍新規登録**
- **書籍の編集・削除**
- **ジャンル一覧取得**
- **ジャンル新規登録**
- **ジャンルの編集・削除**
- **レビューの投稿**
- **レビューの編集・削除**
- **お気に入り機能**
- **いいね機能**
- **ランキング機能**

## 環境構築

1. プロジェクトのクローン

```
git clone https://github.com/oohashitakayuki/bookshelf-app.git
```

2. プロジェクトディレクトリに移動

```
cd bookshelf-app
```

3. Composer パッケージのインストール

```
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install
```

4. 「.env.example」ファイルをコピーして「.env」ファイルを作成

```
cp .env.example .env
```

5. 「.env」ファイルにおいて環境変数を設定

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

6. Sailの起動とエイリアスの設定

Sailを起動

```
./vendor/bin/sail up -d --build
```

エイリアスを設定

```
echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.zshrc
```

シェルを再起動、または新しいターミナルを開いて設定を反映

```
exec $SHELL
```

7. npmパッケージのインストール

```
sail npm install
```

8. アプリケーションキーの作成

```
sail artisan key:generate
```

9. マイグレーションおよびシーディングの実行

```
sail artisan migrate --seed
```

10. 開発サーバーの起動

```
sail npm run dev
```

## 使用技術(実行環境)

- PHP 8.5.10
- Laravel 10.50.3
- Laravel Sail 1.67
- Vite 5.4.21
- MySQL 8.4.11
- Docker 29.9.3

## APIエンドポイント一覧

| HTTPメソッド | URI | 説明 |
| :--- | :--- |:--- |
| GET | /api/v1/books | 書籍一覧を取得する |
| GET | /api/v1/books/{book} | 指定した書籍の詳細を取得する |
| POST | /api/v1/books | 書籍を新規登録する |
| PUT | /api/v1/books/{book} | 指定した書籍を更新する |
| DELETE | /api/v1/books/{book} | 指定した書籍を削除する |

## ER図

![ER図](https://github.com/user-attachments/assets/55e3d723-6ed4-4d69-84b5-5f2d00aff413)

## 作成者

大橋孝之

## URL

- 開発環境：http://localhost
- phpMyAdmin：http://localhost:8080
