<?php

namespace Selene\Modules\OfferModule\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\OfferModule\Models\Offer;

class ApiController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        $offers = Offer::query()->orderBy('updated_at');

        if ($request->has('id')) {
            $offers->where('_id', '=', $request->get('id'));
            return response()->json($offers->first());
        }

        if ($request->has('per_page')) {
            return response()->json(
                $offers->paginate(
                    $request->get('per_page') >> 0,
                    ['*'],
                    'page',
                    $request->get('page', 1)
                )
            );
        }

        return response()->json($offers->get());
    }

    public function getActive(): JsonResponse
    {
        return response()->json(
            Offer::query()
                ->where('status', '=', 'public')
                ->where(function ($query) {
                    return $query
                        ->whereNull('date_to')
                        ->orWhere('date_to', '<', Carbon::tomorrow()->toDateTimeLocalString());
                })
                ->orderBy('order')
                ->get()
        );
    }
}
