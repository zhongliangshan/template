@extends('layouts.auth')
@section('content')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form method="POST" action="{{ url('/register')}}">
                        {{csrf_field()}}
                        <h1>Create Account</h1>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}"
                                   placeholder="Name" name="name" value="{{old('name')}}" />
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            @if($errors->has('name'))
                                <p class="text-danger text-left"><strong>{{$errors->first('name')}}</strong></p>
                            @endif
                        </div>
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
                            <p class="change_link">Already a member ?
                                <a href="{{url('/login')}}" class="to_register"> Log in </a>
                            </p>

                            <div class="clearfix"></div>
                            <br/>

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
