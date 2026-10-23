<?php
namespace Database\Seeders;
use App\Enums\StatusReserva;
use App\Models\Passeio;
use App\Models\Reserva;
use App\Models\Saida;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [['Maragogi','maragogi',20,'08:00'],['Praia dos Carneiros','carneiros',16,'09:00'],['Maracaípe ao pôr do sol','maracaipe',14,'16:00'],['Buggy pelas praias','buggy',8,'08:30'],['Piscinas naturais','piscinas',30,'10:00']];
        $names = ['Ana Souza','Bruno Lima','Carla Oliveira','Diego Santos','Elisa Ferreira','Felipe Costa','Gabriela Rocha','Heitor Alves','Isabela Martins','João Pereira','Larissa Melo','Mateus Silva','Natália Barros','Otávio Nunes','Paula Gomes','Rafael Torres','Sofia Ribeiro','Tiago Carvalho','Vera Azevedo','William Freitas','Yasmin Correia','André Moura','Beatriz Castro','Caio Andrade','Daniela Farias','Eduardo Pinto','Fernanda Lopes','Gustavo Ramos','Helena Dias','Igor Batista','Júlia Monteiro','Lucas Teixeira','Mariana Reis','Nicolas Campos','Olívia Cardoso'];
        foreach ($tours as [$name, $slug, $capacity, $time]) {
            $tour = Passeio::updateOrCreate(['slug' => $slug], ['nome' => $name, 'capacidade_padrao' => $capacity, 'preco_centavos' => 0, 'ativo' => true]);
            for ($day = 0; $day < 7; $day++) {
                $date = Carbon::today()->addDays($day);
                $saida = Saida::where('passeio_id', $tour->id)
                    ->whereDate('data', $date->toDateString())
                    ->where('horario', $time)
                    ->first();
                if (!$saida) {
                    $saida = Saida::create(['passeio_id' => $tour->id, 'data' => $date->toDateString(), 'horario' => $time, 'vagas_total' => $capacity]);
                }
                if ($day !== 0) continue;
                if ($saida->reservas()->exists()) continue;
                if ($slug === 'maragogi') {
                    foreach ([['Ana Souza',18,'confirmada'],['Bruno Lima',3,'pendente']] as [$person,$pax,$status]) Reserva::create(['saida_id'=>$saida->id,'codigo'=>Str::upper(Str::random(8)),'nome_cliente'=>$person,'telefone'=>'(81) 98765-4321','pessoas'=>$pax,'status'=>$status,'confirmada_em'=>$status==='confirmada'?now():null]);
                    continue;
                }
                $count = match ($slug) { 'carneiros' => 10, 'maracaipe' => 7, 'buggy' => 6, default => 10 };
                for ($i=0; $i<$count; $i++) {
                    $status = $i % 3 === 0 ? StatusReserva::Pendente : ($i % 3 === 1 ? StatusReserva::Confirmada : StatusReserva::Cancelada);
                    $pax = $slug === 'buggy' ? 2 : 3;
                    Reserva::create(['saida_id'=>$saida->id,'codigo'=>Str::upper(Str::random(8)),'nome_cliente'=>$names[($i + array_search($slug,['maragogi','carneiros','maracaipe','buggy','piscinas'],true)*6)%count($names)],'telefone'=>'(81) 9'.str_pad((string)random_int(10000000,99999999),8,'0',STR_PAD_LEFT),'pessoas'=>$pax,'status'=>$status,'confirmada_em'=>$status===StatusReserva::Confirmada?now():null]);
                }
            }
        }
    }
}
