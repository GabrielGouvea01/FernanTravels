# FernanTravels

## Visão geral

O FernanTravels é um sistema para uma empresa de viagens. Ele permite cadastrar clientes, manter seus dados organizados e acompanhar as cotações solicitadas.

Os dados do cliente incluem nome, data de nascimento, documento, histórico de viagens e cotações. As informações enviadas pelos formulários devem ser armazenadas no banco de dados para que a equipe de vendas possa consultá-las ao preparar uma cotação.

## Perfis e permissões

- **Administrador:** tem acesso a todas as funcionalidades e pode conceder permissões a outros usuários.
- **Gerente:** pode executar ações de acordo com as permissões concedidas pelo administrador. Usuários com perfil de gerente podem consultar cotações de outros clientes.
- **Cliente:** pode consultar, atualizar e excluir as próprias cotações, mas não pode visualizar cotações de outros clientes.

## Requisitos funcionais

### Contas e acesso

1. Permitir que clientes criem uma conta informando nome, e-mail e senha.
2. Permitir que clientes, gerentes e administradores façam login.
3. Verificar se o usuário está autenticado nas páginas que exigem login.
4. Permitir que o administrador conceda permissões aos gerentes.
5. Restringir as ações dos gerentes às permissões concedidas pelo administrador.

### Clientes

6. Permitir a gestão do perfil do cliente.
7. Armazenar dados dos clientes, incluindo histórico de viagens e informações de passageiros recorrentes, para agilizar futuras compras.

### Cotações

8. Permitir que o cliente solicite uma cotação.
9. Permitir que o cliente consulte, atualize ou exclua as próprias cotações.
10. Permitir que usuários com as permissões adequadas consultem e alterem cotações.
11. Exibir o status de cada cotação, como “Em avaliação”, “Em produção” ou “Finalizada”, para que o cliente acompanhe o andamento.


Autenticação e Controle de Acesso
1. Permitir que clientes criem uma conta informando nome, e-mail e senha.
cadastrarCliente(dadosCliente): Recebe os dados de cadastro (nome, email, senha), valida e cria o registro do cliente no banco de dados.

validarDadosCadastro(dados): Verifica se os campos obrigatórios estão preenchidos e se o formato do e-mail é válido.

verificarEmailExistente(email): Checa se o e-mail informado já está cadastrado para evitar duplicidade.

criptografarSenha(senha): Gera o hash seguro da senha (ex: usando bcrypt ou Argon2) antes de salvar no banco de dados.

2. Permitir que clientes, gerentes e administradores façam login.
autenticarUsuario(email, senha): Valida o e-mail e compara o hash da senha enviada com o armazenado no banco.

gerarTokenAutenticacao(usuarioId, perfil): Cria um token de acesso seguro (ex: JWT) contendo a identificação do usuário e seu tipo de perfil (CLIENTE, GERENTE ou ADMINISTRADOR).

fazerLogout(token): Invalida o token de autenticação (se utilizar controle de revogação/blacklist).

3. Verificar se o usuário está autenticado nas páginas que exigem login.
verificarTokenAutenticacao(token): Decodifica e valida se o token enviado na requisição é autêntico e não expirou.

middlewareAutenticacao(requisicao, resposta, proximo): Intercepta as requisições para rotas protegidas e bloqueia o acesso caso o usuário não possua um token válido.

obterUsuarioAtual(token): Retorna os dados fundamentais do usuário logado a partir do token ativo.

4. Permitir que o administrador conceda permissões aos gerentes.
concederPermissaoGerente(gerenteId, listaPermissoes): Associa um conjunto de permissões específicas a um determinado perfil de gerente.

atualizarPermissoesGerente(gerenteId, novasPermissoes): Sobrescreve ou edita as permissões já concedidas a um gerente.

listarPermissoesDisponiveis(): Retorna todas as permissões/módulos existentes no sistema que podem ser distribuídos.

5. Restringir as ações dos gerentes às permissões concedidas pelo administrador.
verificarPermissao(usuarioId, permissaoRequerida): Checa se o usuário atual possui a permissão específica necessária para executar a ação solicitada.

