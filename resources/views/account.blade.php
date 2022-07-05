@extends('layouts.body')

@section('title', 'Account')

@section('content')
    <section>
        <div class="wrapper">
            <h2>Account</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="user-info-block">
                <div class="uinfo-block">
                    <div class="uinfo-line">
                        <div class="uimage-block">
                            @if($user->photo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url("public/user_photos/".$user->photo) }}" alt="">
                            @else
                                <img src="{{ \Illuminate\Support\Facades\Storage::url("public/user_photos/no-image.png") }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="uinfo-line">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="uinfo-line">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                </div>

                <div class="edit-user-block">
                    <form action="{{ route("account.edit") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h2>Update Account</h2>

                        <div class="input-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}">
                            @if($errors->has('name'))
                                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}">
                            @if($errors->has('email'))
                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="input-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" value="{{ $user->phone }}">
                            @if($errors->has('phone'))
                                <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="input-group">
                            <label for="position_id">Position</label>
                            <select name="position_id" id="position_id">
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" @if($position->id == $user->position_id) selected @endif>{{ $position->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('phone'))
                                <div class="alert alert-danger">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="input-group">
                            <label for="photo">Photo</label>
                            <input type="file" id="photo" name="photo">
                            @if($errors->has('photo'))
                                <div class="alert alert-danger">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <button type="submit">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
