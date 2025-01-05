<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Retrieve a list of all products with optional pagination.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

public function getAllProducts(Request $request)
{
    // Set default pagination values
    $perPage = $request->query('perPage', 10); // Default to 10 products per page

    try {
        // Fetch products with pagination
        $products = Product::paginate($perPage);

        // Return paginated products in JSON format
        return response()->json([
            'products' => $products->items(), // Return products in 'products' field
            'totalPages' => $products->lastPage(), // Return totalPages field
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to fetch products. Please try again later.',
            'error' => $e->getMessage()
        ], 500);
    }
    
    }
}
