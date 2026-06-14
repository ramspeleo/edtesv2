<?php

namespace App\Http\Controllers;

use App\Models\DocumentRoute;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OutboxController extends Controller
{
    public function index()
    {
        return view('outbox.index');
    }

    public function ajaxData()
    {
        $routes = DocumentRoute::query()
            ->with([
                'document',
                'fromOffice',
                'toOffice',
            ])
            ->where('routed_by', Auth::id())
            ->latest();

        return DataTables::eloquent($routes)
            ->addColumn('document_number', fn ($row) => $row->document->document_number ?? 'N/A')
            ->addColumn('subject', fn ($row) => $row->document->subject ?? 'N/A')
            ->addColumn('from_office', fn ($row) => $row->fromOffice->office_code ?? 'N/A')
            ->addColumn('to_office', fn ($row) => $row->toOffice->office_code ?? 'N/A')
            ->editColumn('routed_at', fn ($row) => $row->routed_at ? $row->routed_at->format('M d, Y h:i A') : 'N/A')
            ->addColumn('status_badge', function ($row) {
                $class = match ($row->status) {
                    'pending' => 'bg-warning text-dark',
                    'received' => 'bg-success',
                    'returned' => 'bg-danger',
                    'completed' => 'bg-primary',
                    default => 'bg-secondary',
                };

                return '<span class="badge '.$class.'">'.strtoupper($row->status).'</span>';
            })
            ->addColumn('action', function ($row) {
            return '<a href="'.route('documents.show', $row->document_id).'"
                class="btn btn-sm btn-gov-view"
                title="View Document Details">
                    <i class="bi bi-file-earmark-text-fill me-1"></i>
                    View
                </a>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
}