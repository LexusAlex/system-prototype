######################################
# Общие вещи
# Поднять проект со всеми зависимостями
up: docker-up
# Остановить проект
down: docker-down
######################################
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
# Удалить вообще все в системе
docker-remove-all-system:
	docker system prune -a
# Проверить обновы пакетов
composer-outdated:
	docker-compose run --rm php-cli-debian composer outdated --direct
# Список установленных composer пакетов
composer-list:
	docker-compose run --rm php-cli-debian composer outdated -a
# обновить карту классов
composer-autoload:
	docker-compose run --rm php-cli-debian composer dump-autoload
# Обновить карту классов composer для прода без dev зависимостей
composer-autoload-no-dev:
	docker-compose run --rm php-cli-debian composer dump-autoload --no-dev
######################################
# Линтеры и тесты

# Общая команда для тестирования всего проекта
test: lint static-analyze phpunit

lint: phplint php-cs-fixer-dry-run
static-analyze: phpstan psalm
# Запуск тестов phpunit
phpunit:
	docker-compose run --rm php-cli-debian composer phpunit
# Запуск php-cs-fixer с исрпавлением
php-cs-fixer:
	docker-compose run --rm php-cli-debian composer php-cs-fixer
# Запуск php-cs-fixer c проверкой
php-cs-fixer-dry-run:
	docker-compose run --rm php-cli-debian composer php-cs-fixer-dry-run
# Запуск линтера
phplint:
	docker-compose run --rm php-cli-debian composer phplint
# psalm статический анализатор кода
psalm:
	docker-compose run --rm php-cli-debian composer psalm
# psalm статический анализатор кода
psalm-dry-run:
	docker-compose run --rm php-cli-debian composer psalm-dry-run
# phpstan
phpstan:
	docker-compose run --rm php-cli-debian composer phpstan
######################################