<?php

namespace Selene\Modules\OfferModule\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\DashboardModule\ZdrojowaTable;
use Selene\Modules\OfferModule\Models\Convenience;

class ConvenienceController extends Controller
{
    public function index(Request $request)
    {
        return view('OfferModule::conveniences.list');
    }

    public function sort()
    {
        return view('OfferModule::conveniences.sort');
    }

    public function ajax(Request $request): JsonResponse
    {
        return ZdrojowaTable::response(Convenience::query(), $request);
    }

    public function create()
    {
        return view('OfferModule::conveniences.edit');
    }

    public function edit(Convenience $convenience = null)
    {
        return view('OfferModule::conveniences.edit', ['convenience' => $convenience]);
    }

    public function store(Request $request)
    {
        $convenience = $this->save($request);
        if ($convenience) {
            $request->session()->flash('alert-success', 'Udogodnienie pomyślnie dodano.');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return ['redirect' => route('OfferModule::editConvenience', ['convenience' => $convenience])];
    }

    public function update(Request $request, Convenience $convenience)
    {
        if ($this->save($request, $convenience)) {
            $request->session()->flash('alert-success', 'Udogodnienie zostało pomyślnie zaktualizowano.');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return ['redirect' => route('OfferModule::editConvenience', ['convenience' => $convenience])];
    }

    private function save(Request $request, Convenience $convenience = null) {
        if ($convenience === null) {
            $request->merge(['order' => Convenience::query()->count() + 1]);
            return Convenience::create($request->all());
        }

        $convenience->update($request->all());
        return $convenience;
    }

    public function destroy(Convenience $convenience, Request $request): void
    {
        try {
            $convenience->delete();
            $request->session()->flash('alert-success', 'Udogodnienie usunięto');
        } catch (Exception $e) {
            $request->session()->flash('alert-error', 'Error: ' . $e->getMessage());
        }
    }

    public function saveOrder(Request $request)
    {
        $list = json_decode($request->get('list'), true);
        foreach ($list as $i => $convenience) {
            Convenience::query()->where('_id', '=', $convenience['id'])->update(['order' => $i + 1]);
        }
        return ['redirect' => route('OfferModule::conveniences')];
    }
}
