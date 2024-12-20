<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\File;
class GalleryController extends Controller
{
     public function index()
    {
        $data = [
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => Gallery::orderBy('created_at', 'desc')->paginate(30),
        ];

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
        // Validasi input
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999',
        ]);

        // Debug input data
        dd($request->all()); // Hapus ini setelah debugging

        // Cek jika ada file yang diupload
        $filenameSimpan = 'noimage.png'; // Default image
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
        }

        // Simpan data ke database
        Gallery::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'picture' => $filenameSimpan,
        ]);

        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $gallery = Gallery::find($id);

    if (!$gallery) {
        return redirect('gallery')->with('error', 'Data tidak ditemukan');
    }

    // Hapus baris ini setelah debugging
    // dd($gallery);

    return view('gallery.edit', compact('gallery'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return redirect('gallery')->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $gallery->title = $request->title;
        $gallery->description = $request->description;


        if ($request->hasFile('picture')) {
            $oldFile = public_path('storage/posts_image/' . $gallery->picture);
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
            $gallery->picture = $filenameSimpan;
        }

        $gallery->save();

        return redirect('gallery')->with('success', 'Data berhasil diupdate');
    }
    public function delete($id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->picture && file_exists(public_path('storage/posts_image/' . $gallery->picture))) {
            unlink(public_path('storage/posts_image/' . $gallery->picture));
        }
        $gallery->delete();
        return redirect()->route('gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}


