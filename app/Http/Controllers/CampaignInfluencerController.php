<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Influencer;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="CampaignInfluencer",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 * )
 */

class CampaignInfluencerController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/campaigns/{campaign_id}/influencers",
     *     summary="Attach influencer to a campaign",
     *     tags={"Campaign Influencer"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="campaign_id",
     *         in="path",
     *         required=true,
     *         description="ID of the campaign",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="influencer_id",
     *         in="query",
     *         required=true,
     *         description="ID of the influencer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Influencer successfully added to the campaign",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Influencer added to campaign")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign or Influencer not found"
     *     )
     * )
     */
    public function attachInfluencer(Request $request)
    {
        $campaign = Campaign::findOrFail($request->campaign_id);
        $influencer = Influencer::findOrFail($request->influencer_id);

        $campaign->influencers()->attach($influencer);

        return response()->json(['message' => 'Influencer added to campaign']);
    }

    /**
     * @OA\Get(
     *     path="/api/campaigns/{id}/influencers",
     *     summary="Get all influencers of a campaign",
     *     tags={"Campaign Influencer"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the campaign",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of influencers for the campaign",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Influencer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Campaign not found"
     *     )
     * )
     */
    public function showCampaignInfluencers($id)
    {
        $campaign = Campaign::with('influencers')->findOrFail($id);

        return response()->json($campaign);
    }
}
