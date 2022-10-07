up:
	docker-compose --env-file=.env.dev up -d --force-recreate --build --remove-orphans

down:
	docker-compose --env-file=.env.dev down --volumes --remove-orphans
