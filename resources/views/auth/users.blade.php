@extends('auth.layouts')

@section('content')
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
                <button>Edit</button>
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
