@extends('layouts.master_index')

{{-- TITLE --}}
@section('page_Title', 'TICKETs')

{{--contain--}}
@section('contain')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">門票一覽</h1>
        <p class="lead">一時搶票一時爽，一直搶票一直爽。</p>
        <hr>
    </div>
    <div class="container">
        <div class="card-deck mb-3 text-center">
            @foreach($data as $values)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{$values['tname']}}</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">{{$values['tprice']}}<small
                                class="text-muted">/NTD</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            {!! $values['tcontent'] !!}
                        </ul>
                        <a class="btn btn-outline-primary" data-toggle="tooltip{{$values['tid']}}"
                           href="{{url('/orderQueue/'.$values['tid'])}}">
                            我要訂票
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

