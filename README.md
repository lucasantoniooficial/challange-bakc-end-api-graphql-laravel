### Desafio para criar uma API usando GraphQL.

- Composição da API ficou em cima de 3 tabelas: Albums, Musics e Lyrics
- As tabelas uma se relaciona com a outra.

Para conseguir efetuar todos o testes precisa primeiro rodar os comandos na seguitnte ordem:
- `docker compose up -d` ou `docker-compose up -d`
- `docker ps` 
###### OBS: O Docker ps é usado para listar todos os containers e ver o id do container app e pegue os 4 primeiros digitos
- `docker exec -it {containerId} bash`
- `cp .env.example .env`
- `php artisan key:generate` 

editar arquivo .env e editar os seguintes dados:
- DB_HOST=postgres
- DB_PORT=5432
- DB_DATABASE=challange
- DB_USERNAME=root
- DB_PASSWORD=root

Após configurar o .env execute: `php artisan migrate` ainda dentro do container


No navegador url usar a rota: http://localhost/graphiql

ou utilizar um postman ou outro software usando a rota: http://localhost/graphql
