<?php

require_once 'domain.php';
require_once 'commands.php';

$git = 'root@' . $web_server . ':/data/www/' . $domain;

$hk001 = 'root@hk001';
$gz001 = 'root@gz001';
$gz002 = 'root@gz002';
$gz003 = 'root@gz003';
$gz004 = 'root@gz004';
$gz005 = 'root@gz005';
$gz006 = 'root@gz006';
$web   = 'root@' . $web_server;

$git_pull_force = <<<EOT
chmod -R 777 storage/
chown -R www:www storage/
git config core.filemode false
git checkout .
git pull
EOT;

$clear_bootstrap_cache = <<<EOT
rm -rf bootstrap/cache/*.php
EOT;

$refresh_env_config = <<<EOT
chmod -R 777 storage/
chown -R www:www storage/
php artisan env:refresh --prod
EOT;

$refresh_staging_config = <<<EOT
chmod -R 777 storage/
chown -R www:www storage/
php artisan env:refresh --staging
EOT;

$run_composer = <<<EOT
composer install
composer dump-autoload
EOT;

$run_migrate = <<<EOT
composer dump-autoload
php artisan migrate --seed --force
EOT;

$cache_clear = <<<EOT
composer dump-autoload
php artisan cache:clear
EOT;

function copy_ui_build($web_server)
{
    return <<<EOT
rsync -e ssh -P /data/www/$domain/public/css/* root@$web_server:/data/www/$domain/public/css/
rsync -e ssh -P /data/www/$domain/public/js/* root@$web_server:/data/www/$domain/public/js/
rsync -e ssh -P /data/www/$domain/public/mix-manifest.json root@$web_server:/data/www/$domain/public/
EOT;
}

$copy_ui_build_staging = <<<EOT
rsync -e ssh -P $www/public/css/* root@$web_server:$www/public/css/
rsync -e ssh -P $www/public/js/* root@$web_server:$www/public/js/
rsync -e ssh -P $www/public/mix-manifest.json root@$web_server:$www/public/
EOT;

$copy_worker_conf = <<<EOT
cp -rf /data/www/$domain/config/worker/laravel-worker-$domain.conf /etc/supervisor/conf.d/
supervisorctl reread
supervisorctl update
supervisorctl start laravel-worker:*
EOT;

$copy_crontab = <<<EOT
cp -rf /data/www/$domain/config/cron/crontab /etc/crontab
service cron restart
EOT;
