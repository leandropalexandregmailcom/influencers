<?php

namespace App\Http\Controllers;

use App\Models\Influencer;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Resources\InfluencerResource;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Insira seu token Bearer para autenticação"
 * )
 * @OA\Tag(name="Influencer", description="Influencer management")
 *
 * 
 * @OA\Schema(
 *     schema="Influencer",
 *     type="object",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="followers", type="integer", example=10000),
 *     @OA\Property(property="platform", type="string", example="Instagram")
 * )
 */

class InfluencerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/influencers",
     *     summary="List all influencers",
     *     tags={"Influencers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of influencers",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Influencer")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index()
    {
        return InfluencerResource::collection(Influencer::all());
    }

    /**
     * @OA\Post(
     *     path="/api/influencers",
     *     summary="Create a new influencer",
     *     tags={"Influencers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "instagram_handle"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="instagram_handle", type="string", example="@johndoe"),
     *             @OA\Property(property="followers_count", type="integer", example=10000),
     *             @OA\Property(property="category_id", type="integer", example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Influencer created",
     *         @OA\JsonContent(ref="#/components/schemas/Influencer")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'instagram_handle' => 'required|string|max:255',
            'followers_count' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $influencer = Influencer::create($request->all());
        return new InfluencerResource($influencer);
    }

    /**
     * @OA\Get(
     *     path="/api/influencers/{id}",
     *     summary="Get a specific influencer",
     *     tags={"Influencers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Influencer details",
     *         @OA\JsonContent(ref="#/components/schemas/Influencer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Influencer not found"
     *     )
     * )
     */
    public function show($id)
    {
        $influencer = Influencer::find($id);
        if (!$influencer) {
            return response()->json(['message' => 'Influencer not found'], 404);
        }
        return new InfluencerResource($influencer);
    }

    /**
     * @OA\Put(
     *     path="/api/influencers/{id}",
     *     summary="Update an influencer",
     *     tags={"Influencers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "instagram_handle"},
     *             @OA\Property(property="name", type="string", example="Updated Name"),
     *             @OA\Property(property="instagram_handle", type="string", example="@updatedhandle"),
     *             @OA\Property(property="followers_count", type="integer", example=12000),
     *             @OA\Property(property="category_id", type="integer", example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Influencer updated",
     *         @OA\JsonContent(ref="#/components/schemas/Influencer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Influencer not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $influencer = Influencer::find($id);
        if (!$influencer) {
            return response()->json(['message' => 'Influencer not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'instagram_handle' => 'required|string|max:255',
            'followers_count' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $influencer->update($request->all());
        return new InfluencerResource($influencer);
    }

    /**
     * @OA\Delete(
     *     path="/api/influencers/{id}",
     *     summary="Delete an influencer",
     *     tags={"Influencers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Influencer deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Influencer not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $influencer = Influencer::find($id);
        if (!$influencer) {
            return response()->json(['message' => 'Influencer not found'], 404);
        }
        $influencer->delete();
        return response()->json(null, 204);
    }
}
