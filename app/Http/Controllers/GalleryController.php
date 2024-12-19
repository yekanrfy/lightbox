<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Picture; 
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
{
    return view('gallery.create');
}

    public function index()
{
    $data = [
        'id' => "posts",
        'menu' => 'Gallery',
        'galleries' => Post::where('picture', '!=', '')
                          ->whereNotNull('picture')
                          ->orderBy('created_at', 'desc')
                          ->paginate(30)
    ];

    return view('gallery.index')->with($data);
}


    /**
     * Show the form for editing the specified resource.
     */
    // GalleryController.php
// GalleryController.php

// GalleryController.php
public function edit(string $id) {
    $gallery = Post::find($id);

    if (!$gallery) {
        return redirect('gallery')->with('error', 'Data tidak ditemukan');
    }

    return view('gallery.edit', compact('gallery'));
}

public function update(Request $request, string $id) {
    $gallery = Post::find($id);

    if (!$gallery) {
        return redirect('gallery')->with('error', 'Data tidak ditemukan');
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    // Update data pengguna
    $gallery->title = $request->title;
    $gallery->description = $request->description;

    // Jika ada file foto baru
    if ($request->hasFile('picture')) {
        // Hapus foto lama jika ada
        $oldFile = public_path('storage/post_image/' . $gallery->picture);
        if (File::exists($oldFile)) {
            File::delete($oldFile);
        }

        // Mengambil informasi file asli
        $filenameWithExt = $request->file('picture')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('picture')->getClientOriginalExtension();

        // Membuat nama file sesuai format yang diinginkan
        $basename = uniqid() . time();
        $filenameSimpan = "{$basename}.{$extension}";

        // Simpan file ke direktori storage/app/public/post_image
        $path = $request->fildit
        ('picture')->storeAs('post_image', $filenameSimpan, 'public');
        $path2 = $request->file('picture')->storeAs($filenameSimpan);

        // Update path gambar di database
        $gallery->picture = $path2;
    }

    $gallery->save();

    return redirect('gallery')->with('success', 'Data berhasil diupdate');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input
    $this->validate($request, [
        'title' => 'required|max:255',
        'description' => 'required',
        'picture' => 'image|nullable|max:1999'
    ]);

    // Cek jika ada file yang diupload
    if ($request->hasFile('picture')) {
        // Ambil nama file asli
        $filenameWithExt = $request->file('picture')->getClientOriginalName();
        
        // Ambil nama file tanpa ekstensi
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        // Ambil ekstensi file
        $extension = $request->file('picture')->getClientOriginalExtension();
        
        // Generate nama file unik
        $basename = uniqid() . time();
        
        // Nama file untuk ukuran kecil, medium, dan besar
        $smallFilename = "small_{$basename}.{$extension}";
        $mediumFilename = "medium_{$basename}.{$extension}";
        $largeFilename = "large_{$basename}.{$extension}";
        
        // Nama file yang akan disimpan
        $filenameSimpan = "{$basename}.{$extension}";
        
        // Simpan file ke folder 'posts_image'
        $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
    } else {
        // Jika tidak ada file gambar, gunakan gambar default
        $filenameSimpan = 'noimage.png';
    }

    // Buat objek post baru
    $post = new Post();
    $post->picture = $filenameSimpan;
    $post->title = $request->input('title');
    $post->description = $request->input('description');
    $post->save();

    // Redirect ke halaman gallery dengan pesan sukses
    return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
}
public function delete($id)
{
    // Cari gallery berdasarkan ID
    $gallery = Post::findOrFail($id);

    // Periksa apakah gambar yang terkait dengan gallery ada
    if ($gallery->picture && file_exists(public_path('storage/posts_image/' . $gallery->picture))) {
        // Hapus file gambar dari folder penyimpanan
        unlink(public_path('storage/posts_image/' . $gallery->picture));
    }

    // Hapus post (gallery) dari database
    $gallery->delete();

    // Redirect kembali ke halaman gallery dengan pesan sukses
    return redirect()->route('gallery.index')->with('success', 'Gallery item deleted successfully.');
}

}
