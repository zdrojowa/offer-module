@extends('DashboardModule::base')

@section('title','Dashboard: Cinvenience sort')

@section('stylesheets')
    <link rel="stylesheet" href="{{ mix('vendor/css/OfferModule.css','') }}">
@endsection

@section('sidebar')
    @include('DashboardModule::sidebar.index', ['menu' => Selene\Support\Facades\MenuRepository::getPresences()])
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="app">
                    <div class="card-header clearfix">
                        <h4 class="card-title float-left">Sortuj Udogodnienia</h4>
                        <a href="{{route('OfferModule::conveniences')}}" class="btn btn-primary float-right">
                            <i class="mdi mdi-keyboard-backspace"></i> Do listy
                        </a>
                    </div>
                    <div class="card-body">
                        <list name="offers-conveniences">
                            {{ csrf_field() }}
                        </list>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
    @parent
    @javascript('csrf', csrf_token())
    <script src="{{ mix('vendor/js/OfferModule.js') }}"></script>
@endsection
