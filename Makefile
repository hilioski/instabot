.PHONY: dev

dev:
	environments/development/build.sh

shell:
	docker-compose exec phpfpm bash

start:
	docker-compose up -d

stop:
	docker-compose stop

down:
	docker-compose down

default: dev
