<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentRoute;
use App\Models\DocumentAction;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentRouteController extends Controller
{
    public function create(Document $document)
    {
        $offices = Office::where('id', '!=', $document->current_office_id)
            ->where('is_active', true)
            ->orderBy('office_name')
            ->get();

        return view('documents.route', compact(
            'document',
            'offices'
        ));
    }

    
    public function store(Request $request, Document $document)
    {
        $request->validate([
            'to_office_id' => 'required|exists:offices,id',
            'action_required' => 'required',
        ]);

        $hasPendingRoute = $document->routes()
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingRoute) {
            return back()
                ->withInput()
                ->with('error', 'This document already has a pending route. The receiving office must receive it first.');
        }

        DocumentRoute::create([
            'document_id' => $document->id,

            'from_office_id' => $document->current_office_id,
            'from_user_id' => Auth::id(),

            'to_office_id' => $request->to_office_id,

            'action_required' => $request->action_required,
            'remarks' => $request->remarks,

            'routed_by' => Auth::id(),
            'routed_at' => now(),

            'status' => 'pending',
        ]);

        DocumentAction::create([
            'document_id' => $document->id,
            'acted_by' => Auth::id(),
            'action_taken' => 'ROUTED',
            'remarks' => $request->remarks,
            'acted_at' => now(),
        ]);

        $document->update([
            'current_office_id' => $request->to_office_id,
            'current_user_id' => null,
            'status' => 'in_route',
        ]);

        return redirect()
            ->route('documents.index')
            ->with('success', 'Document routed successfully.');
    }
}