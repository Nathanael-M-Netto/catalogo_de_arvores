# Catálogo de Árvores - Fatec Itapetininga

## 🌳 Introdução

Bem-vindo ao projeto **Catálogo de Árvores**! Esta é uma iniciativa académica desenvolvida por estudantes da Fatec Itapetininga, com o objetivo primordial de **catalogar as espécies arbóreas** encontradas em nosso ambiente urbano e regional, criando um repositório digital abrangente. O projeto foca-se em documentar, partilhar conhecimento, promover a educação e preservação ambiental, com a visão de, **futuramente, expandir para o mapeamento geográfico** destas árvores, enriquecendo ainda mais a interação e o estudo do nosso patrimônio natural.

Cada registo no catálogo inclui informação científica, nomes populares, características distintivas, fotografias (obtidas dinamicamente de APIs como a PlantNet e guardadas em cache) e curiosidades sobre as árvores.


## 🎥 Demonstração

![Demonstração da Aplicação](src/demo/working.gif)

## ✨ Funcionalidades Principais

* **Catálogo Detalhado de Árvores:** Navegue e pesquise diversas espécies de árvores.
* **Galerias de Imagens Dinâmicas:** Visualize imagens de alta resolução de folhas, flores, frutos, cascas e o porte geral das árvores, com imagens obtidas da API PlantNet e armazenadas em cache localmente.
* **Pesquisa Avançada:** Encontre árvores por nome científico, nome popular ou outras características específicas.
* **Painel Administrativo:** Uma área segura para administradores poderem:
    * Gerir os registos do catálogo de árvores (adicionar, atualizar, excluir - *CRUD de árvores implementado em `admin/admin.php`*).
    * Gerir utilizadores administradores (adicionar, atualizar, excluir outros utilizadores admin - *implementado em `admin/gerenciar_usuarios_admin.php`*).
* **Design Responsivo:** Interface amigável e adaptável a diferentes tamanhos de ecrã, construída com Tailwind CSS.
* **UI Interativa:** Animações e transições suaves utilizando AOS (Animate On Scroll) e SwiperJS para carrosséis de imagens.
* **Alternador de Tema (Claro/Escuro):** Preferência do utilizador para modo claro ou escuro, guardada no `localStorage`.

## 💻 Tecnologias Utilizadas

* **Backend:** PHP
* **Base de Dados:** PostgreSQL (ligação via PDO)
* **Frontend:** HTML, Tailwind CSS, JavaScript
* **Bibliotecas JavaScript:**
    * AOS (Animate On Scroll) - Para animações ao rolar a página.
    * SwiperJS - Para carrosséis de imagens e galerias interativas.
    * Font Awesome - Para ícones.
* **APIs Externas:**
    * PlantNet API - Para obter imagens de espécies de árvores.

## 🧑‍💻 Autores / Equipa

Este projeto foi desenvolvido pelos talentosos estudantes da Fatec Itapetininga:

* Nathanael Netto *(Programador)*
* Camilly Santos *(Programadora)*
* Matheus Poles *(Programador)*
* Otavio Augusto *(Programador)*
* Enzo Padilha *(Programador)*
* Kayke Yuji *(Programador)*
* Marciel Silva *(Programador)*

## 🚀 Como Começar

Siga estas instruções para obter uma cópia do projeto a funcionar na sua máquina local para desenvolvimento e testes.

### Pré-requisitos

* Um ambiente de servidor web como XAMPP, WAMP, MAMP, ou um servidor PHP autónomo.
* PHP (a versão 8.0.30 foi usada durante o desenvolvimento, mas outras versões PHP 8.x devem funcionar).
    * Certifique-se de que a extensão `pdo_pgsql` está ativa no seu ficheiro `php.ini` para conectividade com o PostgreSQL.
* Servidor PostgreSQL instalado e em execução.

### Instalação e Configuração

1.  **Clonar o repositório:**
    ```bash
    git clone [https://github.com/JablesPoles/mapeamento-arvores.git](https://github.com/JablesPoles/mapeamento-arvores.git) catalogo_de_arvores
    cd catalogo_de_arvores
    ```
    *(O comando `git clone` agora sugere renomear a pasta para `catalogo_de_arvores` durante o clone, ou você pode renomeá-la manualmente após clonar com o nome padrão `mapeamento-arvores`)*

