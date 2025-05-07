<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filtrage par recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filtrage par type (rôle)
        if ($request->has('role') && $request->role != 'Type') {
            $query->where('role', $request->role);
        }
        
        // Filtrage par statut
        if ($request->has('status') && $request->status != 'Statut') {
            $isActive = $request->status === 'Actif';
            $query->where('is_active', $isActive);
        }
        
        // Tri par date
        if ($request->has('date')) {
            if ($request->date === 'Plus récente') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->date === 'Plus ancienne') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Tri par défaut
        }
        
        $users = $query->paginate(10);
        
        return view('admin.user.index', compact('users'));
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
        //
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
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
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
}
