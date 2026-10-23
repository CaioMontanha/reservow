# RESERVOW

Aplicação interna de operações de passeios para Porto de Galinhas, feita com Laravel 12, Blade, Bootstrap 5 e MySQL 8. A interface segue as telas de referência em UI/stitch_reservow_monitor.

## Rodar localmente

Requisitos: PHP 8.2+, Composer, extensões PDO MySQL/SQLite e MySQL 8 (ou SQLite para desenvolvimento/testes).

1. composer install
2. Copie .env.example para .env e configure as credenciais do banco.
3. php artisan key:generate
4. php artisan migrate --seed
5. php artisan serve

## Testes

Execute vendor/bin/phpunit.

## API

Rotas sob /api: GET /passeios, GET /saidas?data=AAAA-MM-DD&passeio=slug, GET e POST /reservas, GET /reservas/{id}, PATCH /reservas/{id}/confirmar e PATCH /reservas/{id}/cancelar.

O seeder prepara passeios e saídas para hoje e os próximos seis dias. Maragogi de hoje começa com 18 pessoas confirmadas e uma reserva pendente de 3 pessoas para mostrar a validação de capacidade. Os registros do seed são demonstração local, sem origem de operação real conectada.
