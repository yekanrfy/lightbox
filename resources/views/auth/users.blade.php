@extends('auth.layouts')

@section('content')
<h2>List of Users</h2>
<table>
    <thead>
        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Photo</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" width="100px">
                @else
                    <img src="{{ asset('noimage.jpg') }}" width="100px">
                @endif
            </td>
            <td>
                <!-- Tombol Edit -->
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @method('DELETE')
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
