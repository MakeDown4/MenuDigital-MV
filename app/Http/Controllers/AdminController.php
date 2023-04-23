<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Http\Request;
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
        $menuItems = MenuItem::with('category')->get();

        $allCategories = MenuCategory::all();

        // Retorna a view Inertia com os itens do cardápio
        return Inertia::render('Admin/AdminCrud', [
            'menuItems' => $menuItems,
            'allCategories' => $allCategories
        ]);
    }

    public function createMenuItem()
    {
        // Recupera todas as categorias de menu do banco de dados
        $menuCategories = MenuCategory::all();

        // Retorna a view Inertia para criar um novo item do cardápio
        return Inertia::render('Admin/AdminCrud', [
            'menuCategories' => $menuCategories
        ]);
    }
    
    public function storeMenuItem(Request $request)
    {
        // Valida os dados do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'upload_img' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:menu_categories,id',
        ]);
        
        // Cria um novo item do cardápio com os dados validados
        $menuItem = MenuItem::create($validatedData);
        
        // Redireciona o usuário de volta para a lista de itens do cardápio
        return redirect()->route('admin.menuItems.index')->with('success', 'Item do cardápio criado com sucesso!');
    }

    public function editMenuItem($id)
    {
        // Recupera o item do cardápio com o ID fornecido do banco de dados
        $editMenuItem = MenuItem::findOrFail($id);

        // Recupera todas as categorias de menu do banco de dados
        $menuCategories = MenuCategory::all();

        // Retorna a view Inertia para editar o item do cardápio
        return Inertia::render('Admin/MenuItems/Edit', [
            'menuItem' => $editMenuItem,
            'menuCategories' => $menuCategories
        ]);
    }

    public function updateMenuItem(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'upload_img' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:menu_categories,id'
        ]);

        $updateMmenuItem = MenuItem::findOrFail($id);

        $updateMmenuItem->update($validatedData);

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