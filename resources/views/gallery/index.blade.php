@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries) > 0)
                        @foreach ($galleries as $gallery)
                            <div class="col-md-3 mb-3"> <!-- Ganti col-md-2 dengan col-md-3 untuk memberi lebih banyak ruang -->
                                <div>
                                    <a class="example-image-link" href="{{ asset('storage/posts_image/' . $gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                        <img class="example-image img-fluid mb-2" src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="{{ $gallery->description }}" />
                                    </a>
                                </div>
                                <div class="mt-2 text-center">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-primary btn-sm mb-2">Edit</a>
                                    
                                    <!-- Tombol Delete -->
                                    <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data.</h3>
                    @endif
                </div>
                <div class="d-flex">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
