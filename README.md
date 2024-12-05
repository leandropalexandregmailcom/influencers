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
![{1929B127-0780-4B97-9D19-4F53B4E1FE39}](https://github.com/user-attachments/assets/5e8000f8-493c-478b-8da1-063f1ea2c9f7)
![{7316D6A5-CC68-4BF1-AE8F-27DB92E5D3AE}](https://github.com/user-attachments/assets/77e39475-0b28-4d98-b610-8a83b62103dc)


