# 家計簿アプリ

ユーザーのお金の使い過ぎを防止するために目標設定と使用料金の差額の可視化およびどのように使いすぎを防止するのかを考えたアプリ

## 技術構成

| 区分 | 使用技術 |
| --- | --- |
| サーバーサイド | PHP 8.1 / FuelPHP 1.9 |
| データベース | MySQL 8.0（`DB` クラス経由でアクセス） |
| フロントエンド | knockout.js / fetch による非同期通信 |
| 状態管理 | Session（ログイン状態）/ Cookie（表示テーマ） |

## 動作環境

- PHP 8.1 以上（`mbstring` `pdo_mysql` `curl` `xml` `zip`）
- MySQL 8.0
- Composer 2.x

## セットアップ

### 1. 依存パッケージの取得

```bash
composer install
```

`fuel/core` や `fuel/packages/*` はリポジトリに含めていないため、clone 後は必ず実行する。

### 2. データベースの作成

```sql
CREATE DATABASE kakeibo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'kakeibo'@'localhost' IDENTIFIED BY '任意のパスワード';
GRANT ALL PRIVILEGES ON kakeibo.* TO 'kakeibo'@'localhost';
FLUSH PRIVILEGES;
```

### 3. 接続設定

```bash
cp fuel/app/config/development/db.php.example fuel/app/config/development/db.php
```

コピーした `db.php` の `username` と `password` を自分の環境の値に書き換える。このファイルは接続情報を含むため `.gitignore` の対象で、リポジトリには入らない。

### 4. 書き込み権限の付与

```bash
chmod -R 777 fuel/app/logs fuel/app/cache fuel/app/tmp
```

### 5. 起動

```bash
php -S localhost:8080 -t public
```

`http://localhost:8080` を開く。公開するのは `public/` のみで、`fuel/` 以下は外部に露出させない。

WSL2 では MySQL が自動起動しないため、起動前に以下が必要。

```bash
sudo service mysql start
```

## ディレクトリ構成

```
fuel/app/          アプリ本体（classes / config / views / migrations）
fuel/core/         フレームワーク本体（composer 管理・非コミット）
fuel/packages/     追加パッケージ（composer 管理・非コミット）
public/            公開ディレクトリ。ここだけが Web から見える
oil                CLI ツール（マイグレーション等）
```

## 設定ファイル

| ファイル | 内容 | コミット |
| --- | --- | --- |
| `fuel/app/config/config.php` | ロケール（ja_JP）、タイムゾーン（Asia/Tokyo） | する |
| `fuel/app/config/development/db.php` | DB 接続情報 | **しない** |
| `fuel/app/config/development/db.php.example` | 接続情報のひな形 | する |
| `fuel/app/config/crypt.php` | 初回起動時に自動生成される暗号化キー | **しない** |

## ブランチ運用

`feature/*` → `develop` → `main` の順に PR ベースでマージする。機能単位でブランチを切り、単体で動作する状態にしてから PR を出す。
