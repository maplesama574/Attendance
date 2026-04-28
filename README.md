# Attendance

Laravel活用のフリマサイト

## ディレクトリ構成（主要なもの）

- `src/`        アプリケーションのソースコード（Controllers, Models, etc.）
- `public/`     公開用のファイル（CSS, JS, 画像など）
- `resources/`  ビューやテンプレート、フロント用リソース
- `routes/`     Web ルート定義
- `docker-compose.yml`  Docker 環境設定

## 環境構築
git clone git@github.com:maplesama574/frima.git attendance
(password:Maplesyrup)
cd attendance

docker-compose up -d --build

docker-compose exec php bash
cd /var/www
composer install
exit

cd src
cp .env.testing .env
cd ..

docker-compose exec php bash
php artisan key:generate

cd /var/www
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
念のため
php artisan config:clear
php artisan cache:clear
php artisan view:clear

php artisan migrate
php artisan db:seed
php artisan storage:link

## 使用技術（実行環境）

バックエンド
PHP
Laravel

フロントエンド
Blade
HTML/CSS

インフラ・その他
MySQL
Docker(DockerCompose)
Nginx
Stripe

## URL

トップページ： http://localhost/attendance
- 会員登録： http://localhost/register
- ログイン： http://localhost/login
- 勤怠一覧： http://localhost/attendance/list
- 勤怠詳細： http://localhost/attendance/detail/{id}
- 申請一覧： http://localhost/stamp_correction_request/list
- ログイン画面（管理者）： http://localhost/admin/login
- 勤怠一覧（管理者）： http://localhost/admin/attendance/list
- 勤怠詳細（管理者）： http://localhost/admin/attendance/{id}
- スタッフ一覧（管理者）： http://localhost/admin/staff/list
- スタッフ別勤怠一覧（管理者）： http://localhost/admin/attendance/staff/{id}
- 申請一覧（管理者）： http://localhost/stamp_correction_request/list
- 修正承認申請（管理者）： http://localhost/stamp_correction_request/approve/{attendance_correct_request_id}