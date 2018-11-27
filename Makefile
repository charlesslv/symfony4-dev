##

EXEC_PHP        = php
CONSOLE         = $(EXEC_PHP) bin/console
COMPOSER        = composer

##Symfony
##-------------

first-install: ## First install (DB/Schema/fixtures)
	$(COMPOSER) install
	$(CONSOLE) doctrine:database:create
	$(CONSOLE) doctrine:schema:update --force
	$(CONSOLE) doctrine:fixtures:load
	$(CONSOLE) cache:clear --env=prod

fixtures: ## Replay fixtures
	$(CONSOLE) doctrine:schema:update --force
	$(CONSOLE) doctrine:fixtures:load

schema: ## Update database schema
	$(CONSOLE) doctrine:schema:update --force

cache: .env vendor
	$(CONSOLE) cache:clear

##
##For dev
##-------------

create-entity: ## To create entity
	$(CONSOLE) ma:en

create-user: ## To create User entity
	$(CONSOLE) make:user

build-login-form: ## To build a login form
	$(CONSOLE) make:auth
##

# DEFAULT
.DEFAULT_GOAL := help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

##
