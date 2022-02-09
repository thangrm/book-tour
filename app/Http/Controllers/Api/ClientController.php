<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DestinationResource;
use App\Http\Resources\TourCollection;
use App\Http\Resources\TypeResource;
use App\Libraries\Notification;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\Type;
use App\Services\ClientService;
use Exception;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * Api for homepage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(Destination $destination, Type $type, Tour $tour)
    {
        $destinations = DestinationResource::collection($destination->getByStatus(1, 8));
        $types = TypeResource::collection($type->getByStatus(1, 8));
        $trendingTours = new TourCollection($tour->getByTrending(true, 8));
        $latestTours = new TourCollection($tour->getByStatus(1, 8));

        return response()->json([
            'data' => [
                'destination' => $destinations,
                'trending' => $trendingTours->collection,
                'latest' => $latestTours->collection,
                'type' => $types,
            ],
            "success" => true,
        ]);
    }

    /**
     * Store booking
     *
     * @param Request $request
     * @param ClientService $clientService
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBooking(Request $request, ClientService $clientService)
    {
        $rule = $clientService->ruleBooking();
        $rule['tour_id'] = 'required|integer|exists:tours,id';
        $request->validate($rule);
        $tour = Tour::findOrFail($request->tour_id);

        try {
            $clientService->storeBooking($request, $tour);

            return response()->json([
                'message' => 'Successful tour booking',
                "success" => true,
            ]);
        } catch (Exception $e) {

            return response()->json(
                [
                    "success" => false,
                    'error' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode()
                    ]
                ], 500);
        }
    }
}
