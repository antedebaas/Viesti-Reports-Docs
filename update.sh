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

echo "install assets"
php bin/console assets:install public

echo "warmup cache"
php bin/console cache:warmup
