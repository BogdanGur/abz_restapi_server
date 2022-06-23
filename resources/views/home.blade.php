@extends('layouts.body')

@section('title', 'Home')

@section('content')
    <section class="main">
        <div class="wrapper">
            <div class="all_users">
                <div class="users_load_block">
                    @foreach($users as $user)
                        <div class="user_block">
                            <div class="user_photo">
                                @if($user->photo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url('public/user_photos/'.$user->photo) }}" alt="">
                                @else
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url('public/user_photos/no-image.png') }}" alt="">
                                @endif
                            </div>
                            <div class="user_info">
                                <ul>
                                    <li><strong>Name:</strong> {{ $user->name }}</li>
                                    <li><strong>Email:</strong> {{ $user->email }}</li>
                                    <li><strong>Phone:</strong> {{ $user->phone }}</li>
                                    <li><strong>Position:</strong> {{ $user->position->name }}</li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="load_more-btn">Load More</button>
            </div>
        </div>
    </section>
@endsection
