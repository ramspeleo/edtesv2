<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OfficeController extends Controller
{
    public function index()
    {
        return view('offices.index');
    }

    public function ajaxData()
    {
        $offices = Office::query()
            ->with('parent');

        return DataTables::eloquent($offices)
            ->addColumn('parent_office', function ($row) {
                return $row->parent->office_name ?? 'N/A';
            })

            ->addColumn('status_badge', function ($row) {
                return $row->is_active
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })

            ->addColumn('action', function ($row) {
                $editBtn = '<a href="' . route('offices.edit', $row->id) . '"
                    class="btn btn-sm btn-warning mb-1">
                    Edit
                </a>';

                $deleteBtn = '<form action="' . route('offices.destroy', $row->id) . '"
                    method="POST"
                    class="d-inline">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit"
                        class="btn btn-sm btn-danger mb-1"
                        onclick="return confirm(\'Delete this office?\')">
                        Delete
                    </button>
                </form>';

                return $editBtn . ' ' . $deleteBtn;
            })

            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    public function create()
    {
        $parentOffices = Office::orderBy('office_name')->get();

        return view('offices.create', compact('parentOffices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'office_code' => 'required|unique:offices',
            'office_name' => 'required',
            'office_type' => 'required',
        ]);

        Office::create($request->all());

        return redirect()
            ->route('offices.index')
            ->with('success', 'Office created successfully.');
    }

    public function show(Office $office)
    {
        return view('offices.show', compact('office'));
    }

    public function edit(Office $office)
    {
        $parentOffices = Office::where('id', '!=', $office->id)->get();

        return view('offices.edit', compact('office', 'parentOffices'));
    }

    public function update(Request $request, Office $office)
    {
        $request->validate([
            'office_code' => 'required|unique:offices,office_code,' . $office->id,
            'office_name' => 'required',
            'office_type' => 'required',
        ]);

        $office->update($request->all());

        return redirect()
            ->route('offices.index')
            ->with('success', 'Office updated successfully.');
    }

    public function destroy(Office $office)
    {
        $office->delete();

        return redirect()
            ->route('offices.index')
            ->with('success', 'Office deleted successfully.');
    }
}