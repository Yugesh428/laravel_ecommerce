<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Get all products
    public function index()
    {
        try {
            $getProduct = Product::with('category')->get();
            return response()->json([
                'success' => true,
                'data' => $getProduct
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products',
                'error' => $e->getMessage()
            ]);
        }
    }

    // Create a new product
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id', // must match table name and column
                'description' => 'nullable|string',
                'image' => 'nullable|string',
            ]);

            $createProduct = Product::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $createProduct
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ]);
        }
    }

    // Get a single product
    public function show(string $id)
    {
        try {
            $singleProduct = Product::with('category')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $singleProduct
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'error' => $e->getMessage()
            ]);
        }
    }

    // Update a product
    public function update(Request $request, string $id)
    {
        try {
            $singleProduct = Product::findOrFail($id);

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id', // removed 'uuid' since you are likely using integer ID
                'description' => 'nullable|string',
                'image' => 'nullable|string',
            ]);

            $singleProduct->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $singleProduct
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ]);
        }
    }

    // Delete a product
    public function destroy(string $id)
    {
        try {
            $singleProduct = Product::findOrFail($id);
            $singleProduct->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ]);
        }
    }
}
