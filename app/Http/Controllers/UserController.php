<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Office;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
    public function create()
    {
        $offices = Office::where('is_active', true)
            ->orderBy('office_name')
            ->get();

        $roles = Role::orderBy('name')
            ->get();

        return view('users.create', compact('offices', 'roles'));
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);

        $offices = Office::all();
        $roles = Role::all();

        return view('users.edit', compact(
            'user',
            'offices',
            'roles'
        ));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->only([
            'name',
            'email',
        ]));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }
    public function index()
    {
        return view('users.index');
    }
    public function ajaxData()
    {
        $users = User::query()
            ->with(['office', 'roles']);

        return DataTables::eloquent($users)
            ->addColumn('office', function ($row) {
                return $row->office->office_name ?? 'N/A';
            })

            ->addColumn('role', function ($row) {
                return $row->roles->pluck('name')->implode(', ') ?: 'N/A';
            })

            ->addColumn('mobile_no', function ($row) {
                $mobile = preg_replace('/\D/', '', $row->mobile_no ?? '');

                if (strlen($mobile) === 11 && str_starts_with($mobile, '09')) {
                    return '+63 ' .
                        substr($mobile, 1, 3) . ' ' .
                        substr($mobile, 4, 3) . ' ' .
                        substr($mobile, 7, 4);
                }

                return $row->mobile_no ?? 'N/A';
            })


            ->addColumn('status_badge', function ($row) {
                $status = strtolower($row->status ?? 'active');

                $class = match ($status) {
                    'active' => 'bg-success',
                    'inactive' => 'bg-danger',
                    default => 'bg-secondary',
                };

                return '<span class="badge '.$class.'">'.strtoupper($status).'</span>';
            })

            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex justify-content-center">
                        <a href="' . route('users.edit', $row->id) . '"
                        class="btn btn-sm btn-gov-action btn-gov-edit"
                        title="Update User Account">
                            <i class="bi bi-pencil-square"></i>
                            Update
                        </a>
                    </div>';
            })

            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
}
