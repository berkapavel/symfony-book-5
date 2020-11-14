include .env

#=== setup ===#
SHELL = bash
EXEC_PHP = php
SYMFONY = $(EXEC_PHP) bin/console
SYMFONY_BIN = symfony
COMPOSER = $(EXEC_PHP) composer.phar
DOCKER = docker
DOCKER_COMP = docker-compose

up:
	@echo "${GREEN}>>>> Start development stack${RESET}"
	@$(SYMFONY_BIN) serve --daemon --port=8000
	@$(DOCKER_COMP) up -d
	#=== docker-compose take some time, so it's better to wait 2 sec before migrations are start up
	@sleep 2
	@echo "yes"|$(SYMFONY_BIN) console doctrine:migrations:migrate

down:
	@echo "${GREEN}>>>> Stop development stack${RESET}"
	@$(SYMFONY_BIN) server:stop

status:
	@docker-compose ps