INSTRUÇÕES PARA SETUP DO PROJETO:

- 1: Executar o script precode.sql encontrado na raiz do projeto.
- 2: Alterar as configurações de Banco de dados no arquivo /config/database.php
- 3: Alterar o caminho do projeto nos seguintes arquivos, seguindo o exemplo: 
    - /config/auth_config.php
    - /config/config.json
    - /admin/app/services/util.service.js (Linhas 16, 17 e 18)
    - /web/app/services/util.service.js (Linhas 17, 18, 19 e 20)

- 4: Acesse /admin/lib e execute:
    git clone https://github.com/google/closure-library.git
- 5: Acesse /web/lib e execute: 
    git clone https://github.com/google/closure-library.git

*Para acessar a 'Loja virtual', acesse /web após as instruções acima*.

*Este projeto contém:   
    - Slim Framework para a construção de rotas de API REST*
    - AngularJs como framework JS*
    - Padrão MVC*

