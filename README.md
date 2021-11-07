Отправная точка для построения приложений api и веб приложений

Структура

- bin - входная точка в консольное приложение
- configuration - конфигурационные файлы приложения
- etc - конфиги вспомогательных библиотек
- infrastructure - инфраструктурные вещи для разработки и деплоя например конфиги docker,ansible
- migrations - миграции базы данных
- public - входная точка в web приложение
- src - исходный код, при необходимости вынести в отдельные пакеты
  - Application - приложение, бизнес логика
  - Domain - сущности и доменные сервисы, чистый доменный код
  - Infrastructure - внешние специфичные сервисы
- templates - различные шаблоны
- tests - тесты
- translations - файлы с переводами
- var - временные файлы



