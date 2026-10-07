RESERVOW
Gestão de reservas para passeios em Porto de Galinhas


COMO USAR COM A IA

Cole este documento inteiro e peça: construa o projeto completo de uma vez, sem me fazer perguntas. Onde faltar detalhe, decida e anote a decisão no README. Siga os contratos de API ao pé da letra, escreva os testes listados e entregue com seeders prontos e instruções curtas para rodar (composer install, migrate --seed, serve).


A IDEIA EM DUAS LINHAS

Sistema interno de uma operadora de passeios fictícia. A equipe vê as saídas do dia, quantas vagas restam em cada uma e confirma ou cancela reservas sem nunca estourar a capacidade.


O QUE TIRA ISSO DO NÍVEL DE CRUD

A regra de vagas vive no servidor e resiste a duas pessoas confirmando ao mesmo tempo. Confirmar uma reserva é uma operação dentro de transação com a saída travada, não um update de status.

Duas decisões que mudam o modelo:
Capacidade é por saída (um passeio em uma data e horário), não por passeio. Vinte vagas no total para sempre não faz sentido.
Vaga é contada em pessoas, não em reservas. Uma reserva pode ser de 4 pessoas.


STACK

Laravel 11, PHP 8.3, MySQL 8, Blade com Bootstrap 5 via CDN, PHPUnit


ESTRUTURA (caminhos do Laravel)

app/Enums/StatusReserva.php
app/Models/Passeio.php
app/Models/Saida.php
app/Models/Reserva.php
app/Services/ReservaService.php            a regra mora aqui
app/Exceptions/SemVagasException.php
app/Http/Controllers/Api/PasseioController.php
app/Http/Controllers/Api/SaidaController.php
app/Http/Controllers/Api/ReservaController.php
app/Http/Controllers/DashboardController.php
app/Http/Requests/StoreReservaRequest.php
app/Http/Resources/SaidaResource.php
app/Http/Resources/ReservaResource.php
database/migrations/
database/seeders/DemoSeeder.php
resources/views/dashboard.blade.php
resources/views/reservas/index.blade.php
resources/views/reservas/create.blade.php
tests/Feature/ReservaVagasTest.php


MODELO DE DADOS

passeios: id, nome, slug, capacidade_padrao, preco_centavos, ativo
saidas: id, passeio_id, data, horario, vagas_total. Único em (passeio_id, data, horario).
reservas: id, saida_id, codigo (8 caracteres, único), nome_cliente, telefone, pessoas (de 1 a 15), status, confirmada_em, cancelada_em, timestamps. Índice em (saida_id, status).

Na model Saida:
vagas_ocupadas = soma de pessoas das reservas confirmadas
vagas_restantes = vagas_total menos vagas_ocupadas


REGRAS

Reserva nasce pendente e não consome vaga.
Não aceita saída no passado nem passeio inativo.

Confirmar: dentro de DB::transaction, recarrega a saída com lockForUpdate, soma as pessoas confirmadas e, se essa soma mais as pessoas da reserva passar de vagas_total, lança SemVagasException. O controller converte em 409 com { erro: "sem_vagas", mensagem, vagas_restantes }. Se couber, marca como confirmada e grava confirmada_em.

Cancelar: pendente ou confirmada vira cancelada e a vaga é liberada. Cancelada é estado final.

Transições válidas: pendente para confirmada, pendente para cancelada, confirmada para cancelada. Qualquer outra responde 422 com mensagem clara. A regra de quem pode ir para onde fica no enum (método podeIrPara). A execução fica no ReservaService, nunca no controller.


CONTRATO DA API (routes/api.php)

GET    /api/passeios
GET    /api/saidas?data=2026-10-10&passeio=maragogi
       cada saída com vagas_total, vagas_ocupadas e vagas_restantes
POST   /api/reservas
       corpo: saida_id, nome_cliente, telefone, pessoas. Responde 201.
GET    /api/reservas?data=&status=&passeio=
       paginado, 15 por página
GET    /api/reservas/{id}
PATCH  /api/reservas/{id}/confirmar
       200, ou 409 sem vagas, ou 422 transição inválida
PATCH  /api/reservas/{id}/cancelar

Erros sempre no formato { erro, mensagem }.


TELAS

Dashboard do dia (rota /): seletor de data, hoje por padrão. Um card por saída com nome do passeio, horário, barra de ocupação do Bootstrap (verde até 69%, amarela de 70 a 99%, vermelha com o texto LOTADO quando chega a 100%) e contadores de pendentes e confirmadas.

Reservas (rota /reservas): tabela com filtro por data e status, badges de status e botões Confirmar e Cancelar em cada linha. Quando a regra de vagas barra a confirmação, aparece um alerta vermelho com a mensagem, por exemplo: Só restam 2 vagas nesta saída.

Nova reserva (rota /reservas/nova): escolhe a data, vê as saídas com vagas restantes, preenche os dados do cliente. O botão de salvar fica desabilitado se pessoas for maior que vagas_restantes.

As ações das telas chamam a própria API com fetch. Não é SPA, é Blade com um pouco de JavaScript.


DADOS DE SEED

Passeios: Maragogi (capacidade 20), Praia dos Carneiros (16), Maracaípe ao pôr do sol (14), Buggy pelas praias (8), Piscinas naturais (30).
Saídas para hoje e para os próximos 6 dias.
Cerca de 35 reservas com nomes brasileiros e telefones com DDD 81, misturando os três status.

Um detalhe obrigatório: a saída de Maragogi de hoje nasce com 18 de 20 vagas confirmadas e uma reserva pendente de 3 pessoas. De propósito. É a demonstração da regra e precisa estar na cara assim que o sistema abre.


ORDEM DE CONSTRUÇÃO

passo 1: migrations, enum, models e seeder
passo 2: ReservaService com os testes
passo 3: rotas e controllers da API, com FormRequest e Resources
passo 4: telas


TESTES OBRIGATÓRIOS (tests/Feature/ReservaVagasTest.php)

20 de 20 vagas confirmadas e tentativa de confirmar nova reserva: 409
18 de 20 confirmadas, reserva de 3 pessoas: 409. Reserva de 2 pessoas: 200
cancelar uma reserva confirmada libera a vaga e permite nova confirmação
cancelada não volta a confirmada: 422
reserva pendente não conta como vaga ocupada


O QUE PRECISA ESTAR LÁ PARA PARECER INTERMEDIÁRIO

Enum do PHP carregando a regra de transição. lockForUpdate dentro de transação. FormRequest para validação. API Resources para formatar a saída. Índice único composto. Testes de feature cobrindo a regra de negócio. Formato de erro padronizado.


FORA DO ESCOPO

Pagamento, login de cliente, aviso por WhatsApp. Lista de espera automática quando alguém cancela é um bom extra para depois.


PRONTO QUANDO

O sistema abre com Maragogi de hoje faltando 2 vagas. Confirmar a reserva pendente de 3 pessoas falha com mensagem clara na tela. Reduzir essa reserva para 2 pessoas e confirmar funciona, e a barra do card fica vermelha com LOTADO.