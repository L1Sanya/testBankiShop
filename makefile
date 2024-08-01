.PHONY: start
start:
	sudo docker-compose build \
	&& sudo docker-compose up -d

.PHONY: restart
restart:
	sudo docker-compose down && sudo docker-compose build && sudo docker-compose up -d

.PHONY: down
down:
	sudo docker-compose down

.PHONY: bash
bash:
	sudo docker-compose exec php bash

.PHONY: ps
ps:
	sudo docker-compose ps

.PHONY: db
db:
	sudo docker-compose exec db bash

.PHONY: migrate
migrate:
	sudo docker-compose exec php php artisan migrate

.PHONY: seed
seed:
	sudo docker-compose exec php php artisan db:seed
