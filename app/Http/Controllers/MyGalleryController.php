<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\User;

class MyGalleryController extends Controller
{
    public function index()
    {
        $data = [
            'id' => "posts",
            'menu' => 'MyGallery',
            'galleries' => Post::where('picture', '!=', '')
                ->whereNotNull('picture')
                ->orderBy('created_at', 'desc')
                ->paginate(30),
        ];

        return view('mygallery.index')->with($data);
    }

    public function create()
    {
        return view('mygallery.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999',
        ]);

        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $filenameSimpan = uniqid() . '.' . $extension;

            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }

        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return redirect('mygallery')->with('success', 'Berhasil menambahkan data baru');
    }

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->input('title');

        if ($request->hasFile('image')) {
            if ($image->image && file_exists(storage_path('app/public/' . $image->image))) {
                unlink(storage_path('app/public/' . $image->image));
            }

            $filePath = $request->file('image')->store('images', 'public');
            $image->image = $filePath;
        }

        $image->save();

        return redirect()->route('mygallery.index')->with('success', 'Image updated successfully');
    }

    public function destroy($id)
    {
        $gallery = Post::findOrFail($id);

        if ($gallery->picture && $gallery->picture != 'noimage.png') {
            Storage::delete('posts_image/' . $gallery->picture);
        }

        $gallery->delete();

        return redirect('mygallery')->with('success', 'Data berhasil dihapus');
    }
}
