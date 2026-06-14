<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentRoute;
use App\Models\DocumentAction;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
class InboxController extends Controller
{


    public function incomingAjaxData()
    {
        $officeId = Auth::user()->office_id;

        $routes = DocumentRoute::query()
            ->with(['document', 'fromOffice', 'toOffice'])
            ->where('to_office_id', $officeId)
            ->where('status', 'pending')
            ->latest();

        return DataTables::eloquent($routes)
            ->addColumn('document_number', fn ($row) => $row->document->document_number ?? 'N/A')
            ->addColumn('tracking_number', fn ($row) => $row->document->tracking_number ?? 'N/A')
            ->addColumn('subject', fn ($row) => $row->document->subject ?? 'N/A')
            ->addColumn('from_office', function ($row) {
                return '<span class="badge bg-secondary">'
                    . ($row->fromOffice->office_code ?? 'N/A')
                    . '</span>';
            })
            ->editColumn('routed_at', function ($row) {
                return $row->routed_at
                    ? $row->routed_at->format('M d, Y h:i A')
                    : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $viewBtn = '<a href="' . route('documents.show', $row->document) . '"
                    class="btn btn-sm btn-info mb-1">View</a>';

                $receiveBtn = '<form method="POST"
                    action="' . route('routes.receive', $row) . '"
                    class="d-inline">'
                    . csrf_field() .
                    '<button type="submit"
                        class="btn btn-sm btn-success mb-1"
                        onclick="return confirm(\'Receive this document?\')">
                        Receive
                    </button>
                </form>';

                return $viewBtn . ' ' . $receiveBtn;
            })
            ->rawColumns(['from_office', 'action'])
            ->make(true);
    }

    public function index()
    {
        return view('inbox.index');
    }
    public function receive(DocumentRoute $route)
    {
        $route->update([
            'status' => 'received',
            'received_by' => auth()->id(),
            'received_at' => now(),
        ]);

        $route->document->update([
            'status' => 'received',
            'current_user_id' => auth()->id(),
        ]);

        DocumentAction::create([
            'document_id' => $route->document_id,
            'document_route_id' => $route->id,
            'acted_by' => auth()->id(),
            'action_taken' => 'RECEIVED',
            'remarks' => 'Document received.',
            'acted_at' => now(),
        ]);

        return redirect()
            ->route('inbox.index')
            ->with('success', 'Document received successfully.');
    }
}