2.  **Configuração da Base de Dados:**
    * Crie uma base de dados PostgreSQL chamada `projeto_arvores` (ou qualquer nome que prefira, mas precisará de atualizar o `conexao.php` em conformidade).
    * **Execute os scripts SQL** localizados no diretório `bd/` para criar a estrutura das tabelas e inserir dados iniciais. É crucial executar os scripts na ordem correta, se houver dependências:
        1.  `ScriptBD.sql`: Geralmente contém a criação das tabelas principais do catálogo de árvores e outros dados essenciais.
        2.  `ScriptAdmin.sql`: Provavelmente configura a tabela de administradores e/ou insere o usuário administrador inicial.
    * Verifique o conteúdo dos scripts para entender a ordem exata e o que cada um faz.
    * O utilizador admin padrão, se criado por estes scripts, geralmente é:
        * **Nome de Utilizador:** `admin`
        * **Palavra-passe:** `admin123` (Confirme esta informação nos scripts ou na documentação do script `ScriptAdmin.sql`).

3.  **Configuração da Ligação:**
    * Abra o ficheiro `conexao.php` no diretório raiz (`catalogo_de_arvores/conexao.php`).
    * Atualize os detalhes de ligação à base de dados se forem diferentes dos padrões:
        ```php
        $host = 'localhost';
        $port = '5432'; // Porta padrão do PostgreSQL
        $dbname = 'projeto_arvores';
        $user = 'postgres'; // O seu nome de utilizador do PostgreSQL
        $pass = 'postgres'; // A sua palavra-passe do PostgreSQL
        ```

4.  **Executar a Aplicação:**
    * Coloque a pasta do projeto (`catalogo_de_arvores`) no diretório raiz do seu servidor web (ex: `htdocs` para o XAMPP).
    * Abra o seu navegador e navegue para o URL do projeto (ex: `http://localhost/catalogo_de_arvores/`).

### Acesso de Administrador

* Para aceder ao painel administrativo para adicionar árvores, navegue para: `http://localhost/catalogo_de_arvores/admin/admin.php`
* Para gerir utilizadores administradores, navegue para: `http://localhost/catalogo_de_arvores/admin/gerenciar_usuarios_admin.php`
* Ser-lhe-á pedido para fazer login. Use as credenciais padrão (`admin`/`admin123`) ou qualquer outra conta de administrador que criar.

### Importação de Dados Iniciais de Árvores (via CSV)

O projeto inclui um script PHP para popular o banco de dados com um conjunto inicial de dados de árvores a partir de um arquivo CSV. Este passo é geralmente realizado *após* a criação das tabelas pelos scripts SQL (`ScriptBD.sql`).

* **Script de Importação:** `config/import_arvores.php`
* **Arquivo de Dados:** `config/data/dados_arvore.csv` (Este arquivo contém os dados das árvores que serão importados)

**Para executar a importação:**

1.  Certifique-se de que o servidor PostgreSQL está em execução, que as tabelas foram criadas pelos scripts SQL da pasta `bd/`, e que as configurações de conexão em `conexao.php` estão corretas.
2.  Abra um terminal ou prompt de comando.
3.  Navegue até o diretório de instalação do PHP (geralmente dentro da pasta do XAMPP, WAMP, etc.).
4.  Execute o script `import_arvores.php` usando o executável do PHP, fornecendo o caminho completo para o script dentro da sua pasta do projeto.
    Exemplo (ajuste os caminhos conforme a sua instalação e o local da pasta do projeto):
    ```bash
    C:\xampp\php\php.exe C:\xampp\htdocs\catalogo_de_arvores\config\import_arvores.php
    ```
5.  Você deverá ver uma saída semelhante a esta no terminal, indicando o progresso e o resultado da importação:
    ```
    Iniciando importação...
    Processadas 100 linhas...
    Importação concluída com sucesso!
    Total de registros inseridos: 178
    Tempo de execução: 0.03 segundos
    ```
    *Nota: O número de registros inseridos e o tempo de execução podem variar.*

**O que é necessário para a importação via CSV funcionar:**
* PHP CLI (Interface de Linha de Comando) instalado e acessível.
* O arquivo `config/data/dados_arvore.csv` presente no caminho esperado pelo script (`catalogo_de_arvores/config/data/dados_arvore.csv`).
* Conexão válida com o banco de dados PostgreSQL configurada em `conexao.php`.
* As tabelas do banco de dados (`arvores`, etc.) devem existir (criadas pelos scripts SQL da pasta `bd/`). O script de importação não cria as tabelas, apenas insere os dados.

## 📂 Estrutura do Projeto

