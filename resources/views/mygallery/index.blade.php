@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $menu }}</title>
    
    <!-- CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="{{ asset('lightbox2/dist/css/lightbox.min.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">{{ $menu }}</h1>

        @if(count($galleries) > 0)
            <div class="row">
                @foreach($galleries as $gallery)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h3>{{ $gallery->title }}</h3>
                                <p>{{ $gallery->description }}</p>
                                
                                <!-- Gambar utama dengan efek Lightbox -->
                                <a href="{{ asset('storage/posts_image/' . $gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                    <img src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="{{ $gallery->title }}" class="img-fluid mb-3">
                                </a>

                                <!-- Gambar tambahan -->
                                <div class="row">
                                    @foreach($gallery->pictures as $index => $picture)
                                        <div class="col-md-4 mb-3">
                                            <label>Image {{ $index + 1 }}</label>
                                            <a href="{{ asset('storage/posts_image/' . $picture->filename) }}" data-lightbox="roadtrip" data-title="Additional Image {{ $index + 1 }}">
                                                <img src="{{ asset('storage/posts_image/' . $picture->filename) }}" alt="Image" class="img-thumbnail">
                                            </a>

                                            <!-- Tombol Edit untuk setiap gambar -->
                                            <a href="{{ route('gallery.edit.image', ['id' => $gallery->id, 'imageIndex' => $index]) }}" class="btn btn-warning btn-sm mt-2">Edit</a>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Tombol Delete -->
                                <div class="mt-3">
                                    <a href="{{ route('gallery.delete', ['id' => $gallery->id]) }}" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Are you sure you want to delete this item?')">
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No gallery items found.</p>
        @endif
    </div>

    <!-- Lightbox JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</body>
</html>
@endsection
