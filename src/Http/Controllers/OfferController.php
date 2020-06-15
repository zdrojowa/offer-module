<?php

namespace Selene\Modules\OfferModule\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\DashboardModule\ZdrojowaTable;
use Selene\Modules\OfferModule\Models\Offer;
use Selene\Modules\OfferModule\Support\Status;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        return view('OfferModule::list');
    }

    public function sort()
    {
        return view('OfferModule::sort');
    }

    public function ajax(Request $request): JsonResponse
    {
        return ZdrojowaTable::response(Offer::query(), $request);
    }

    public function create()
    {
        return view('OfferModule::edit');
    }

    public function edit(Offer $offer = null)
    {
        return view('OfferModule::edit', ['offer' => $offer]);
    }

    public function store(Request $request)
    {
        $offer = $this->save($request);
        if ($offer) {
            $request->session()->flash('alert-success', 'Oferte pomyślnie dodano.');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return ['redirect' => route('OfferModule::edit', ['offer' => $offer])];
    }

    public function update(Request $request, Offer $offer)
    {
        if ($this->save($request, $offer)) {
            $request->session()->flash('alert-success', 'Oferta została pomyślnie zaktualizowana.');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return ['redirect' => route('OfferModule::edit', ['offer' => $offer])];
    }

    private function save(Request $request, Offer $offer = null) {
        if ($request->has('date_to') && empty($request->get('date_to'))) {
            $request->merge(['date_to' => null]);
        }

        if ($offer === null) {
            $request->merge(['order' => Offer::query()->count() + 1]);
            return Offer::create($request->all());
        }

        if ($request->has('costs')) {
            $request->merge(['costs' => json_decode($request->get('costs'))]);
        }

        if ($request->has('programs')) {
            $request->merge(['programs' => json_decode($request->get('programs'))]);
        }

        if ($request->has('packs')) {
            $request->merge(['packs' => json_decode($request->get('packs'))]);
        }

        if ($request->has('files')) {
            $request->merge(['files' => json_decode($request->get('files'))]);
        }

        if ($request->has('conveniences')) {
            $request->merge(['conveniences' => json_decode($request->get('conveniences'))]);
        }

        if ($request->has('hotels')) {
            $request->merge(['hotels' => array_map(function($item){
                return $item->_id;
            }, json_decode($request->get('hotels')))
            ]);
        }

        $offer->update($request->all());
        return $offer;
    }

    public function destroy(Offer $offer, Request $request): void
    {
        try {
            $offer->delete();
            $request->session()->flash('alert-success', 'Oferta usunięta');
        } catch (Exception $e) {
            $request->session()->flash('alert-error', 'Error: ' . $e->getMessage());
        }
    }

    public function saveOrder(Request $request)
    {
        $list = json_decode($request->get('list'), true);
        foreach ($list as $i => $offer) {
            Offer::query()->where('_id', '=', $offer['id'])->update(['order' => $i + 1]);
        }
        return ['redirect' => route('OfferModule::list')];
    }

    public function statuses(): JsonResponse
    {
        $statuses = [];
        foreach (Status::toArray() as $key => $value) {
            $statuses[] = ['id' => $value, 'name' => $key];
        }
        return response()->json($statuses);
    }
}
