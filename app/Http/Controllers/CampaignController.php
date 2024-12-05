<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API Influenciadores",
 *     version="1.0.0",
 *     description="API para gerenciar campanhas",
 *     @OA\Contact(
 *         email="leandro.p.alexandre@gmail.com"
 *     ),
 * )
 */

/**
 * @OA\Schema(
 *     schema="Campaigns",
 *     title="Campaigns",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Campanha de Influência"),
 *     @OA\Property(property="budget", type="number", format="float", example=10000.50),
 *     @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="end_date", type="string", format="date", example="2024-12-31")
 * )
 */

class CampaignController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/campaigns",
     *     summary="Listar todas as campanhas",
     *     description="Retorna uma lista de campanhas",
     *     tags={"Campaign"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de campanhas retornada com sucesso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Campaigns"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro ao buscar campanhas"
     *     )
     * )
     */
    public function index()
    {
        return Campaign::all();
    }

    /**
     * @OA\Post(
     *     path="/api/campaigns",
     *     summary="Criar uma nova campanha",
     *     description="Cria uma nova campanha com os dados fornecidos",
     *     security={{"bearerAuth": {}}},
     *     tags={"Campaign"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","budget","start_date","end_date"},
     *             @OA\Property(property="name", type="string", example="Campanha de Influência"),
     *             @OA\Property(property="budget", type="number", example=10000.50),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-01-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-12-31")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Campanha criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Campaigns")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação dos dados"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'budget' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        return Campaign::create($request->all());
    }
}
