# Backend - Laravel API

Este projeto back-end foi desenvolvido inteiramente em Laravel e serve como complemento ao sistema de cadastro de estabelecimentos, produtos e compras, cujo front-end foi desenvolvido com Vue.js.

## Migrations, Factories e Seeders

O projeto já inclui migrations prontas para as tabelas essenciais do sistema, bem como factories e seeders para popular o banco de dados com dados de exemplo. As migrations disponíveis são:

- **users**: responsável por armazenar os dados dos usuários do sistema.
- **stores**: responsável pelo armazenamento de informações sobre os estabelecimentos cadastrados.
- **products**: responsável pelo armazenamento dos produtos disponíveis para compra.

Já os seeders disponíveis são:

- **UserTableSeeder**: responsável por popular a tabela de usuários com dados de exemplo.
- **StoreTableSeeder**: responsável por popular a tabela de estabelecimentos com dados de exemplo.
- **ProductTableSeeder**: responsável por popular a tabela de produtos com dados de exemplo.

## Organização das Rotas da API

As rotas da API foram organizadas de forma a seguir as melhores práticas de desenvolvimento e facilitar a integração com o front-end. Abaixo está a lista das principais rotas disponíveis:

- `/login`: Rota para autenticar um usuário e obter um token de acesso.
- `/register`: Rota para registrar um novo usuário no sistema.
- `/product/show/{id}`: Rota para exibir detalhes de um produto específico.
- `/product/getProductsAll`: Rota para obter todos os produtos cadastrados.
- `/product/getProductsBySearch/{searchTerm}`: Rota para buscar produtos por termo de pesquisa.
- `/product/getProductsCheap`: Rota para obter produtos mais baratos.

Rotas autenticadas, que requerem token JWT:

- `/store/store`: Rota para cadastrar um novo estabelecimento.
- `/store/update`: Rota para atualizar informações de um estabelecimento.
- `/store/delete/{id}`: Rota para excluir um estabelecimento.
- `/store/getStoresByUser`: Rota para obter os estabelecimentos cadastrados por um usuário.

- `/product/store`: Rota para cadastrar um novo produto.
- `/product/update`: Rota para atualizar informações de um produto.
- `/product/delete/{id}`: Rota para excluir um produto.
- `/product/getProductsByStore/{id}`: Rota para obter os produtos de um determinado estabelecimento.

- `/category/store`: Rota para cadastrar uma nova categoria de produto.
- `/category/getCategoriesAll`: Rota para obter todas as categorias cadastradas.

- `/request/store`: Rota para fazer uma solicitação de compra.
- `/request/getRequestsByUser`: Rota para obter as solicitações feitas por um usuário.
- `/request/getRequestsByStore/{îd}`: Rota para obter as solicitações feitas para um estabelecimento.

- `/logout`: Rota para deslogar o usuário e invalidar o token JWT.

---
Este backend foi desenvolvido para fornecer uma API robusta e segura para integração com o front-end Vue.js. Consulte a documentação oficial do Laravel para mais detalhes sobre o desenvolvimento com este framework.