```
catalogo_de_arvores/
├── admin/                    # Páginas específicas do Admin (login, gestão de utilizadores, formulário de registo de árvores)
│   ├── admin.php             # Formulário para registar novas árvores
│   ├── gerenciar_usuarios_admin.php
│   ├── login_admin.php
│   ├── logout_admin.php
│   └── processa_usuario_admin.php
├── assets/
│   ├── css/                  # Ficheiros CSS personalizados (custom_styles.css, index_styles.css)
│   └── js/                   # Ficheiros JavaScript personalizados (catalogo_scripts.js, index.js, style.js)
├── bd/                       # Scripts SQL para configuração inicial do banco de dados
│   ├── ScriptAdmin.sql       # Script para configurar a tabela de administradores e/ou usuário admin inicial
│   └── ScriptBD.sql          # Script para criar as tabelas principais do catálogo e dados essenciais
├── config/                   # Ficheiros de configuração e scripts utilitários
│   ├── import_arvores.php    # Script para importar dados de árvores do arquivo CSV para o banco de dados
│   └── data/                 # Contém os dados brutos para importação
│       └── dados_arvore.csv  # Arquivo CSV com os dados das árvores a serem importados
├── src/                      # Funções PHP de backend
│   ├── api_functions.php     # Funções para interagir com APIs externas (PlantNet)
│   ├── demo/                 # Contém o GIF de demonstração
│   │   └── working.gif
│   └── db_functions.php      # Funções de interação com a base de dados (CRUD para árvores, admins, cache de imagens)
├── templates/                # Templates HTML/PHP reutilizáveis
│   ├── footer.php
│   ├── header.php
│   ├── pagination.php
│   └── tree_card.php
├── catalogo.php              # Página pública principal para exibir o catálogo de árvores
├── conexao.php               # Script de ligação à base de dados (PDO PostgreSQL)
├── index.php                 # Página inicial da aplicação
└── ... (outros ficheiros na raiz como .gitignore, README.md)
```

## 🛠️ Notas de Desenvolvimento

* **Relatório de Erros:** Para desenvolvimento, certifique-se de que `error_reporting(E_ALL)` e `ini_set('display_errors', 1)` estão ativos (geralmente no topo dos scripts principais ou numa configuração global) para ver todos os erros PHP.
* **Segurança:**
    * O script `gerar_hash.php` (se usado) deve ser apagado imediatamente após gerar e atualizar um hash de palavra-passe.
    * As palavras-passe de administrador são armazenadas com hash usando `password_hash()` com `PASSWORD_DEFAULT` (bcrypt).
    * A sanitização de entradas e as prepared statements (PDO) são usadas para prevenir injeção de SQL.
* **API PlantNet:** O `src/api_functions.php` usa cURL para obter imagens. Num ambiente de produção, `CURLOPT_SSL_VERIFYPEER` deve ser definido como `true`.

## 🔮 Melhorias Futuras (Sugestões)

* **Upload de Imagens para Árvores:** Permitir que administradores carreguem imagens diretamente em vez de depender apenas de APIs externas.
* **Registo de Coordenadas Geográficas:** Adicionar campos para latitude e longitude nos registos das árvores (essencial para o futuro mapeamento).
* **Integração com API de Mapas:** Utilizar uma API como Google Maps, Leaflet ou OpenStreetMap para exibir as árvores mapeadas geograficamente, permitindo visualização espacial e filtros baseados em localização.
* **Dashboard Administrativo Avançado:** Um painel com estatísticas (total de árvores, utilizadores, etc.).
* **Níveis de Permissão de Utilizador:** Implementar níveis mais granulares se forem necessários diferentes tipos de acesso administrativo.
* **Importação CSV Melhorada:** Aprimorar o `config/import_arvores.php` com tratamento de erros mais robusto, validação de dados e suporte para mapear todas as colunas CSV corretamente, incluindo múltiplos nomes populares.
* **API para Dados das Árvores:** Desenvolver uma API RESTful para o próprio catálogo de árvores, permitindo que outras aplicações consumam os dados.
* **Testes Unitários e de Integração.**

## 🤝 Contribuir

Este é um projeto académico. Se é um estudante da Fatec Itapetininga ou está interessado em contribuir, sinta-se à vontade para fazer um fork do repositório, realizar as suas alterações e submeter um pull request. Para alterações significativas, por favor, abra primeiro uma "issue" para discutir o que gostaria de mudar.

## 📜 Licença

Este projeto é um trabalho académico. Por favor, contacte os autores ou a Fatec Itapetininga relativamente ao licenciamento se pretender usá-lo para fins que não sejam estudo académico ou uso pessoal.
