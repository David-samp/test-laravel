@extends('layouts.app', ['breadcrumb' => [ trans('breadcrumb.home') => route('home') ]])

@section('third_party_stylesheets')
    <style>
        .homeBox {
            padding:10px;
            border:solid 3px #f4f6f9;
            color:#FFF !important;
        }
        .homeBox .icon {
            position: absolute;
            bottom:0;
            right:10px;
            font-size:90px;
            transition: all 0.2s ease;
        }
        .linksContainer {
            height:0%;
            position:absolute;
            bottom:10px;
            left:0px;
            width:100%;
            overflow:hidden;
            background-color:#FFF;
            transition: all 0.2s ease;
            text-align:center;

        }
        .linksContainer > a {
            margin-top:30px;
            display:inline-block;
            font-weight:bold;
            margin-right:20px;
        }
        .linksContainer > a:hover {
            text-decoration:underline;
        }
        .linksContainer > a > i {
            margin-right:3px;
        }
        .homeBox:hover .icon {
            bottom: 100%;
            transform: translate(0, 100%);
            font-size:40px;
        }
        .homeBox:hover .linksContainer {
            height:50%;
        }
        .homeBox:hover .inner > p {
            visibility:hidden;
        }

    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-primary font-weight-bold">
                    {{ __('pages/home.hello') }}@if(!is_null(Auth::user()->first_name) && !is_null(Auth::user()->last_name)) {{ucfirst(strtolower(Auth::user()->first_name))}} {{strtoupper(Auth::user()->last_name)}}@endif!
                </div>
            </div>
        </div>
    </div>
</div>


<div id="serviceSelect" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>{{ __('pages/menu.calendar.choicecreatezone') }}</h5>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="chooseServiceList"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">{{ __('buttons.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

