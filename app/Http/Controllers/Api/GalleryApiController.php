<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Post;

class GalleryApiController extends Controller
{
    // Endpoint untuk mengambil data gallery (API)
    public function index()
    {
        // Ambil data gallery yang memiliki gambar
        $galleries = Post::whereNotNull('picture')
                         ->where('picture', '!=', '')
                         ->orderBy('created_at', 'desc')
                         ->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'message' => 'Gallery data fetched successfully',
            'data' => $galleries
        ], 200);
    }

    // Endpoint untuk menampilkan gallery di tampilan biasa
    public function showGalleryPage()
    {
        // Mengambil data dari API gallery
        $response = Http::get('http://localhost:8000/api/gallery');

        // Mengecek apakah response berhasil
        if ($response->successful()) {
            $galleries = $response->json()['data'];
        } else {
            $galleries = [];
        }

        // Menyediakan data untuk view
        $data = array(
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => $galleries
        );

        // Mengarahkan ke view untuk menampilkan gallery
        return view('gallery.index')->with($data);
    }
}
