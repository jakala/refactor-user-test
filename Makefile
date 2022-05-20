.PHONY: build deps composer composer-install composer-update finish start destroy testing command behat unit close-test

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
current-date := $(date +%Y%m%d%H%M%S)

build: deps start

deps: composer-install

finish: close-test destroy

testing: behat unit


composer-install: CMD=install --ignore-platform-reqs
composer-update: CMD=update --ignore-platform-reqs
composer composer-install composer-update:
	docker run --rm --interactive --tty -v $(current-dir):/app composer $(CMD)


start: CMD=up -d --build
destroy: CMD=down
start destroy:
	docker-compose $(CMD)


behat: CMD=vendor/bin/behat -f progress
unit: CMD=vendor/bin/phpunit --configuration phpunit.xml --coverage-html var/coverage
close-test: CMD=git archive -o technical-test-`date +%Y%m%d%H%M%S`.zip HEAD
cache-clear: CMD=rm -rf var/
command behat unit close-test cache-clear:
	docker exec -ti php-technical-test $(CMD)


