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
    <table cellspacing="0" class="table table-striped table-bordered" id="dt" width="100%">
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
        @foreach(json_decode($data) as $value)
            <tr>
                <td>{{$value->name}}</td>
                <td>{{substr($value->no, 0, 8)}}</td>
                <td>{{date("Y-m-d H:i:s", $value->time)}}</td>
                <td>{{$value->ticketName}}</td>
                <td>{{$value->pics}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

