<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function index()
    {
        return view('permissions.index');
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Permission::firstOrCreate([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return response()->json([
            'success' => true
        ]);
    }

}
