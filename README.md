
# Projeto Teste-laravel
### Este é um guia passo a passo para configurar e executar o projeto Teste-laravel usando Docker.

# Pré-requisitos
- Docker Desktop instalado e configurado na sua máquina.
- Git instalado na sua máquina.
  
# Instalação
Clone o repositório do projeto Teste-laravel do GitHub:

```
git clone https://github.com/Coimbra777/teste-laravel.git
```
Navegue até o diretório do projeto clonado:
```
cd app-laravel
```

Crie o arquivo .env :
```
cp .env.example .env
```

Execute o seguinte comando para iniciar os contêineres Docker e construir as imagens:
```
docker compose up -d --build
```
Instale as dependências do Composer executando o seguinte comando:
```
docker compose exec app composer install
```

Gere a chave de criptografia do Laravel executando o seguinte comando:
```
docker compose exec app php artisan key:generate
```
Configure o banco de dados no arquivo .env com as seguintes credenciais:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```
Execute as migrações do banco de dados com o seguinte comando:
```
docker compose exec app php artisan migrate
```
Execute o servidor:
```
docker compose exec app php artisan serve
```

Abra outro terminal e execute:
```
npm run dev
```
para executar o frontend da aplicação.

Acesso Local
Depois de seguir as etapas acima, você pode acessar o projetolocalmente no seguinte endereço:

http://localhost:8989
