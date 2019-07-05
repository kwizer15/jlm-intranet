.DEFAULT_GOAL=help

-include .env
-include .env.local

PHP?=php
HOST?=localhost
PORT?=8000

CONSOLE=app/console

MYSQL?=mysql
DATABASE_HOST?=localhost
DATABASE_PORT?=3306
DATABASE_USERNAME?=hmintranet
DATABASE_PASSWORD?=hmintranet
DATABASE_NAME=hmintranet

.PHONY: help server assets cache-clear cache-delete database-init database-data install

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

server: vendor ## Lance le serveur PHP
	$(PHP) -S $(HOST):$(PORT) -t web/

install: vendor database-init database-data assets
	$(CONSOLE) fos:user:create
	$(CONSOLE) fos:user:promote

assets:
	$(CONSOLE) assets:install
	$(CONSOLE) assetic:dump

cache-clear:
	$(CONSOLE) cache:clear --no-warmup
	$(CONSOLE) cache:warmup

cache-delete:
	rm -rf app/cache/*

database-init: ## Initialise la base de donnée et l'utilisateur lié (nécessite les droit super utilisateur)
	sudo $(MYSQL) --execute="DROP DATABASE IF EXISTS $(DATABASE_NAME);"
	sudo $(MYSQL) --execute="CREATE DATABASE $(DATABASE_NAME);"
	sudo $(MYSQL) --execute="CREATE USER IF NOT EXISTS '$(DATABASE_USERNAME)'@'$(DATABASE_HOST)' IDENTIFIED BY '$(DATABASE_PASSWORD)';"
	sudo $(MYSQL) --execute="GRANT ALL ON $(DATABASE_NAME).* TO '$(DATABASE_USERNAME)'@'$(DATABASE_HOST)' IDENTIFIED BY '$(DATABASE_PASSWORD)';"

db_backup.sql: db_backup.sql.gz
	gzip -d $<

database-data: db_backup.sql
	$(MYSQL) \
	    --user=$(DATABASE_USERNAME) \
	    --password=$(DATABASE_PASSWORD) \
	    --host=$(DATABASE_HOST) \
	    --port=$(DATABASE_PORT) \
	    $(DATABASE_NAME) < $<
	 gzip -9 $<
	$(CONSOLE) doctrine:schema:update --force

composer.lock: composer.json
	composer install

vendor: composer.json
	composer install