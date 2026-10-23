<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreReservaRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return ['saida_id' => ['required', 'exists:saidas,id'], 'nome_cliente' => ['required', 'string', 'max:160'], 'telefone' => ['required', 'string', 'max:30'], 'pessoas' => ['required', 'integer', 'min:1', 'max:15']]; }
}
