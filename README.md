# R2R - Ready To Register

## Descrição
**R2R - Ready To Register** é um sistema de cadastro de clientes multi-usuário, criado na maior pureza que possa existir. Este sistema permite o gerenciamento eficiente de usuários e clientes, proporcionando uma solução simples e eficaz para pequenas e médias empresas que necessitam de um sistema de registro de clientes.

## Índice

- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Uso](#uso)
- [Funcionalidades](#funcionalidades)
- [Contribuição](#contribuição)
- [Licença](#licença)
- [Autor](#autor)

## Requisitos

Antes de instalar e rodar o R2R, certifique-se de que o seu ambiente atenda aos seguintes requisitos:

- PHP 8.1
- MySQL
- Composer 2.x

## Instalação

Para inicializar o projeto, siga os passos abaixo:

1. **Instale o PHP 8.1**:  
   Se o PHP 8.1 não estiver instalado em sua máquina, você pode baixá-lo e instalá-lo diretamente ou utilizar o pacote [XAMPP](https://www.apachefriends.org/pt_br/download.html), que inclui o PHP 8.1, MySQL, e outras ferramentas essenciais.

2. **Instale o MySQL**:  
   Caso o MySQL não esteja instalado, você pode baixá-lo separadamente ou utilizar o XAMPP, que já inclui o MySQL integrado.

3. **Instale o Composer**:  
   O Composer é necessário para gerenciar as dependências do projeto. Se ainda não o    tiver instalado, você pode baixá-lo em [getcomposer.org](https://getcomposer.org/download/).

4. **Instale o MySQl Workbench (Opcional)**:  
   Para um melhor gerenciamento do banco de dados, recomendamos que baixe o MySQL Workbench em [dev.mysql](https://dev.mysql.com/downloads/workbench/).

5. **Clone o repositório**:  
   Clone o repositório do projeto na sua máquina local.
   ```bash
      git clone https://github.com/Trim07/R2R.git
      cd R2R

6. **Intalar dependências**:  
   Utilize o comando: **composer install**


## Configuração

É necessário que, antes de iniciar o projeto, você configure o arquivo `.env` localizado na pasta `src/` e crie o banco de dados especificado no arquivo.

1. **Configuração do arquivo `.env`**:  
   - Abra o arquivo `.env` que está localizado na pasta `src/`.
   - Insira as configurações corretas do seu banco de dados, como o nome do banco de dados, usuário, senha, host, e porta.

2. **Criação do banco de dados**:  
   - Crie um banco de dados no MySQL utilizando o nome especificado no arquivo `.env`.
   - Garanta que o usuário e senha configurados no `.env` tenham as permissões necessárias para acessar e manipular o banco de dados.

3. **Criação das tabelas no banco de dados**:
   - Use o comando **composer run-migrations** para criar as migrações
   - Ou use o comando **composer dump-autoload**.


## Inicialização do projeto

O projeto pode ser iniciado digitando o comando **composer run-server**.

Ou, caso queira, pode estar indo até o diretório src/public e utilizar o comando **php -S localhost:8000**.

Após isso, você pode abrir o navegador e digitar **localhost:8000** na barra de pesquisa.

## Uso

O **R2R - Ready To Register** deve ser utilizado exclusivamente para o gerenciamento de clientes. Ele oferece uma interface intuitiva para:

- Adicionar novos clientes ao sistema.
- Editar informações dos clientes existentes.
- Visualizar a lista de todos os clientes cadastrados.
- Remover clientes do sistema quando necessário.

Este sistema é ideal para empresas que precisam de uma ferramenta simples e eficaz para manter registros de clientes organizados e acessíveis.

## Funcionalidades

As principais funcionalidades do **R2R - Ready To Register** incluem:

- **Gerenciamento de Usuários**: Permite a criação, edição, e remoção de usuários que têm acesso ao sistema, garantindo que somente pessoas autorizadas possam gerenciar os dados dos clientes.
- **Gerenciamento de Clientes**: Facilita a adição, edição, visualização e remoção de registros de clientes, oferecendo uma maneira fácil de manter todas as informações dos clientes organizadas e seguras.

## Contribuição

Contribuições para o **R2R - Ready To Register** são muito bem-vindas! Se você tiver sugestões, melhorias ou quiser adicionar novas funcionalidades, sinta-se à vontade para abrir uma issue ou enviar um pull request. Toda atualização que engrandeça o sistema será apreciada e cuidadosamente revisada.

## Licença

Este projeto é distribuído sob uma **licença livre**. Isso significa que você pode usar, modificar e distribuir o código conforme desejar, respeitando os termos de uso abertos.

## Autor

Desenvolvido por **Henrique C. Garlach**.

- GitHub: [Trim07](https://github.com/Trim07)
- LinkedIn: [Henrique C. Garlach](https://www.linkedin.com/in/trimcolt/)
