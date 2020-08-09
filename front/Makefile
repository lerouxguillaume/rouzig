build:
	docker-compose -f docker/docker-compose.yml build

docker-start: docker-stop
	docker-compose -f docker/docker-compose.yml up -d

docker-watch:
	docker-compose -f docker/docker-compose.yml up

docker-stop:
	docker-compose -f docker/docker-compose.yml stop

bash-front:
	docker exec -it vuejs_rouzig bash
