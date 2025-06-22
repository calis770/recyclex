<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; // Already imported, good!

class ProductController extends Controller
{
    /**
     * Display a listing of the products for the admin panel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch products with pagination for better performance on large datasets.
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validate incoming request data
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'sold' => 'nullable|integer|min:0',
            'image_product' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'description' => 'nullable|string',
            'variasi' => 'nullable|string|max:255', // Added max length
            'category' => 'nullable|string|max:100',
            'umkm' => 'nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.index')
                ->withErrors($validator)
                ->withInput(); // Keep old input in the form
        }

        // 2. Generate unique product_id
        // Ensure uniqueness for the generated ID before assigning
        do {
            $product_id = 'P' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Product::where('product_id', $product_id)->exists());


        // 3. Handle image upload
        $imagePath = null;
        if ($request->hasFile('image_product')) {
            $imagePath = $request->file('image_product')->store('products', 'public');
        }

        // 4. Prepare product data for creation
        $productData = [
            'product_id' => $product_id,
            'product_name' => $request->input('product_name'),
            'price' => $request->input('price'),
            'rating' => $request->input('rating'),
            'image_product' => $imagePath,
            'sold' => $request->input('sold') ?? 0, // Default to 0 if not provided
            'description' => $request->input('description'),
            'variasi' => $request->input('variasi'),
            'category' => $request->input('category'),
            'umkm' => $request->input('umkm'),
        ];

        // 5. Create the product
        Product::create($productData);

        // 6. Redirect with success message
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!'); // Use exclamation mark for enthusiasm
    }

    /**
     * Display the specified product.
     * This method is for showing product details in the admin panel.
     *
     * @param  string  $id The product_id of the product to display.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(string $id)
    {
        try {
            // Find the product by product_id or throw 404 exception.
            $product = Product::where('product_id', $id)->firstOrFail();
            return view('products.show', compact('product'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { // Catch specific exception
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak ditemukan.');
        } catch (\Exception $e) { // Catch any other general exceptions
            // Log the error for debugging
            \Log::error("Error showing product {$id}: " . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'Terjadi kesalahan saat menampilkan produk.');
        }
    }

    public function showProductCust(string $id)
    {
        try {
            // Find the product by product_id or throw 404 exception.
            $product = Product::where('product_id', $id)->firstOrFail();
            return view('productdetail', compact('product'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { // Catch specific exception
            return redirect()->route('productdetail')
                ->with('error', 'Produk tidak ditemukan.');
        } catch (\Exception $e) { // Catch any other general exceptions
            // Log the error for debugging
            \Log::error("Error showing product {$id}: " . $e->getMessage());
            return redirect()->route('productdetail')
                ->with('error', 'Terjadi kesalahan saat menampilkan produk.');
        }
    }

    /**
     * Show the form for editing the specified product.
     * This method is for displaying the edit form in the admin panel.
     *
     * @param  string  $id The product_id of the product to edit.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(string $id)
    {
        try {
            // Find the product by product_id or throw 404 exception.
            $product = Product::where('product_id', $id)->firstOrFail();
            return view('products.edit', compact('product'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { // Catch specific exception
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak ditemukan.');
        } catch (\Exception $e) { // Catch any other general exceptions
            \Log::error("Error showing edit form for product {$id}: " . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'Terjadi kesalahan saat memuat formulir edit produk.');
        }
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id The product_id of the product to update.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the product first
            $product = Product::where('product_id', $id)->firstOrFail();

            // 1. Validate incoming request data
            $validator = Validator::make($request->all(), [
                'product_name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'rating' => 'nullable|numeric|min:0|max:5',
                'sold' => 'nullable|integer|min:0',
                'image_product' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'variasi' => 'nullable|string|max:255', // Added max length
                'category' => 'nullable|string|max:100', // Added for update
                'umkm' => 'nullable|string|max:100' // Added for update
            ]);

            if ($validator->fails()) {
                // If validation fails, redirect back to the edit page with errors
                return redirect()->route('products.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }

            // 2. Handle image update
            $imagePath = $product->image_product; // Keep existing path by default
            if ($request->hasFile('image_product')) {
                // Delete old image if it exists
                if ($product->image_product) {
                    Storage::disk('public')->delete($product->image_product);
                }
                // Store new image
                $imagePath = $request->file('image_product')->store('products', 'public');
            }

            // 3. Prepare product data for update
            // Use $request->input() to ensure nullable fields are correctly null if not submitted
            $productData = [
                'product_name' => $request->input('product_name'),
                'price' => $request->input('price'),
                'rating' => $request->input('rating'),
                'image_product' => $imagePath,
                'sold' => $request->input('sold') ?? 0, // Default to 0 if not provided
                'description' => $request->input('description'),
                'variasi' => $request->input('variasi'),
                'category' => $request->input('category'), // Ensure category is updated
                'umkm' => $request->input('umkm'), // Ensure UMKM is updated
            ];

            // 4. Update the product
            $product->update($productData);

            // 5. Redirect with success message
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error("Error updating product {$id}: " . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  string  $id The product_id of the product to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            // Find the product first
            $product = Product::where('product_id', $id)->firstOrFail();

            // Delete product image if it exists
            if ($product->image_product) {
                Storage::disk('public')->delete($product->image_product);
            }

            // Delete the product record from the database
            $product->delete();

            // Redirect with success message
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error("Error deleting product {$id}: " . $e->getMessage());
            return redirect()->route('products.index')
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}