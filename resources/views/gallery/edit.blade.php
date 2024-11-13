@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Gallery Item</h2>
    <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $gallery->title }}">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $gallery->description }}</textarea>
        </div>
        <div class="form-group">
            <label>Picture</label>
            <input type="file" name="picture" class="form-control">
            @if ($gallery->picture)
                <img src="{{ asset('storage/posts_image/' . $gallery->picture) }}" width="150px" class="mt-3" alt="current image">
            @endif
        </div>
        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>
@endsection
