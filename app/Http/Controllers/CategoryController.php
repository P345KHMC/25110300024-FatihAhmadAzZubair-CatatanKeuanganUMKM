<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->categories()->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $request->user()->categories()->create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori ditambahkan');
    }

    public function edit(Category $category)
    {
        $this->ensureOwner($category);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->ensureOwner($category);
        $category->update($this->validated($request));

        return redirect()->route('categories.index')->with('success', 'Kategori diperbarui');
    }

    public function destroy(Category $category)
    {
        $this->ensureOwner($category);

        if ($category->transactions()->exists()) {
            return back()->with('error', 'Kategori masih dipakai transaksi, tidak bisa dihapus');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori dihapus');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:income,expense'],
        ]);
    }

    private function ensureOwner(Category $category): void
    {
        abort_if($category->user_id !== Auth::id(), 403);
    }
}
