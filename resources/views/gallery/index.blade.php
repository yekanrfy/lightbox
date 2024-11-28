<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $menu }}</title>
    <style>
        /* Gaya CSS untuk gambar */
        .gallery-item img {
            width: 150px;  /* Ukuran gambar */
            height: 150px; /* Ukuran gambar */
            object-fit: cover;  /* Menjaga aspek rasio dan memotong gambar yang melebihi ukuran */
            border-radius: 50%;  /* Membuat gambar menjadi lingkaran */
            border: 5px solid #ddd;  /* Memberikan border (frame) di sekitar gambar */
        }
    </style>
</head>
<body>
    <h1>{{ $menu }}</h1>

    @if(count($galleries) > 0)
        <div class="gallery">
            @foreach($galleries as $gallery)
                <div class="gallery-item">
                    <h3>{{ $gallery->title }}</h3>
                    <p>{{ $gallery->description }}</p>
                    <img src="{{ asset($gallery->picture) }}" alt="{{ $gallery->title }}" />
                </div>
            @endforeach
        </div>
    @else
        <p>No gallery items found.</p>
    @endif
</body>
</html>
