<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class StoreController extends Controller
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
                'name' => 'required',
                'description' => 'required',
                'address' => 'required',
            ]);

            $user = Auth::user();
            
            $store = Store::create([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'user_id' => $user->id,
            ]);

            return response()->json(['store' => $store, 'message' => 'Loja criada com sucesso'], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Erro ao criar loja.', 'errors' => $e->errors()], 422);
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
    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'address' => 'required',
            ]);

            $store = Store::where('id', $request->id)->firstOrFail();
            
            $store->update([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
            ]);

            return response()->json([
                'store' => $store, 
                'message' => 'Loja criada com sucesso'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Erro ao criar loja.', 'errors' => $e->errors()], 422);
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
            $store = Store::where('id', $id)->firstOrFail();

            $store->products->each(function ($product) {
                $product->categories()->detach(); // Remove as associações de categoria
            });
    
            // Agora você pode excluir os produtos
            $store->products()->delete();
    
            // Por fim, exclua a própria loja
            $store->delete();

            return response()->json(['message' => 'Loja deletado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Loja não encontrada.', 'error' => $e->getMessage()]);
        }
    }

    public function getStoresByUser()
    {
        try {
            $user = Auth::user();
            $stores = Store::where('user_id', $user->id)->get();
            
            return response()->json([
                'stores' => $stores
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }
    }
}
