<?php

namespace App\Http\Controllers;

use App\Models\Carne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarneController extends Controller
{
    public function criarCarne(Request $request)
    {
        // Validar a requisição
        $validator = Validator::make($request->all(), [
            'valor_total' => 'required|numeric|min:0',
            'qtd_parcelas' => 'required|integer|min:1',
            'data_primeiro_vencimento' => 'required|date',
            'periodicidade' => 'required|in:mensal,semanal',
            'valor_entrada' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Criar o carnê
        $carne = Carne::create($request->all());

        // Gerar as parcelas
        $parcelas = $this->gerarParcelas($carne);

        return response()->json([
            'total' => $carne->valor_total,
            'valor_entrada' => $carne->valor_entrada,
            'parcelas' => $parcelas
        ]);
    }

    private function gerarParcelas($carne)
    {
        $parcelas = [];
        $total_entrada = 0;

        // Adicionar parcela de entrada, se houver
        if ($carne->valor_entrada > 0) {
            $parcelas[] = [
                'entrada' => true,
                'parcela' => 1,
                'valor' => $carne->valor_entrada,
                'data_vencimento' => $carne->data_primeiro_vencimento,
            ];
            $total_entrada = $carne->valor_entrada;
        }

        $valor_restante = $carne->valor_total - $total_entrada;
        $valor_parcela = $valor_restante / $carne->qtd_parcelas;

        // Ajuste a periodicidade
        $interval = $carne->periodicidade === 'mensal' ? 'P1M' : 'P7D';

        $data_vencimento = new \DateTime($carne->data_primeiro_vencimento);

        // Se houver entrada, a primeira parcela regular será no próximo período após a entrada
        if ($carne->valor_entrada > 0) {
            $data_vencimento->add(new \DateInterval($interval));
        }

        // Gerar parcelas
        $numero_parcela = 1 + ($carne->valor_entrada > 0 ? 1 : 0);
        for ($i = 0; $i < $carne->qtd_parcelas; $i++) {
            $parcelas[] = [
                'entrada' => false,
                'parcela' => $numero_parcela++,
                'valor' => round($valor_parcela, 2),
                'data_vencimento' => $data_vencimento->format('Y-m-d'),
            ];
            $data_vencimento->add(new \DateInterval($interval));
        }

        return $parcelas;
    }

    
    public function recuperarParcelas($id)
    {
        $carne = Carne::find($id);

        if (!$carne) {
            return response()->json(['error' => 'Carnê não encontrado.'], 404);
        }

        // Gerar as parcelas
        $parcelas = $this->gerarParcelas($carne);

        return response()->json([
            'parcelas' => $parcelas
        ]);
    }
}
