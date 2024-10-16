#!/bin/bash
echo "Get latest information from git"
git fetch --all
TAG=$(git describe --abbrev=0 --tags $(git rev-list --tags --max-count=1))

echo "Checkout to latest tag"
git checkout $TAG
git pull origin $TAG

echo "Install composer dependencies"
export COMPOSER_ALLOW_SUPERUSER=1; composer install

echo "clear cache"
php bin/console cache:clear

if [ -f .env.local ]; then
    echo "run migrations"
    php bin/console doctrine:migrations:migrate --no-interaction --query-time --all-or-nothing
else
    echo "skipping migrations as there is no .env.local file yet."
    echo "Create one this by running setup"
    echo ""
fi

echo "run upgrade script"
bash upgradefiles/upgrade.sh

echo "install assets"
php bin/console assets:install public

echo "warmup cache"
php bin/console cache:warmup
