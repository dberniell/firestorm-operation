# Firestorm Operation

A project with DDD, CQRS, Event Sourcing applications using Symfony as framework and running with php7

## Documentation

[Buses](https://github.com/dberniell/firestorm-opration/tree/master/doc/GetStarted/Buses.md)

[Creating an Application Use Case](https://github.com/dberniell/firestorm-opration/tree/master/doc/GetStarted/UseCases.md)

[Adding Projections](https://github.com/dberniell/firestorm-opration/tree/master/doc/GetStarted/Projections.md)

[Xdebug configuration](https://github.com/dberniell/firestorm-opration/blob/master/doc/GetStarted/Xdebug.md)

## Architecture

Based in the next Architecture:

![Architecture](https://i.imgur.com/SzHgMft.png)

## Implementations

- [x] Environment in Docker
- [x] Command Bus, Query Bus, Event Bus
- [x] Event Store
- [x] Read Model
- [x] Rest API
- [x] Event Store Rest API 
- [x] Swagger API Doc

## Use Cases

#### Area
- [x] Calculate Area
- [x] Get Area by id

![API Doc](https://github.com/dberniell/firestorm-operation/blob/master/doc/Swagger.png)

## Stack

- PHP 7.3
- Mysql 8.0

## Project Setup
Build Environment

`make build`

Up environment:

`make start`

Execute tests:

`make phpunit`

Static code analysis:

`make style`

Code style fixer:

`make cs`

Code style checker:

`make cs-check`

Enter in php container:

`make s=php sh`

Disable\Enable Xdebug:

`make xoff`

`make xon`

## PHPStorm integration

PHPSTORM has native integration with Docker compose. That's nice but will stop your php container after run the test scenario. That's not nice when using fpm. A solution could be use another container just for that purpose. But I don't want. For that reason I use ssh connection.

IMPORTANT

> ssh in the container it's ONLY for that reason, if you've ssh installed in your production container, you're doing it wrong... 

Use ssh remote connection.
---

Host: 
- Docker: `localhost`

Port: 
 - `2323`

Filesystem mapping:
 - `{PROJECT_PATH}` -> `/app`