middlewareAutorizacao(permissaoRequerida): Middleware acoplado às rotas administrativas que bloqueia a requisição (retornando erro 403 Forbidden) caso o gerente não tenha a permissão exigida.

Clientes
6. Permitir a gestão do perfil do cliente.
obterPerfilCliente(clienteId): Busca e exibe os dados cadastrais do cliente logado.

atualizarPerfilCliente(clienteId, novosDados): Atualiza informações como telefone, endereço, CPF e foto de perfil.

alterarSenhaCliente(clienteId, senhaAtual, novaSenha): Permite ao cliente redefinir sua senha verificando primeiro a senha antiga.

7. Armazenar dados dos clientes, incluindo histórico de viagens e informações de passageiros recorrentes, para agilizar futuras compras.
obterHistoricoViagens(clienteId): Busca todas as reservas e viagens anteriores já concluídas ou confirmadas do cliente.

adicionarPassageiroRecorrente(clienteId, dadosPassageiro): Cadastra os dados de um acompanhante habitual (nome, data de nascimento, CPF/passaporte).

listarPassageirosRecorrentes(clienteId): Traz a lista de passageiros vinculados à conta para seleção rápida no checkout.

atualizarPassageiroRecorrente(clienteId, passageiroId, novosDados): Edita as informações de um acompanhante salvo.

removerPassageiroRecorrente(clienteId, passageiroId): Exclui um passageiro salvo da lista do cliente.

Cotações
8. Permitir que o cliente solicite uma cotação.
solicitarCotacao(clienteId, dadosCotacao): Cria um novo registro de cotação com os parâmetros da viagem (destino, datas flexíveis, número de passageiros, orçamento estimado, observações).

notificarNovaCotacao(cotacaoId): Envia alerta/e-mail para a equipe interna de gerentes informando que uma nova cotação foi aberta.

9. Permitir que o cliente consulte, atualize ou exclua as próprias cotações.
listarCotacoesDoCliente(clienteId): Traz todas as cotações criadas pelo cliente logado.

obterCotacaoPorId(cotacaoId, clienteId): Exibe os detalhes de uma cotação específica, garantindo que ela pertença ao cliente logado.

atualizarCotacaoDoCliente(cotacaoId, clienteId, novosDados): Permite alterar detalhes da cotação enquanto ela estiver em status editável.

cancelarOuExcluirCotacao(cotacaoId, clienteId): Cancela ou remove a solicitação de cotação feita pelo cliente.

10. Permitir que usuários com as permissões adequadas consultem e alterem cotações.
listarTodasCotacoes(filtros): Permite que gerentes e admins visualizem todas as cotações da agência, filtrando por data, cliente ou status.

atribuirCotacaoAGerente(cotacaoId, gerenteId): Define qual membro da equipe é o responsável por tratar aquela cotação.

atualizarValoresCotacao(cotacaoId, dadosPreco, detalhesProposta): Insere os preços, voos, hotéis sugeridos e opções de pagamento na cotação do cliente.

11. Exibir o status de cada cotação, como “Em avaliação”, “Em produção” ou “Finalizada”, para que o cliente acompanhe o andamento.
atualizarStatusCotacao(cotacaoId, novoStatus, usuarioId): Altera o estado da cotação no sistema (ex: de "Em avaliação" para "Em produção" ou "Finalizada").

obterStatusCotacao(cotacaoId): Retorna o status atual e o histórico de alterações para exibição na linha do tempo da cotação.

notificarMudancaStatus(cotacaoId, clienteId, novoStatus): Dispara um e-mail/notificação automática para o cliente sempre que o status da sua cotação for alterado pela equipe.

