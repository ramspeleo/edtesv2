<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentRoute;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $officeId = Auth::user()->office_id;

        $registered = Document::count();

        $inRoute = Document::where(
            'status',
            'in_route'
        )->count();

        $received = Document::where(
            'status',
            'received'
        )->count();

        $completed = Document::where(
            'status',
            'completed'
        )->count();

        $myInbox = DocumentRoute::where(
            'to_office_id',
            $officeId
        )
        ->where('status', 'pending')
        ->count();

        $myOutbox = DocumentRoute::where(
            'routed_by',
            Auth::id()
        )->count();

        $recentDocuments = Document::latest()
            ->take(10)
            ->get();

        return view(
            'dashboard',
            compact(
                'registered',
                'inRoute',
                'received',
                'completed',
                'myInbox',
                'myOutbox',
                'recentDocuments'
            )
        );
    }
}