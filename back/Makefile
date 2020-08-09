build:
	docker-compose -f docker/docker-compose.yml build

docker-start: docker-stop
	docker-compose -f docker/docker-compose.yml up -d

docker-watch:
	docker-compose -f docker/docker-compose.yml up

docker-stop:
	docker-compose -f docker/docker-compose.yml stop

bash-symfony:
	docker exec -it -u dev php_rouzig bash

bash-apache:
	docker exec -it apache-rouzig bash

bash-root:
	docker exec -it php_rouzig bash

bash-mysql:
	docker exec -it mysql_rouzig bash