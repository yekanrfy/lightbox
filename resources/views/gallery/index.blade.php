@extends('layouts.app')
@extends('auth.layouts')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $menu }}</title>
    
    <!-- Menambahkan link CSS Lightbox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

</head>
<body>
    <h1>{{ $menu }}</h1>

    @if(count($galleries) > 0)
        <div class="gallery">
            @foreach($galleries as $gallery)
                <div class="gallery-item position-relative" style="display: inline-block; margin: 10px;">
                    <h3>{{ $gallery->title }}</h3>
                    <p>{{ $gallery->description }}</p>
                    
                    <!-- Gambar dengan link dan efek lightbox -->
                    <a class="example-image-link" href="{{ asset('storage/posts_image/' . $gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                        <img src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="{{ $gallery->title }}" class="gallery-item">
                    </a>
                    
                    <!-- Tombol Edit dan Delete -->
                    <div class="button-container">
                        <a href="{{ route('gallery.edit', ['id' => $gallery->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('gallery.delete', ['id' => $gallery->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No gallery items found.</p>
    @endif

    <!-- Menambahkan script JavaScript Lightbox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</body>
</html>
@endsection
