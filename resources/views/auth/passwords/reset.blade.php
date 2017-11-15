@extends('layouts.auth')
@section('content')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form method="POST" action="{{ url('/password/reset')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="token" value="{{ $token }}">

                        <h1>Reset Password</h1>

                        <div class="form-group has-feedback">
                            <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}"
                                   placeholder="Email" name="email" value="{{old('email')}}" />
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            @if($errors->has('email'))
                                <p class="text-danger text-left"><strong>{{$errors->first('email')}}</strong></p>
                            @endif
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password"
                                   class="form-control {{ $errors->has('password') ? ' has-error' : '' }}"
                                   placeholder="Password" name="password" />
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            @if($errors->has('password'))
                                <p class="text-danger text-left"><strong>{{$errors->first('password')}}</strong></p>
                            @endif
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password"
                                   class="form-control {{ $errors->has('password_confirmation') ? ' has-error' : '' }}"
                                   placeholder="Confirm Password" name="password_confirmation" />
                            <span class="glyphicon glyphicon-repeat form-control-feedback"></span>
                            @if($errors->has('password_confirmation'))
                                <p class="text-danger text-left">
                                    <strong>{{$errors->first('password_confirmation')}}</strong></p>
                            @endif
                        </div>

                        <div>
                            <button class="btn btn-default submit" type="submit">Submit</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@stop
