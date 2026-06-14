<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use App\Models\DocumentRoute;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    //qrcode
    public function scanReceive(Document $document)
    {
        $user = auth()->user();

        $route = $document->routes()
            ->where('to_office_id', $user->office_id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$route) {
            return redirect()
                ->route('documents.show', $document)
                ->with('error', 'No pending route found for your office.');
        }

        $route->update([
            'status' => 'received',
            'received_at' => now(),
            'received_by' => $user->id,
        ]);

        $document->update([
            'status' => 'received',
            'current_office_id' => $user->office_id,
            'current_user_id' => $user->id,
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Document received successfully.');
    }

    // COver Sheet
    public function coverSheet(Document $document)
    {
        $document->load([
            'documentType',
            'originOffice',
            'currentOffice',
            'originUser',
            'currentUser',
            'routes.fromOffice',
            'routes.toOffice',
            'routes.routedBy',
        ]);

        return view('documents.cover-sheet', compact('document'));
    }
    // ajax data

    public function documentAjaxData()
    {
        $documents = Document::query()
            ->with([
                'documentType',
                'currentOffice',
            ])
            ->latest();

        return DataTables::eloquent($documents)
            ->addIndexColumn()

            ->addColumn('document_type', function ($row) {
                return $row->documentType->name ?? 'N/A';
            })

            ->addColumn('office', function ($row) {
                return $row->currentOffice->office_name ?? 'N/A';
            })

            ->addColumn('status_badge', function ($row) {
                $statusClass = match ($row->status) {
                    'registered' => 'bg-success',
                    'in_route'   => 'bg-warning text-dark',
                    'received'   => 'bg-info text-dark',
                    'completed'  => 'bg-primary',
                    'returned'   => 'bg-danger',
                    default      => 'bg-secondary',
                };

                $statusLabel = strtoupper(str_replace('_', ' ', $row->status));

                return '<span class="badge ' . $statusClass . '">' . $statusLabel . '</span>';
            })

            ->addColumn('action', function ($row) {

                $buttons = [];

                $buttons[] = '
                    <a href="' . route('documents.show', $row->id) . '"
                    class="btn btn-sm btn-gov-action btn-gov-view"
                    title="View Document Details">
                        <i class="bi bi-eye-fill"></i>
                        View
                    </a>';

                $buttons[] = '
                    <a href="' . route('documents.coverSheet', $row->id) . '"
                    class="btn btn-sm btn-gov-action btn-gov-print"
                    target="_blank"
                    title="Print Cover Sheet">
                        <i class="bi bi-printer-fill"></i>
                        Print
                    </a>';

                if (! in_array($row->status, ['in_route', 'completed'])) {
                    $buttons[] = '
                        <a href="' . route('documents.route.create', $row->id) . '"
                        class="btn btn-sm btn-gov-action btn-gov-route"
                        title="Route Document">
                            <i class="bi bi-send-fill"></i>
                            Route
                        </a>';
                } else {
                    $buttons[] = '
                        <button type="button"
                                class="btn btn-sm btn-gov-action btn-gov-disabled"
                                disabled
                                title="Document already routed or completed">
                            <i class="bi bi-hourglass-split"></i>
                            Pending
                        </button>';
                }

                if ($row->main_document_path) {
                    $buttons[] = '
                        <a href="' . asset('storage/' . $row->main_document_path) . '"
                        class="btn btn-sm btn-gov-action btn-gov-file"
                        target="_blank"
                        title="Open Attachment">
                            <i class="bi bi-paperclip"></i>
                            File
                        </a>';
                } else {
                    $buttons[] = '
                        <button type="button"
                                class="btn btn-sm btn-gov-action btn-gov-disabled"
                                disabled
                                title="No Attachment Available">
                            <i class="bi bi-paperclip"></i>
                            No File
                        </button>';
                }

                return '
                    <div class="d-flex flex-wrap gap-1 justify-content-center">
                        ' . implode('', $buttons) . '
                    </div>
                ';
            })

            ->rawColumns([
                'status_badge',
                'action',
            ])

            ->make(true);
    }
    public function index()
    {
        return view('documents.index');
    }

    public function create()
    {
        $offices = Office::where('is_active', true)
            ->orderBy('office_name')
            ->get();

        $documentTypes = DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'documents.create',
            compact(
                'offices',
                'documentTypes'
            )
        );
    }


    public function sign(Request $request, Document $document)
    {
        // Mark document as signed
        $document->update([
            'status'    => 'signed',
            'signed_at' => now(),
            'signed_by' => auth()->id(),
        ]);

        // Find Records Officer
        $recordsOfficer = User::role('Records Officer')->first();

        // Route document to Records Officer
        DocumentRoute::create([
            'document_id' => $document->id,
            'from_user_id' => auth()->id(),
            'to_user_id' => $recordsOfficer->id,
            'status' => 'pending',
            'remarks' => 'Signed document forwarded to Records Officer',
        ]);

        return redirect()
            ->route('documents.show', $document)
            ->with('success', 'Document signed and forwarded to Records Officer.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type_id' => 'required',
            'subject' => 'required|string|max:255',
            'origin_office_id' => 'required',
        ]);

        $trackingNumber = $this->generateTrackingNumber();
        $documentNumber = $this->generateDocumentNumber(
            $request->origin_office_id
        );

        $filePath = null;

        if ($request->hasFile('main_document')) {
            $filePath = $request
                ->file('main_document')
                ->store('documents', 'public');
        }

        Document::create([
            'tracking_number' => $trackingNumber,
            'document_number' => $documentNumber,
            'reference_number' => $request->reference_number,
            'document_type_id' => $request->document_type_id,
            'document_date' => $request->document_date,
            'subject' => $request->subject,
            'description' => $request->description,

            'origin_office_id' => $request->origin_office_id,
            'origin_user_id' => Auth::id(),

            'current_office_id' => $request->origin_office_id,
            'current_user_id' => Auth::id(),

            'priority' => $request->priority,
            'confidentiality' => $request->confidentiality,

            'status' => 'registered',

            'main_document_path' => $filePath,
        ]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document registered successfully.');
    }

    private function generateTrackingNumber()
    {
        $year = now()->year;

        $latest = Document::latest('id')->first();

        $next = $latest ? $latest->id + 1 : 1;

        return sprintf(
            'EDTES-%s-%06d',
            $year,
            $next
        );
    }
    private function generateDocumentNumber($officeId)
    {
        $office = Office::findOrFail($officeId);

        $year = now()->year;

        $latest = Document::where(
                'origin_office_id',
                $officeId
            )
            ->whereYear('created_at', $year)
            ->latest('id')
            ->first();

        $next = 1;

        if ($latest && $latest->document_number) {

            $parts = explode(
                '-',
                $latest->document_number
            );

            $next = (int) end($parts) + 1;
        }

        return sprintf(
            '%s-%s-%06d',
            $office->office_code,
            $year,
            $next
        );
    }
    public function show(Document $document)
    {
        $document->load([
            'documentType',
            'originOffice',
            'currentOffice',
            'routes.fromOffice',
            'routes.toOffice',
            'routes.routedBy',
            'actions',
        ]);

        return view('documents.show', compact('document'));
    }
}