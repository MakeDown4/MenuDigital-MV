<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Inertia\Inertia;


class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('category')->get();

        return Inertia::render('MenuItems/Index', [
            'menuItems' => $menuItems,
        ]);
    }
}