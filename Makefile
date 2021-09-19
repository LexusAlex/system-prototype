# Общие вещи

# Поднять проект со всеми зависимостями
up: docker-up
# Остановить проект
down: docker-down
# Девелоперские вещи

# Собрать образы
docker-build:
	docker-compose build
# Собрать образы + проверить на наличие новых версии образов
docker-build-pull:
	docker-compose build --pull
# Запуск контейнеров в фоновом режиме
docker-up:
	docker-compose up -d
# Перезапуск контейнеров
docker-restart:
	docker-compose restart
# Остановить контейнеры поднятые командой docker-compose up
docker-down:
	docker-compose down --remove-orphans
# Остановить контейнеры а также удалить тома
docker-down-clear:
	docker-compose down -v --remove-orphans

# Линтеры и тесты

# Запуск тестов phpunit
phpunit:
	docker-compose run --rm php-cli-debian composer phpunit
# Запуск php-cs-fixer
php-cs-fixer:
	docker-compose run --rm php-cli-debian composer php-cs-fixer
# Запуск php-cs-fixer и фикс ошибок
php-cs-fixer-dry-run:
	docker-compose run --rm php-cli-debian composer php-cs-fixer-dry-run
# Запуск линтера
phplint:
	docker-compose run --rm php-cli-debian composer phplint
# psalm статический анализатор кода
psalm:
	docker-compose run --rm php-cli-debian composer psalm
# psalm статический анализатор кода
phpstan:
	docker-compose run --rm php-cli-debian composer phpstan
# psalm статический анализатор кода
infection:
	docker-compose run --rm php-cli-debian composer infection