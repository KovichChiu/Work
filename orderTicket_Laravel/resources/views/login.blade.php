@extends('layouts.master_login')

{{-- STYLE --}}
@section('page_Style')
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            Max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
@endsection

{{-- TITLE --}}
@section('page_Title', 'LOGIN')

{{--contain--}}
@section('contain')
    <form class="form-signin" method="POST" action="{{url('/login')}}">
        {{ csrf_field() }}
        <img alt="" class="mb-4" height="72" src="img/favicon.ico" width="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label class="sr-only" for="inputAcc">Account</label>
        <input name="acc" autocomplete="off" autofocus class="form-control" id="inputAcc" placeholder="Account" required
               type="text">
        <label class="sr-only" for="inputpswd">Password</label>
        <input name="pswd" autocomplete="off" class="form-control" id="inputpswd" placeholder="Password" required
               type="password">
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary" type="submit">Sign in</button>
        <a class="btn btn-lg btn-danger" href="{{url('/signup')}}">Sign up</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2019-</p>
    </form>
@endsection