Para resolver o seu problema, você não precisa necessariamente copiar fisicamente uma coluna de uma tabela para outra toda vez que fizer uma cotação. Em bancos de dados relacionais (SQL), a melhor prática é relacionar as tabelas através de uma Chave Estrangeira (FOREIGN KEY). [1] 
Dessa forma, a cotação fica salva em uma tabela com o "carimbo" (ID) do cliente que a criou. A regra de "só o cliente logado pode ver" não é controlada pelo banco de dados sozinho, mas sim pelo seu código (Node.js, Python, PHP, etc.), que pega o ID do usuário logado e faz um filtro WHERE na consulta SQL.
Veja como estruturar essa lógica passo a passo:
Primeiro, garantimos que a tabela de cotações saiba a qual cliente ela pertence por meio de uma coluna cliente_id. [2] 

-- 1. Tabela de Clientes/ContasCREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE
);
-- 2. Tabela de Cotações (relacionada ao cliente)CREATE TABLE cotacoes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    valor_cotado DECIMAL(10, 2),
    produto VARCHAR(100),
    data_cotacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    cliente_id INT, -- Esta coluna faz o vínculo com a tabela clientes
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) -- Garante a integridade
);

------------------------------
Quando o sistema faz uma cotação, a sua aplicação web ou mobile já sabe quem é o usuário que está logado (vamos supor que o ID dele seja 5). Na hora de salvar na tabela cotacoes, você passa esse ID:

INSERT INTO cotacoes (valor_cotado, produto, cliente_id)VALUES (1500.00, 'Notebook Pro', 5); -- O número 5 é o ID do cliente logado capturado pelo seu sistema

------------------------------
Para garantir que o cliente só veja as próprias cotações, o seu sistema executará um SELECT utilizando a cláusula WHERE filtrando estritamente pelo ID do cliente logado.
Se o cliente 5 tentar acessar a página de cotações, o seu código backend rodará esta query:

SELECT id, valor_cotado, produto, data_cotacaoFROM cotacoesWHERE cliente_id = 5; -- Filtro de segurança obrigatório

Por que isso é seguro?
Mesmo que existam milhares de cotações de outros clientes na tabela cotacoes, o banco de dados só vai retornar as linhas onde o cliente_id seja exatamente igual a 5. Se outro usuário malicioso tentar acessar a mesma página, o seu backend identificará o ID dele (ex: cliente_id = 9) e a busca trará apenas os dados do cliente 9.
Qual linguagem de programação ou framework (ex: Node.js, PHP, Python) você está usando no backend para fazer esse sistema de login? Se quiser, posso te mostrar como fica o código que junta o SQL com a sessão do usuário logado.

[1] [https://www.quora.com](https://www.quora.com/When-you-have-two-tables-connected-through-a-foreign-key-how-can-you-make-sure-that-updates-done-to-one-table-are-also-updated-accordingly-in-the-other)
[2] [https://support.microsoft.com](https://support.microsoft.com/pt-br/excel/relationships-between-tables-in-a-data-model)



# Banco de dados
nome: fernantravels
usuario: fernantravels
senha: fernantravels

### tabela de cotação

nome: cotacao
colunas:
- nome
- telefone
- email
- origem
- destino
- ida
- volta
- qnt_adultos
- qnt_criancas
- qnt_bagagens
- hotel
- carro



- pegar id da conta do cliente no banco de dados
- atribuir esse id a uma sessao
- quando o cliente fazer uma cotaçao atribuir o id que esta na sessao a ela
- quando ele for ver a cotaçao usar um SELECT COM WHERE com base no id


CREATE TABLE usuarios(
    id SERIAL PRIMARY KEY,
    nome VARCHAR(120) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL 
);

CREATE TABLE cotacao(
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone INT NOT NULL, 
    email VARCHAR(100) NOT NULL, 
    origem VARCHAR(100) NOT NULL, 
    destino VARCHAR(100) NOT NULL, 
    ida DATE NOT NULL, 
    volta DATE NOT NULL, 
    qnt_adultos INT NOT NULL, 
    qnt_criancas INT NOT NULL, 
    qnt_bagagens INT NOT NULL, 
    hotel VARCHAR(50) NOT NULL, 
    carro VARCHAR(50) NOT NULL, 
    id_cliente INT REFERENCES usuarios(id)
);


### SENHA ADMIN 12345