@extends('layouts.body')

@section('title', 'Login')

@section('content')
    <section class="login-section">
        <div class="wrapper">
            <form action="{{ route("login") }}" method="POST">
                @csrf
                <h2>Login</h2>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password"  id="password" name="password">
                </div>
                <div class="input-group">
                    <label for="remember_me">Запомнить меня</label>
                    <input type="checkbox" id="remember_me" name="remember_me">
                </div>
                <button type="submit">Send</button>
            </form>
        </div>
    </section>
@endsection
