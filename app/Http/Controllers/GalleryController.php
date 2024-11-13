<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\User;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=', '')
                ->whereNotNull('picture')
                ->orderBy('created_at', 'desc')
                ->paginate(30)
        );
        
        return view('gallery.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('gallery.create');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $this->validate($request, [
        'title' => 'required|max:255',
        'description' => 'required',
        'picture' => 'image|nullable|max:1999'
    ]);

    if ($request->hasFile('picture')) {
        // Get filename with the extension
        $filenameWithExt = $request->file('picture')->getClientOriginalName();
        
        // Get filename without extension
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        // Get file extension
        $extension = $request->file('picture')->getClientOriginalExtension();
        
        // Create unique filenames for different sizes
        $basename = uniqid() . time();
        $smallFilename = "small_{$basename}.{$extension}";
        $mediumFilename = "medium_{$basename}.{$extension}";
        $largeFilename = "large_{$basename}.{$extension}";
        $filenameSimpan = "{$basename}.{$extension}";

        // Upload the image
        $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
    } else {
        $filenameSimpan = 'noimage.png';
    }

    // Create new post
    $post = new Post;
    $post->picture = $filenameSimpan;
    $post->title = $request->input('title');
    $post->description = $request->input('description');
    $post->save();

    return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $product = Product::findOrFail($id);
    return view('product.edit', compact('product'));
}

public function delete($id)
{
    $product = Product::findOrFail($id);
    $product->delete();
    return redirect()->route('product.index')->with('success', 'Product deleted successfully');
}

public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Cari gambar berdasarkan ID
    $image = Image::findOrFail($id);

    // Update data gambar
    $image->title = $request->input('title');

    // Jika ada gambar baru yang di-upload
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($image->image && file_exists(storage_path('app/public/' . $image->image))) {
            unlink(storage_path('app/public/' . $image->image));
        }

        // Simpan gambar baru
        $filePath = $request->file('image')->store('images', 'public');
        $image->image = $filePath;
    }

    // Simpan perubahan
    $image->save();

    return redirect()->route('gallery.index')->with('success', 'Image updated successfully');
}

public function destroy($id)
{
    $gallery = Post::findOrFail($id);
    
    if ($gallery->picture && $gallery->picture != 'noimage.png') {
        Storage::delete('posts_image/' . $gallery->picture);
    }
    
    $gallery->delete();

    return redirect('gallery')->with('success', 'Data berhasil dihapus');
}

}
