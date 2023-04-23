<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Verifica se o usuário é um admin
        if ($request->user()->is_admin) {
            // Retorna a view do dashboard do admin
            return view('admin.dashboard');
        } else {
            // Retorna um erro ou redireciona para uma página de erro
            abort(403, 'Acesso negado. Você não tem permissão para acessar esta página.');
        }
    }
    public function listUsers()
    {
    // Recupera todos os usuários do banco de dados
    $users = User::all();

    // Retorna a view Inertia com os usuários
    return Inertia::render('Admin/ListUsers', [
        'users' => $users
        ]);
    }

    public function listMenuItems()
    {
        // Recupera todos os itens do cardápio do banco de dados
        $menuItems = MenuItem::with('category')->orderBy('id', 'desc')->get();

        $allCategories = MenuCategory::all();

        // Retorna a view Inertia com os itens do cardápio
        return Inertia::render('Admin/AdminCrud', [
            'menuItems' => $menuItems,
            'allCategories' => $allCategories
        ]);
    }

    public function createMenuItem(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'file' => 'nullable|image|max:4096',
            'category_id' => 'required|exists:menu_categories,id',
        ]);

        $storagePath = Storage::disk('local')->put('/menuImg', $validatedData['file']);

        $data = array_merge($validatedData, ['upload_img' => $validatedData['file']->getClientOriginalName()]);

        $menuItem = MenuItem::create($data);

        // Redireciona o usuário de volta para a lista de itens do cardápio
        return redirect()->route('admin.menuItems.index')->with('success', 'Item do cardápio criado com sucesso!');
    } 

    public function updateMenuItem(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'numeric|min:0',
            'file' => 'nullable|image|max:4096',
            'category_id' => 'exists:menu_categories,id'
        ]);

        $storagePath = Storage::disk('local')->put('/menuImg', $validatedData['file']);

        $data = array_merge($validatedData, ['upload_img' => $validatedData['file']->getClientOriginalName()]);

        $updateMmenuItem = MenuItem::findOrFail($id);

        $updateMmenuItem->update($data);

        return to_route('admin.menuItems.index')->with('success', 'Item do cardápio atualizado com sucesso!');
    }

    public function deleteMenuItem($id)
    {

        $deleteMenuItem = MenuItem::findOrFail($id);

        $deleteMenuItem->delete();
    
        // Redireciona o usuário de volta para a lista de itens do cardápio
        return to_route('admin.menuItems.index')->with('success', 'Item do cardápio excluído com sucesso!');
    }
}