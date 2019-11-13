@extends('layouts.master_index')

{{-- TITLE --}}
@section('page_Title', 'ORDER')

{{--contain--}}
@section('contain')
    @include('layouts.dataTables')
    <h1>
        訂購清單
    </h1>
    <hr>
    <table class="table table-striped table-bordered" style="width:100%" id="dt">
        <thead>
        <tr>
            <th class="th-sm">訂購人</th>
            <th class="th-sm">訂購編號</th>
            <th class="th-sm">訂購時間</th>
            <th class="th-sm">訂購場次</th>
            <th class="th-sm">訂購數量</th>
        </tr>
        </thead>
        <tbody id="dt_content">
        @foreach($data as $value)
            <tr>
                <td>{{ $value->user->uname }}</td>
                <td>{{substr($value->oid, 0, 8)}}</td>
                <td>{{date("Y-m-d H:i:s", $value->otime)}}</td>
                <td>{{$value->ticket->tname}}</td>
                <td>{{$value->opics}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

