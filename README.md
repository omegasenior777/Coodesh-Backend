
# Backend Challenge

>  This is a challenge by [Coodesh](https://coodesh.com/)

Este projeto é um desafio proposto pela Coodesh que se trata de uma API que utiliza a base do [Free Dictionary API](https://dictionaryapi.dev/) para buscar palavras em inglês.
A API desenvolvida possui suporte a autenticação, histórico de acesso e a favoritar/desfavoritar palavras.

## Tecnologias utilizadas

As seguintes tecnologias foram empregadas no desenvolvimento do projeto:

- API
    - PHP 8.3.14
    - Laravel 11.33.2
- Banco de dados
    - SQLite
- Cache
    - Laravel Cache
- Autenticação
    - JWT (Bearer Token)
- Documentação
    - Swagger (L5-Swagger)
- Hospedagem
    - Docker

## Como executar o projeto localmente

### Método nativo

Para executar o projeto de forma nativa, realize o clone do projeto e execute so seguintes comandos dentro da pasta:
```
composer install

php artisan serve
```

**Tenha certeza de que possua pelo menos o `PHP 8.1` instalado na máquina.** 

Após isso, basta abrir no navegador na porta:
````
localhost:8000
````

### Docker

Para executar o projeto com docker, realize o clone do projeto e execute o seguinte comando dentro da pasta raíz do projeto:
```
docker compose up
docker-compose exec app chown -R www-data:www-data /var/www/html/database
docker-compose exec app chmod -R 775 /var/www/html/database
```

**Tenha certeza de que possua o `Docker` de seu sistema operacional instalado na máquina.**

Após isso, basta abrir no navegador a `URL localhost` na porta `8080` e o retorno inicial irá aparecer.

## Swagger

Para ter acesso ao `Swagger`, utilize a rota:
```
api/documentation
```
## Importação de palavras

Para importar palavras através da api ``https://api.dictionaryapi.dev/api/v2/entries/en/<word>`` utilize o comando:
```
docker run -v ${PWD}:/var/www/html -w /var/www/html php:8.2-cli php artisan dictionary:import
```

** Base completa apenas para palavras inicadas por A ou B, devida a demora na importação.
