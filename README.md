# API RESTful de Geração e Recuperação de Carnês

Esta API fornece funcionalidades para criar e recuperar carnês de pagamento. Os carnês podem ser divididos em parcelas com base nos parâmetros fornecidos, e a API pode recuperar parcelas de um carnê existente.
O Sistema consegue ser testado via Postman, mas foi desenvolvido um front em Vue JS caso queira alguma interação, logo abaixo mostrarei como instalar o frontEnd se necessario.

## Requisitos
PHP 8.0 ou superior
Composer
MySQL
Node.js e npm (opcional, para gerenciamento de dependências)

## Instalação do Back

1. Clone o repositório:
```bash   
    git clone https://github.com/lucaasbritto/tenex_back.git
```

2. Acesse o diretório do projeto:
    cd seu-repositorio

3. Configure o arquivo .env:
    Renomeie o arquivo .env.example para .env e configure as variáveis de ambiente conforme necessário,

4. Gere a chave de aplicativo do Laravel:
    php artisan key:generate

5. Execute as migrações:
    php artisan migrate

6. Inicie o servidor local:
    php artisan serve

## Endpoints

### 1. Criação de um Carnê

**Método:** `POST`  
**Endpoint:** `/api/gerar-carne`  
**Descrição:** Cria um novo carnê com base nos parâmetros fornecidos e calcula as parcelas.

**Parâmetros de Requisição (Body):**

```json
    {
    "valor_total": 100.00,
    "qtd_parcelas": 12,
    "data_primeiro_vencimento": "2024-08-01",
    "periodicidade": "mensal",
    "valor_entrada": 0.00
    }
```

**Resposta (200 OK)**
```json
    {
    "total": 100.00,
    "valor_entrada": 0.00,
    "parcelas": [
        {"numero": 1, "valor": 8.33, "data_vencimento": "2024-08-01"},
        {"numero": 2, "valor": 8.33, "data_vencimento": "2024-09-01"},
        ...
        {"numero": 12, "valor": 8.33, "data_vencimento": "2025-07-01"}
    ]
    }
```

**Resposta (400 Bad Request)**
```json
{
  "error": "Mensagem de erro específica"
}
```



### 2. Recuperação de Parcelas

**Método:** `GET`  
**Endpoint:** `/api/recuperar-parcelas/{id}`  
**Descrição:** Recupera as parcelas de um carnê existente com base no identificador fornecido.

**Parâmetros de Requisição:**
    id (int): O identificador do carnê.

**Resposta (200 OK)**
```json
    {
        "parcelas": [
            {"numero": 1, "valor": 8.33, "data_vencimento": "2024-08-01", "entrada": false},
            {"numero": 2, "valor": 8.33, "data_vencimento": "2024-09-01"},
            ...
            {"numero": 12, "valor": 8.33, "data_vencimento": "2025-07-01"}
        ]
    }
```

**Resposta (400 Bad Request)**
```json
{
  "error": "Mensagem de erro específica"
}
```



## Exemplo de Uso

### 1. Criação de Carnê

**Request 1**
```json
    POST /api/gerar-carne
    Content-Type: application/json

    {
    "valor_total": 100.00,
    "qtd_parcelas": 12,
    "data_primeiro_vencimento": "2024-08-01",
    "periodicidade": "mensal",
    "valor_entrada": 0.00
    }
```

**Response 1**
```json
        {
    "total": 100.00,
    "valor_entrada": 0.00,
    "parcelas": [
        {"numero": 1, "valor": 8.33, "data_vencimento": "2024-08-01"},
        {"numero": 2, "valor": 8.33, "data_vencimento": "2024-09-01"},
        ...
        {"numero": 12, "valor": 8.33, "data_vencimento": "2025-07-01"}
    ]
    }
```


**Request 2**
```json
    POST /api/gerar-carne
    Content-Type: application/json
    {
    "valor_total": 0.30,
    "qtd_parcelas": 2,
    "data_primeiro_vencimento": "2024-08-01",
    "periodicidade": "semanal",
    "valor_entrada": 0.10
    }
```

**Response 2**
```json
        {
    "total": 0.30,
    "valor_entrada": 0.10,
    "parcelas": [
        {"numero": 1, "valor": 0.10, "data_vencimento": "2024-08-01"},
        {"numero": 2, "valor": 0.10, "data_vencimento": "2024-08-08"},
        {"numero": 3, "valor": 0.10, "data_vencimento": "2024-08-15"},        
    ]
    }
```






### 2. Recuperação de Parcelas

**Request 1**
    GET /api/recuperar-parcelas/1

**Response 1**
```json
        {
    "total": 100.00,
    "valor_entrada": 0.00,
    "parcelas": [
        {"numero": 1, "valor": 8.33, "data_vencimento": "2024-08-01", "entrada": false},
        {"numero": 2, "valor": 8.33, "data_vencimento": "2024-09-01"},
        ...
        {"numero": 12, "valor": 8.33, "data_vencimento": "2025-07-01"}
    ]
    }
```

**Request 2**
    GET /api/recuperar-parcelas/2

**Response 2**
```json
        {
    "total": 0.30,
    "valor_entrada": 0.10,
    "parcelas": [
        {"numero": 1, "valor": 0.10, "data_vencimento": "2024-08-01", "entrada": true},
        {"numero": 2, "valor": 0.10, "data_vencimento": "2024-08-08"},
        {"numero": 3, "valor": 0.10, "data_vencimento": "2024-08-15"}
    ]
    }
```


## INSTALAÇÃO DO FRONTEND

1. Clone o repositório:
```bash
   git clone https://github.com/lucaasbritto/tenex_back.git
```

2. Navegue até o diretório do projeto:
    cd seu-repositorio

3. Instale as dependências:
    npm install

4. Inicie o servidor
    npm run serve