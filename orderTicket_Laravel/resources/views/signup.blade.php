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
    <form class="form-signin" method="POST" action="{{url('/signup')}}">
        {{ csrf_field() }}
        <img alt="" class="mb-4" height="72" src="img/favicon.ico" width="72">
        <h1 class="h3 mb-3 font-weight-normal">SIGN UP</h1>
        <label class="sr-only" for="inputName">User Name</label>
        <input name="name" autocomplete="off" autofocus class="form-control" id="inputName" placeholder="Name"
               required="required"
               type="text">
        <br/>
        <label class="sr-only" for="inputAcc">User Account</label>
        <input name="acc" autocomplete="off" class="form-control" id="inputAcc" placeholder="Account"
               required="required" type="text">
        <br/>
        <label class="sr-only" for="inputPswd">Password</label>
        <input name="pswd" autocomplete="off" class="form-control" id="inputPswd" placeholder="Password"
               required="required"
               type="password">
        <br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
        <p class="mt-5 mb-3 text-muted">&copy;2019-</p>
    </form>
@endsection

