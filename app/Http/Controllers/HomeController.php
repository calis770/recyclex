<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Ensure the Product model is imported

class HomeController extends Controller
{
    /**
     * Display the customer homepage with a paginated list of products.
     * Products are ordered by creation date in descending order (newest first).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch products from the database, ordered by creation date (newest first)
        // and paginate them with 12 items per page.
        $products = Product::orderBy('created_at', 'desc')->paginate(12);

        // Return the 'homepage' view, passing the paginated products data.
        return view('homepage', compact('products'));
    }

    /**
     * Filter products based on a specified category and display them on the homepage.
     * Products are ordered by creation date in descending order.
     *
     * @param  string  $category The category to filter products by.
     * @return \Illuminate\View\View
     */
    public function filterByCategory($category)
    {
        // Filter products where the 'category' column matches the given $category.
        // Order by creation date (newest first) and paginate.
        $products = Product::where('category', $category)
                            ->orderBy('created_at', 'desc')
                            ->paginate(12);

        // Return the 'homepage' view, passing the paginated products data.
        return view('homepage', compact('products'));
    }

    /**
     * Search for products based on product name, category, or UMKM name.
     * Displays results on the homepage with pagination.
     *
     * @param  \Illuminate\Http\Request  $request The incoming request containing the search query.
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        // Retrieve the search query from the request.
        $query = $request->get('search');

        // Build the query to search across product_name, category, and umkm fields.
        // The 'LIKE' operator with '%' wildcards allows for partial matches.
        // Products are ordered by creation date (newest first) and paginated.
        $products = Product::where('product_name', 'LIKE', "%{$query}%")
                            ->orWhere('category', 'LIKE', "%{$query}%")
                            ->orWhere('umkm', 'LIKE', "%{$query}%")
                            ->orderBy('created_at', 'desc')
                            ->paginate(12);

        // Return the 'homepage' view, passing both the paginated products
        // and the original search query (useful for re-populating the search bar).
        return view('homepage', compact('products', 'query'));
    }
}