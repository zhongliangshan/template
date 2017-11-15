@extends('layouts.auth')
@section('content')
<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="POST" action="{{ url('/login') }}">
                    {{csrf_field()}}
                    <h1>Login</h1>
                    <div class="form-group has-feedback">
                        <input type="{{config('admin.globals.login-input-type')}}" class="form-control {{ $errors->has(config('admin.globals.username')) ? ' parsley-error' : '' }}"
                               placeholder="{{config('admin.globals.username')}}" name="{{config('admin.globals.username')}}" value="{{old(config('admin.globals.username'))}}"/>
                        <span class="glyphicon {{config('admin.globals.glyphicon-user')}} form-control-feedback"></span>
                    @if($errors->has(config('admin.globals.username')))
                            <p class="text-danger text-left"><strong>{{$errors->first(config('admin.globals.username'))}}</strong></p>
                        @endif
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control {{ $errors->has('password') ? ' parsley-error' : '' }}"
                               placeholder="Password" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if($errors->has('password'))
                            <p class="text-danger text-left"><strong>{{$errors->first('password')}}</strong></p>
                        @endif
                    </div>
                    <div class="checkbox icheck">
                        <label class="pull-left">
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                    <div class="clearfix"></div>
                    <br/>
                    <div>
                        <button class="btn btn-primary submit" type="submit">Log in</button>
                        <a class="reset_pass" href="{{url('/password/reset')}}">Lost your password?</a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <p class="change_link">New to site?
                            <a href="{{url('/register')}}" class="to_register"> Create Account </a>
                        </p>

                        <div class="clearfix"></div>
                        <br/>

                        <div>
                            <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                            <p>©2016 All Rights Reserved. </p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@stop

