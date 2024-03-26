<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category_Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * product a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
                'store_id' => 'required',
            ]);

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'store_id' => $request->store_id,
            ]);

            foreach ($request->categories as $category) {
                Category_Product::create([
                    'category_id' => $category,
                    'product_id' => $product['id']
                ]);
            }

            return response()->json(['product' => $product, 'message' => 'Produto criada com sucesso'], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Erro ao criar produto.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha de conexão com o banco de dados', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::where('id', $id)->with('categories')->with('store')->first();

            return response()->json(['product' => $product], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Erro ao pegar o produto.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha de conexão com o banco de dados', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
            ]);

            $product = Product::where('id', $request->id)->firstOrFail();
            
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            $product->category_product()->where('product_id', $product['id'])->delete();
            
            foreach ($request->categories as $category) {
                Category_Product::create([
                    'category_id' => $category,
                    'product_id' => $product['id']
                ]);
            }

            return response()->json([
                'product' => $product, 
                'message' => 'Produto criado com sucesso'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Erro ao criar produto.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha de conexão com o banco de dados', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::where('id', $id)->firstOrFail();
            $product->categories()->detach(); 
            $product->delete();

            return response()->json(['message' => 'Produto deletado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Produto não encontrada.', 'error' => $e->getMessage()]);
        }
    }

    public function getProductsCheap(){
        $cheapestProducts = Product::orderBy('price', 'asc')->take(4)->with('categories')->with('store')->get();

        return response()->json([
            'products_cheap' => $cheapestProducts
        ]);
    }

    public function getProductsAll(){
        $products = Product::with('categories')->with('store')->with('categories')->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function getProductsBySearch(string $searchTerm){
        $products = Product::with('categories')->with('store')
        ->where('name', 'like', '%' . $searchTerm . '%')
        ->orWhereHas('categories', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        })
        ->orWhereHas('store', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        })
        ->get();
        
        return response()->json([
            'products' => $products
        ]);
    }

    public function getProductsByStore(string $id){
        $products = Product::where('store_id', $id)->with('categories')->get();

        return response()->json([
            'products' => $products
        ]);
    }
}
