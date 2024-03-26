<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Builder;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'productId' => 'required',
                'quantity' => 'required',
            ]);

            $user = Auth::user();
            $product = Product::where('id', $request->productId)->firstOrFail();

            $amount = $user['wallet'] - ($request->quantity * $product['price']);

            $user->update([
                "wallet" => $amount
            ]);

            $request = ModelsRequest::create([
                'quantity' => $request->quantity,
                'product_id' => $request->productId,
                'user_id' => $user['id']
            ]);

            return response()->json(['request' => $request, 'message' => 'Compra realizada com sucesso'], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Erro na compra.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha de conexão com o banco de dados', 'error' => $e->getMessage()]);
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getRequestsByUser(){
        try {
            $user = Auth::user();
            $requests = ModelsRequest::where('user_id', $user->id)->with(['product', 'product.store'])->get();

            return response()->json([
                'requests' => $requests
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }
    }

    public function getRequestsByStore(string $id){
        try {
            $store = Store::where('id', $id)->firstOrFail();

            $productIds = $store->products->pluck('id');

            // Encontrar os pedidos que contenham produtos vendidos por essa loja
            $requests = ModelsRequest::whereHas('product', function (Builder $query) use ($productIds) {
                $query->whereIn('id', $productIds);
            })->with('product')->with('user')->get();

            return response()->json([
                'requests' => $requests
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }
    }
}
