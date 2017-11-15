@extends('layouts.auth')
@section('content')
<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="POST" action="{{ url('/password/email') }}">
                    {{csrf_field()}}
                    <h1>Reset Password</h1>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}"
                               placeholder="Email" name="email" value="{{old('email')}}"/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if($errors->has('email'))
                            <p class="text-danger text-left"><strong>{{$errors->first('email')}}</strong></p>
                        @endif
                    </div>

                    <div class="clearfix"></div>

                    <div>
                        <button class="btn btn-primary submit"> <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link</button>
                    </div>
                    <br/>
                    <a class="reset_pass" href="{{url('/login')}}">Log in?</a>
                    <div class="clearfix"></div>
                    <div class="separator">
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

