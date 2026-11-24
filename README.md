# bookshelf

## 概要

## 機能一覧

- **会員登録・ログイン**
- **書籍一覧取得**

## 環境構築

1. プロジェクトのクローン

```
git clone https://github.com/oohashitakayuki/bookshelf-app.git
```

## 使用技術(実行環境)

## APIエンドポイント一覧

| HTTPメソッド | URI | 説明 |
| :--- | :--- |:--- |
| GET | /api/v1/books | 書籍一覧を取得する |
| GET | /api/v1/books/{book} | 指定した書籍の詳細を取得する |
| POST | /api/v1/books | 書籍を新規登録する |
| PUT | /api/v1/books/{book} | 指定した書籍を更新する |
| DELETE | /api/v1/books/{book} | 指定した書籍を削除する |

## ER図

## 作成者

## URL

- 開発環境：http://localhost
- phpMyAdmin：http://localhost:8080
