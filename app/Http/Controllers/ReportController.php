<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRoute;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function documents()
    {
        return view('reports.documents');
    }

    public function tracking(Request $request)
    {
        $routes = DocumentRoute::with([
            'document',
            'fromOffice',
            'toOffice',
            'routedBy',
        ])->latest('routed_at');

        if ($request->filled('from_date')) {
            $routes->whereDate('routed_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $routes->whereDate('routed_at', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $routes->where('status', $request->status);
        }

        if ($request->filled('tracking_number')) {
            $routes->whereHas('document', function ($query) use ($request) {
                $query->where('tracking_number', 'like', '%' . $request->tracking_number . '%');
            });
        }

        $routes = $routes->paginate(20);

        return view('reports.tracking', compact('routes'));
    }
}