# Teste Backend PicPay

O projeto tem como objetivo cumprir o desafio proposto pela equipe técnica da **PicPay**.

---

## Configurações iniciais

Para dar continuidade na instalação do projeto, é necessário as seguinte ferramentas instaladas :

* Docker ***(recomendado versão >= 19)***
* Docker Compose
  

*No terminal acesse a pasta do projeto e execute os seguintes comandos :*

### Inicializando os containers
```bash
docker-compose up -d
```

### Copiando arquivo de configuração 
```bash
cp .env.example .env
```

### Instalando as dependências do projeto com composer
```bash
docker exec -it challenge-php composer install
```

### Executando as migrations
```bash
docker exec -it challenge-php php artisan migrate
```

Portas utilizadas:
- [:7700] : nginx (PHP 7.4)
- [:3306] : Mysql (5.7)

---

## Importação de dados

### Usuários 

Salve o arquivo [users.csv](https://s3.amazonaws.com/careers-picpay/users.csv.gz) (**necessário extrair**) na raiz do projeto e execute o seguinte comando no terminal :
```bash
docker exec -it challenge-php php artisan upload:users-csv users.csv
```

### Relevância

Salve os arquivos [lista_relevancia_1.txt](https://s3.amazonaws.com/careers-picpay/lista_relevancia_1.txt) e [lista_relevancia_2.txt](https://s3.amazonaws.com/careers-picpay/lista_relevancia_2.txt) na raiz do projeto e execute os seguintes comandos no terminal :

```bash
docker exec -it challenge-php php artisan upload:users-relevance-csv lista_relevancia_2.txt 1
```

```bash
docker exec -it challenge-php php artisan upload:users-relevance-csv lista_relevancia_1.txt 2
```

* *Obs: O segundo parâmetro do comando **upload:users-relevance-csv** indica o nível de prioridade, quanto maior ele for mais prioritário na busca ele vai ser.*

---
## Testes

A aplicação contempla um conjunto de testes para validar a integridade e disponibilidade dos recursos oferecidos, para executá-los basta realizar o seguinte comando :
```bash
docker exec -it challenge-php ./vendor/bin/phpunit
```
* *Obs: Os testes são executados em um banco de dados separado para não comprometer a aplicação e a integridade dos dados.*
---

## API

A API estará disponibilizada em http://localhost:7700/users

Parâmetros:
* [GET] **search**: Palavra chave para realizar a busca. 
* [GET] **page**: Paginação de resultados.

**(exemplo)** http://localhost:7700/users?search=lucas&page=2

---

