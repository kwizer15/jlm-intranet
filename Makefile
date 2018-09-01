.PHONY: help phpmetrics cs csfix test

.DEFAULT_GOAL = help

BRANCH=$(shell git branch | cut -d ' ' -f 2)

PHP?=php
PHPUNIT?=bin/phpunit
PHPCS?=bin/phpcs
PHPCSFIX?=bin/phpcbf
PHPMETRICS?=~/.config/composer/vendor/bin/phpmetrics

-include .env

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-17s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

phpmetrics: metrics/$(BRANCH)

metrics/$(BRANCH): app src web vendor
	$(PHPMETRICS) --report-html=metrics/$(BRANCH) ./

vendor: composer.json
	composer install

$(PHPUNIT): vendor

$(PHPCS): vendor

test: $(PHPUNIT) phpunit.xml ## Lance les tests
	$(PHP) $(PHPUNIT)

cs: $(PHPCS) phpcs.xml ## Lance le codesniffer
	$(PHP) $(PHPCS)

csfix: $(PHPCSFIX) phpcs.xml ## Lance les fixs du codesniffer
	$(PHP) $(PHPCSFIX)

phpunit.xml: phpunit.xml.dist
	cp phpunit.xml.dist phpunit.xml

phpcs.xml: phpcs.xml.dist
	cp phpcs.xml.dist phpcs.xml
