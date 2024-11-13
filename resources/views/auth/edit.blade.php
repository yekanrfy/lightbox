<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gallery</title>
</head>
<body>
    <h3>Edit Image</h3>

    <form action="{{ route('gallery.update', ['id' => $image->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $image->title }}" required>
        </div>

        <div class="form-group">
            <label for="image">Upload New Image</label>
            <input type="file" name="image" class="form-control">
            @if ($image->image)
                <img src="{{ asset('storage/' . $image->image) }}" alt="Current Image" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Image</button>
    </form>

    <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Back to Gallery</a>
</body>
</html>
