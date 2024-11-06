@extends('auth.layouts')

@section('content')
<h2>Edit User</h2>

<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <label>Name:</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}">

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}">

    <label>Photo:</label>
    @if($user->photo)
        <img src="{{ asset('storage/' . $user->photo) }}" width="100px" alt="User Photo">
    @else
        <img src="{{ asset('noimage.jpg') }}" width="100px" alt="No Image">
    @endif
    <input type="file" name="photo">

    <button type="submit">Save Changes</button>
</form>

@endsection
