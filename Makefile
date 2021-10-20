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
# Запуск всех тестов phpunit
phpunit:
	docker-compose run --rm php-cli-debian composer phpunit
# Запуск функциональных phpunit тестов
phpunit-f:
	docker-compose run --rm php-cli-debian composer phpunit-functional
# Запуск unit phpunit тестов
phpunit-u:
	docker-compose run --rm php-cli-debian composer phpunit-unit
# Запуск unit configuration тестов
phpunit-u-c:
	docker-compose run --rm php-cli-debian composer phpunit-unit-configuration
# Запуск unit domain тестов
phpunit-u-d:
	docker-compose run --rm php-cli-debian composer phpunit-unit-domain
# Запуск unit application тестов
phpunit-u-a:
	docker-compose run --rm php-cli-debian composer phpunit-unit-application
# Запуск unit infrastructure тестов
phpunit-u-i:
	docker-compose run --rm php-cli-debian composer phpunit-unit-infrastructure
# Запуск unit phpunit тестов
phpunit-coverage:
	docker-compose run --rm php-cli-debian composer phpunit-coverage
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
# Doctrine
# Валидация схемы базы данных
doctrine-validate:
	docker-compose run --rm php-cli-debian composer run cli orm:validate-schema
# Создание миграций
doctrine-migrations-diff:
	docker-compose run --rm -u 1000:1000 php-cli-debian composer run cli migrations:diff
# Откат последней миграции
doctrine-migrations-down:
	docker-compose run --rm -u 1000:1000 php-cli-debian composer run cli migrations:migrate first
# Применение миграций
doctrine-migrations:
	docker-compose run --rm php-cli-debian composer cli migrations:migrate -- --no-interaction
# Загрузка фикстур
load-fixtures:
	docker-compose run --rm php-cli-debian composer cli fixtures:load