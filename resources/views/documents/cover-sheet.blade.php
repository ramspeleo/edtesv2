<!DOCTYPE html>
<html>
<head>
    <title>Route Cover Sheet - {{ $document->tracking_number }}</title>

    <style>
       
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .sheet {
            width: 8.5in;
            margin: auto;
            padding: 18px;
        }

        .no-print {
            text-align: right;
            margin-bottom: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .header-title {
            text-align: center;
            flex: 1;
        }

        /* .header-title h2,
        .header-title h3,
        .header-title p {
            margin: 3px 0;
        } */

        .qr-box {
            width: 130px;
            text-align: center;
            font-size: 10px;
        }

        .section-title {
            font-weight: bold;
            background: #e9ecef;
            border: 1px solid #000;
            padding: 6px;
            margin-top: 12px;
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td, th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }

        .label {
            width: 22%;
            font-weight: bold;
            background: #f8f9fa;
        }

        .receipt-row td {
            height: 35px;
        }

        .small-text {
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        .footer-note {
            border: 1px solid #000;
            padding: 8px;
            font-size: 11px;
            margin-top: 10px;
        }
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .logo-box,
        .header-title,
        .qr-box {
            display: table-cell;
            vertical-align: middle;
        }

        .logo-box {
                width: 100px;
        vertical-align: middle;
        }
        .logo {
            width: 100px;
            height: auto;
            display: block;
        }

        .logo-box img {
            width: 150px;
            height: auto;
        }

        .header-title {
            text-align: center;
        }

        .header-title h1 {
            margin: 6px 0;
            font-size: 25px;
        }

        .header-title h2 {
            margin: 2px 0;
            font-size: 18px;
        }
        .header-title h4 {
            margin: 2px 0;
            font-size: 10px;
        }

        .header-title h3 {
            margin: 2px 0;
            font-size: 14px;
        }

        .header-title p {
            margin: 2px 0;
            font-size: 11px;
        }

        .qr-box {
            width: 130px;
            text-align: center;
        }

        .small-text {
            font-size: 10px;
        }
        .tracking-banner {
            margin-top: 8px;
            padding: 8px;
            border: 2px solid #000;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 1px;
            background: #f8f9fa;
        }
        .tracking-number {
            text-align: right;
            margin-top: 10px;
        }

        .tracking-number .label {
            font-size: 12px;
            color: #000000;
            text-transform: uppercase;
        }

        .tracking-number .value {
            display: block;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 0; /* no extra spacing */
            font-family: "Consolas", "Courier New", monospace;
            text-transform: uppercase;
            color: #dc2626; /* red */
        }
        .document-number {
            text-align: right;
            font-size: 12px;
            color: #000000;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            opacity: 0.05; /* Adjust transparency */
        }

        .watermark img {
            width: 750px;
            height: auto;
        }
        

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }

            .sheet {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
<div class="sheet ">
    <div class="watermark">
        <img src="{{ asset('assets/images/edtesv2.png') }}" alt="NCMB Logo">
    </div>
    <div class="no-print">
        <button onclick="window.print()">Print Cover Sheet</button>
    </div>

    <div class="header">

    <div class="logo-box">
        <img src="{{ asset('assets/images/ncmblogo.png') }}"
             alt="EDTES Logo"
             class="logo">
    </div>

    <div class="header-title">
        <h4>Republic of the Philippines</h4>
        <h4>Department of Labor and Employment</h4>
        <h2>National Conciliation and Mediation Board</h2>
        <p>Electronic Document Tracking and Exchange System (EDTES)</p>

        <h1>DOCUMENT ROUTE COVER SHEET</h1>
        
    </div>

    <div class="qr-box">
        {!! QrCode::size(110)->generate(
            route('documents.scanReceive', $document)
        ) !!}
        <div class="small-text">
            Scan to Verify<br>
            Scan to Receive
        </div>
    </div>

</div>
    
    <div class="tracking-number">
            <span class="label">Tracking No.</span>
            <span class="value">{{ $document->tracking_number }}</span>
    </div>

    <div class="document-number">
        Document No. {{ $document->document_number }}
    </div>
    <div class="section-title">Document Information</div>

    <table>
        <tr>
            <td class="label">Tracking Number</td>
            <td>{{ $document->tracking_number }}</td>
            <td class="label">Document Number</td>
            <td>{{ $document->document_number }}</td>
        </tr>
        <tr>
            <td class="label">Reference Number</td>
            <td>{{ $document->reference_number ?? 'N/A' }}</td>
            <td class="label">Document Date</td>
            <td>{{ $document->document_date ? $document->document_date->format('M d, Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Document Type</td>
            <td>{{ $document->documentType->name ?? 'N/A' }}</td>
            <td class="label">Status</td>
            <td>{{ strtoupper(str_replace('_', ' ', $document->status)) }}</td>
        </tr>
        <tr>
            <td class="label">Priority</td>
            <td>{{ strtoupper($document->priority ?? 'NORMAL') }}</td>
            <td class="label">Confidentiality</td>
            <td>{{ strtoupper($document->confidentiality ?? 'INTERNAL') }}</td>
        </tr>
        <tr>
            <td class="label">Subject</td>
            <td colspan="3">{{ $document->subject }}</td>
        </tr>
        <tr>
            <td class="label">Description</td>
            <td colspan="3">{{ $document->description ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">Current Location</div>

    <table>
        <tr>
            <td class="label">Origin Office</td>
            <td>{{ $document->originOffice->office_name ?? 'N/A' }}</td>
            <td class="label">Current Office</td>
            <td>{{ $document->currentOffice->office_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Origin User</td>
            <td>{{ $document->originUser->name ?? 'N/A' }}</td>
            <td class="label">Current User</td>
            <td>{{ $document->currentUser->name ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="section-title">Routing History</div>

    <table>
        <thead>
            <tr>
                <th width="18%">Date Routed</th>
                <th width="18%">From</th>
                <th width="18%">To</th>
                <th width="18%">Routed By</th>
                <th width="18%">Action Required</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($document->routes as $route)
                <tr>
                    <td>{{ $route->routed_at ? $route->routed_at->format('M d, Y h:i A') : 'N/A' }}</td>
                    <td>{{ $route->fromOffice->office_code ?? 'N/A' }}</td>
                    <td>{{ $route->toOffice->office_code ?? 'N/A' }}</td>
                    <td>{{ $route->routedBy->name ?? 'N/A' }}</td>
                    <td>{{ $route->action_required ?? 'N/A' }}</td>
                    <td>{{ strtoupper($route->status ?? 'N/A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No routing history yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Physical Document Receipt Log</div>

    <table>
        <thead>
            <tr>
                <th width="18%">Date Received</th>
                <th width="20%">Office</th>
                <th width="22%">Received By</th>
                <th width="20%">Signature</th>
                <th width="20%">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < 6; $i++)
                <tr class="receipt-row">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="footer-note">
        <strong>Important:</strong>
        This document is tracked through EDTES. Scan the QR code to verify status,
        receive the document electronically, and view the latest routing history.
        The physical receipt log is provided for manual acknowledgment when needed.
    </div>

</div>
</body>
</html>