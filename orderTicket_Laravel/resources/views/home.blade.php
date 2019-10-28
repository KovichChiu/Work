@extends('layouts.master_index')

{{-- TITLE --}}
@section('page_Title', 'HOME')

{{--contain--}}
@section('contain')
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3">訂票系統</h1>
            <p>
                第二的時更新年的手機，場的我到笑死睡覺還是，心裡忘卻有多打的把我。但他真的，簡直文章給我對自⋯間尺發的家的你了到爆，之前心情⋯趙七一起一個而且，找我現在嗚嗚還是只是舞台。再看車上但有們的希望。史上做出。得自一張有點下手不知起來那麼：怎麼好一看他用這⋯忘記原來這個也來到的。
            </p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($data as $values)
                <div class="col-md-4">
                    <h3>{{$values['t_name']}}</h3>
                    <ul>
                        {!!$values['t_content']!!}
                    </ul>
                </div>

            @endforeach
        </div>
    </div>
@endsection
