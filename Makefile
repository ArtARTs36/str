DOCKER_RUN_ARGS=-v ${PWD}:/app artarts36/str

build:
	docker build . -t artarts36/str

deps:
	docker run ${DOCKER_RUN_ARGS} composer install

lint:
	docker run ${DOCKER_RUN_ARGS} composer lint

test:
	docker run ${DOCKER_RUN_ARGS} composer test

stat-analyse:
	docker run ${DOCKER_RUN_ARGS} composer stat-analyse

check:
	make lint
	make test
	make stat-analyse
