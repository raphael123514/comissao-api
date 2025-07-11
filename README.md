# Sistema de Gerenciamento de Comissões de Venda

Este projeto é uma API robusta desenvolvida em Laravel para gerenciar e calcular comissões de vendas, abrangendo tanto vendas diretas quanto de afiliados. Com foco em uma arquitetura limpa e escalável, a aplicação utiliza princípios de Domain-Driven Design (DDD) e padrões de projeto para garantir manutenibilidade e clareza no código.

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

## Sumário
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Requisitos](#requisitos)
- [Configuração e Execução](#configuração-e-execução)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Resolução de ambiguidade](#resolução-de-ambiguidade)
- [Uso da API](#uso-da-api)
- [Licença](#licença)
- [Autor](#autor)

---

## Tecnologias Utilizadas

Este projeto foi desenvolvido utilizando as seguintes tecnologias:

* **Laravel**: Framework PHP robusto para desenvolvimento de aplicações web(versão 12).
* **PHP**: Linguagem de programação (versão 8.2+ recomendada).
* **Docker / Laravel Sail**: Para o ambiente de desenvolvimento e orquestração de containers.
* **Composer**: Gerenciador de dependências para PHP.
* **JSON FILE**: Arquivo json para armazenamento dos dados.
* **Git**: Sistema de controle de versão.

---

## Requisitos

Para executar este projeto em sua máquina local, você precisará ter instalado:

* **Docker Desktop**: Inclui Docker Engine e Docker Compose.
* **Git**: Para clonar o repositório.

---

## Configuração e Execução

Siga os passos abaixo para colocar o projeto em funcionamento usando Laravel Sail:

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/raphael123514/comissao-api.git](https://github.com/raphael123514/comissao-api.git)
    cd comissao-api
    ```

2.  **Copie o arquivo de exemplo de ambiente:**
    ```bash
    cp .env.example .env
    ```

3.  **Suba os containers com o Sail:**
    ```bash
    ./vendor/bin/sail up -d
    ```
    *Na primeira execução, isso pode levar alguns minutos enquanto as imagens Docker são baixadas.*

4.  **Instale as dependências do Composer:**
    ```bash
    ./vendor/bin/sail composer install
    ```

5.  **Gere a chave da aplicação:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```
Após seguir esses passos, a API estará acessível em `http://localhost`.

---

## Estrutura do Projeto

Este projeto foi concebido com base na arquitetura **DDD (Domain-Driven Design)**, visando modularidade e manutenibilidade.

* A pasta **`Domain`** contém todas as **entidades** e a lógica de negócio central.
* Na pasta **`Infrastructure`**, implementamos os **repositórios** para manipulação dos dados (atualmente com foco em manipulação de arquivos JSON) e a lógica para selecionar o tipo de venda utilizando o **Design Patterner Strategy**.

## Resolução de ambiguidade

- Para resolver a ambiguidade no cálculo de comissão, utilizei uma **classe abstrata** (`AbstractCommissionCalculationStrategy`) que implementa a função principal `calculate()`. Esta função é responsável pelo cálculo da taxa de plataforma (sempre 10% sobre o valor da venda). Ela instancia a entidade `Commissions`, define as informações dos cálculos gerados pela função abstrata `calculateSpecificCommissions()` e retorna a entidade `Sale`.
As classes filhas (`AffiliateSaleCommissionsStrategy` e `DirectSaleCommissionsStrategy`) implementam a função `calculateSpecificCommissions()` com a lógica específica de comissão para cada tipo de venda, herdando o comportamento comum de `calculate()`.

- Para padronizar o retorno dos dados nos endpoints, especialmente para listar e criar vendas, foi criado um **API Resource** (`SaleResource`). Isso evita código ambíguo e garante uma estrutura de resposta consistente.

---

## Uso da API

A API oferece os seguintes endpoints para gerenciamento de vendas:

### Listar histórico de comissão de venda

Retorna uma lista paginada de todos os registros de vendas, incluindo os detalhes das comissões.

```http
GET /api/sales
```

### Criar histórico de comissão de venda

Cria um novo registro de venda, calculando automaticamente as comissões com base no tipo de venda fornecido.

```http
POST /api/sales
Content-Type: application/json

{
    "valor_total": 10000,
    "tipo_venda" : "direta"
}
```

* **`valor_total`**: O valor total da venda (obrigatório).
* **`tipo_venda`**: O tipo da venda ("direta" ou "afiliado") (obrigatório).

### Excluir histórico de comissão de venda

Exclui um registro de venda específico pelo seu ID.

```http
DELETE /api/sales/1
```
* **`1`**: Substitua pelo ID da venda a ser excluída.

---

## Autor

* Raphael Fonseca - https://github.com/raphael123514 | https://www.linkedin.com/in/raphael-fonseca-483980143/

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

