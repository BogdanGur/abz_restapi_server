@extends('layouts.body')

@section('title', 'Register')

@section('content')
    <section class="login-section">
        <div class="wrapper">
            <form action="{{ route("register") }}" method="POST">
                @csrf
                <h2>Register</h2>

                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name">
                    @if($errors->has('name'))
                        <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                    @if($errors->has('email'))
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone">
                    @if($errors->has('phone'))
                        <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                    @endif
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password"  id="password" name="password">
                    @if($errors->has('password'))
                        <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="input-group">
                    <label for="confirm-pass">Confirm Password</label>
                    <input type="password" id="confirm-pass" name="password_confirmation">
                </div>
                <button type="submit">Send</button>
            </form>
        </div>
    </section>
@endsection

