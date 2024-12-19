@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Specific Image</h1>

        {{-- Form edit gambar yang dipilih --}}
        @isset($picture) {{-- Pastikan bahwa gambar ada --}}
            <form action="{{ route('gallery.update.image', ['id' => $gallery->id, 'imageIndex' => $imageIndex]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Current Image</label>
                    <img src="{{ asset('posts_image/' . $picture['filename']) }}" alt="Image" class="img-thumbnail" width="200">
                </div>

                <div class="form-group">
                    <label for="picture">Upload New Image</label>
                    <input type="file" class="form-control" id="picture" name="picture">
                </div>

                <div class="form-group">
                    <label for="description">Image Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $picture['description'] ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Image</button>
            </form>
        @endisset
    </div>
@endsection
