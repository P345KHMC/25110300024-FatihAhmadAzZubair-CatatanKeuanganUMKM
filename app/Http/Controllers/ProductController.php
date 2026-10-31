<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = $request->user()->products()->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->user()->products()->create($this->validated($request));
        
        return redirect()->route('products.index')->with('success', 'Produk ditambahkan');
    }

    public function edit(Product $product)
    {
        $this->ensureOwner($product);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->ensureOwner($product);
        $product->update($this->validated($request));

        return redirect()->route('products.index')->with('success', 'Produk diperbarui');
    }

    public function destroy(Product $product)
    {
        $this->ensureOwner($product);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk dihapus');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);
    }

    private function ensureOwner(Product $product): void
    {
        abort_if($product->user_id !== Auth::id(), 403);
    }
}
