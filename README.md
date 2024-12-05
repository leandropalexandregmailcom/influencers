Este projeto é uma plataforma de gerenciamento de influenciadores, permitindo o cadastro de influenciadores, campanhas e categorias, além de vincular influenciadores a campanhas específicas.

Abaixo estão os principais recursos da API:

Cadastro de Influenciadores: Registre influenciadores com dados como nome, Instagram e categoria.

Cadastro de Campanhas: Crie campanhas com informações sobre nome, orçamento e datas.

Gerenciamento de Categorias: Categorize influenciadores conforme áreas como Tecnologia, Beleza, etc.

Relacionamento entre Influenciadores e Campanhas: Vincule influenciadores a campanhas específicas.

Esses endpoints podem ser acessados e testados diretamente através do Swagger.

Para rodar o projeto, você pode usar o comando:
docker-compose up -d
php artisan key:generate

Depois de subir os containers, gere a documentação do Swagger com o comando:"

php artisan l5-swagger:generate


O projeto utiliza as seguintes versões e tecnologias:

PHP 8.1
Nginx
MySQL 5.7

O projeto utiliza autenticação JWT (JSON Web Token) para garantir que apenas usuários autenticados possam acessar os endpoints da API. Após o login, um token JWT é gerado e deve ser incluído nas requisições subsequentes para autenticação.# influencers
