<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Reservation;
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

    public function listReservationsAdmin()
    {
        $reservationsWithName = Reservation::with('user')->get();
    
        $reservations = $reservationsWithName->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'user_id' => $reservation->user_id,
                'user_name' => $reservation->user->name,
                'date' => $reservation->date,
                'time' => $reservation->time,
                'remarks' => $reservation->remarks,
                'num_people' => $reservation->num_people,
                'isConfirmed' => $reservation->is_confirmed
            ];
        });

        return Inertia::render('Admin/AdminListReservations', [
            'reservations' => $reservations
        ]);
    }    

    public function confirmReservationsAdmin($id)
    {
        try {
            $reservations = Reservation::findOrFail($id);
            $reservations->update(['is_confirmed' => 1]);

            return redirect()->back()->with('success', 'Reserva confirmada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao confirmar a reserva.');
        }
    }

    public function undoConfirmReservationAdmin($id)
    {
        try {
            $reservations = Reservation::findOrFail($id);
            $reservations->update(['is_confirmed' => 0]);

            return redirect()->back()->with('success', 'Reserva Desfeita com sucesso');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao desfazer a reserva.');
        }
    }

    public function deleteReservationsAdmin($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
    
        return redirect()->back()->with('success', 'A reserva foi excluída com sucesso.');
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