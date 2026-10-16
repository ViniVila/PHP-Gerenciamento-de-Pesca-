
# 🎣 Sistema de Gerenciamento de Pesca

Sistema web desenvolvido em PHP e MySQL para o gerenciamento de pescadores, embarcações e registros de pescarias. O projeto tem como objetivo organizar informações, facilitar o controle de cadastros e demonstrar a aplicação de conceitos de desenvolvimento web e banco de dados.

## 📌 Sobre o Projeto

O sistema permite centralizar informações relacionadas à atividade pesqueira, utilizando uma interface web conectada a um banco de dados relacional.

O projeto foi desenvolvido com foco na prática de programação back-end, integração com banco de dados, operações CRUD e aplicação de mecanismos de segurança para o tratamento de informações.

## 🚀 Funcionalidades

- 🔐 Sistema de autenticação de usuários.
- 👤 Cadastro e gerenciamento de pescadores.
- 🚤 Cadastro e gerenciamento de embarcações.
- 🎣 Registro e consulta de pescarias.
- 🔗 Relacionamento entre pescadores, embarcações e pescarias.
- 🗄️ Armazenamento de informações em banco de dados MySQL.
- 🔒 Utilização de hash de senhas e criptografia de CPF.

## 🛠️ Tecnologias Utilizadas

| Tecnologia | Aplicação |
|---|---|
| PHP | Desenvolvimento back-end |
| MySQL | Gerenciamento do banco de dados |
| SQL | Criação de tabelas e consultas |
| HTML5 | Estrutura das páginas |
| CSS3 | Estilização da interface |
| phpMyAdmin | Administração do banco de dados |
| Git e GitHub | Versionamento e hospedagem do código |

## 🗂️ Estrutura do Banco de Dados

O banco de dados `pesca` é organizado nas seguintes tabelas:

- **usuarios:** armazena os dados necessários para autenticação.
- **pescador:** armazena informações dos pescadores.
- **embarcacoes:** registra as embarcações vinculadas aos pescadores.
- **pescarias:** armazena os registros das pescarias e seus respectivos valores.

### Relacionamentos

- Um pescador pode possuir várias embarcações.
- Uma embarcação pode possuir vários registros de pescarias.

## ⚙️ Como Executar o Projeto

### Pré-requisitos

- PHP 8.0 ou superior, conforme compatibilidade do projeto.
- MySQL ou MariaDB.
- Apache ou outro servidor compatível com PHP.
- XAMPP ou ambiente de desenvolvimento equivalente.
- Navegador web.

### 1. Clone o repositório

```bash
git clone URL_DO_SEU_REPOSITORIO
```

### 2. Acesse a pasta do projeto

```bash
cd NOME_DO_PROJETO
```

### 3. Configure o ambiente local

Se estiver utilizando XAMPP, coloque a pasta do projeto no diretório `htdocs`.

Exemplo no Windows:

```text
C:\xampp\htdocs\pesca
```

### 4. Crie o banco de dados

1. Inicie o Apache e o MySQL no XAMPP.
2. Acesse `http://localhost/phpmyadmin`.
3. Abra a aba SQL.
4. Execute o script SQL do projeto para criar as tabelas e inserir os dados iniciais.

### 5. Configure a conexão

Abra o arquivo `config.php` e confira as configurações de conexão com o banco de dados:

- Servidor: `localhost`
- Banco de dados: `pesca`
- Usuário do MySQL: conforme a configuração local.
- Senha do MySQL: conforme a configuração local.

A chave de criptografia utilizada para os CPFs deve ser compatível com a configuração do sistema.

### 6. Acesse o sistema

Com o Apache e o MySQL em execução, abra:

```text
http://localhost/pesca
```

Se a pasta do projeto tiver outro nome, ajuste o endereço.

## 🔐 Segurança

O projeto utiliza mecanismos voltados à proteção dos dados:

- Hash de senhas para autenticação.
- Criptografia de CPF no banco de dados.
- Relacionamentos e restrições de integridade referencial.

**Observação:** a segurança depende também da implementação no PHP. Recomenda-se utilizar consultas preparadas, validação de entradas, proteção contra CSRF e armazenamento seguro das chaves de criptografia.

Não publique senhas reais, credenciais do banco de dados ou chaves secretas no repositório.

## 📚 Objetivos de Aprendizagem

Este projeto permite praticar conceitos importantes de desenvolvimento de sistemas:

- Desenvolvimento de aplicações web com PHP.
- Modelagem de bancos de dados relacionais.
- Operações CRUD (Create, Read, Update e Delete).
- Integração entre PHP e MySQL.
- Autenticação e proteção de informações.
- Versionamento de código com Git e GitHub.

## 🔮 Melhorias Futuras

- Implementação de níveis de acesso para usuários.
- Criação de relatórios e indicadores.
- Melhorias de responsividade e acessibilidade.
- Validação de formulários e mensagens de feedback.
- Implementação de testes automatizados.
- Aprimoramento dos mecanismos de segurança.

## 👨‍💻 Autor

**Vinícius Vila Nova**

Estudante de Desenvolvimento de Sistemas, interessado em programação, engenharia de software, inteligência artificial e desenvolvimento de soluções tecnológicas.

📌 GitHub: [Adicione aqui seu perfil](https://github.com/)

---

Desenvolvido como projeto de prática em desenvolvimento web e gerenciamento de dados.
