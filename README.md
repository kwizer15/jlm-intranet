JLM Intranet
============

[![Build Status](https://travis-ci.org/kwizer15/hm-intranet.svg?branch=master)](https://travis-ci.org/kwizer15/hm-intranet)

Pré-requis
----------

* Apache
* PHP
* MySQL
* Git
* Composer

Installation
------------

```
cd /home/me/git/
git clone https://github.com/jlm-entreprise/jlm-intranet.git
cd jlm-intranet
cp apache2.conf apache2.conf.dist
nano apache2.conf
# Editer les répertoires pour votre config
sudo ln -s /home/me/git/jlm-intranet/apache2.conf /etc/apache2/sites-available/jlm-intranet.conf
composer install
php app/console database:create
gzip -d db_backup.sql.gz
mysql -u user -p jlm < db_backup.sql
php app/console asserts:install
php app/console assetic:dump
php app.console fos:user:create
# Nom d'utlisateur + mot de passe
php app/console fos:user:promote
# Nom d'utilisateur
# Role : ROLE_ADMIN
sudo nano /etc/hosts
# Ajouter jlm-intranet.dev sur 127.0.0.1
```

Ouvrir le navigateur sur jlm-intranet.dev

