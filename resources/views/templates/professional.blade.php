<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->uuid }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #1e293b;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            background: #0f172a;
            color: #fff;
            padding: 30px 40px;
            display: table;
            width: 100%;
        }
        .header-left {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
        }
        .header-right {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            text-align: right;
        }
        .company-logo {
            max-width: 160px;
            max-height: 50px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
        }
        .invoice-badge {
            background: #3b82f6;
            display: inline-block;
            padding: 8px 24px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .sub-header {
            background: #f1f5f9;
            padding: 20px 40px;
            display: table;
            width: 100%;
        }
        .sub-header-item {
            display: table-cell;
            width: 25%;
        }
        .sub-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 4px;
        }
        .sub-value {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
        }
        .content {
            padding: 40px;
        }
        .parties-section {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }
        .party-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .party-box {
            background: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin-right: 20px;
        }
        .party-col:last-child .party-box {
            margin-right: 0;
            border-left-color: #10b981;
        }
        .party-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 10px;
        }
        .party-name {
            font-size: 15px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 8px;
        }
        .party-details {
            font-size: 12px;
            color: #475569;
            line-height: 1.7;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
        .status-draft { background: #f1f5f9; color: #475569; }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: #0f172a;
            color: #fff;
            padding: 14px 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .item-name {
            font-weight: 600;
            color: #0f172a;
        }
        .item-description {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }
        .bottom-section {
            display: table;
            width: 100%;
        }
        .bottom-left {
            display: table-cell;
            width: 55%;
            vertical-align: top;
            padding-right: 30px;
        }
        .bottom-right {
            display: table-cell;
            width: 45%;
            vertical-align: top;
        }
        .notes-box {
            background: #fffbeb;
            border: 1px solid #fef3c7;
            padding: 20px;
            border-radius: 6px;
        }
        .notes-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 10px;
            font-size: 11px;
            text-transform: uppercase;
        }
        .notes-content {
            color: #78350f;
            font-size: 12px;
        }
        .totals-box {
            background: #0f172a;
            color: #fff;
            padding: 20px;
            border-radius: 6px;
        }
        .totals-row {
            display: table;
            width: 100%;
            padding: 8px 0;
            border-bottom: 1px solid #334155;
        }
        .totals-row:last-child {
            border-bottom: none;
        }
        .totals-label {
            display: table-cell;
            color: #94a3b8;
            font-size: 12px;
        }
        .totals-value {
            display: table-cell;
            text-align: right;
            font-weight: 600;
        }
        .grand-total {
            background: #3b82f6;
            margin: 15px -20px -20px;
            padding: 15px 20px;
            border-radius: 0 0 6px 6px;
        }
        .grand-total .totals-label,
        .grand-total .totals-value {
            font-size: 14px;
            font-weight: bold;
            color: #fff;
        }
        .terms-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 6px;
            font-size: 11px;
            color: #64748b;
        }
        .terms-title {
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="header-left">
                @if($settings->company_logo)
                    <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="Logo" class="company-logo">
                @endif
                <div class="company-name">{{ $settings->company_name ?: 'Your Company' }}</div>
            </div>
            <div class="header-right">
                <div class="invoice-badge">Invoice</div>
            </div>
        </div>

        <div class="sub-header">
            <div class="sub-header-item">
                <div class="sub-label">Invoice Number</div>
                <div class="sub-value">#{{ $invoice->uuid }}</div>
            </div>
            <div class="sub-header-item">
                <div class="sub-label">Issue Date</div>
                <div class="sub-value">{{ $invoice->date?->format('M d, Y') }}</div>
            </div>
            <div class="sub-header-item">
                <div class="sub-label">Due Date</div>
                <div class="sub-value">{{ $invoice->due_date?->format('M d, Y') }}</div>
            </div>
            <div class="sub-header-item">
                <div class="sub-label">Status</div>
                <div class="sub-value">
                    <span class="status-badge status-{{ strtolower($invoice->status) }}">{{ $invoice->status }}</span>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="parties-section">
                <div class="party-col">
                    <div class="party-box">
                        <div class="party-label">From</div>
                        <div class="party-name">{{ $settings->company_name ?: 'Your Company' }}</div>
                        <div class="party-details">
                            @if($settings->company_address){!! nl2br(e($settings->company_address)) !!}<br>@endif
                            @if($settings->company_phone){{ $settings->company_phone }}<br>@endif
                            @if($settings->company_email){{ $settings->company_email }}<br>@endif
                            @if($settings->company_tax_id)Tax ID: {{ $settings->company_tax_id }}@endif
                        </div>
                    </div>
                </div>
                <div class="party-col">
                    <div class="party-box">
                        <div class="party-label">Bill To</div>
                        <div class="party-name">{{ $invoice->name }}</div>
                        <div class="party-details">
                            @if($invoice->address){!! nl2br(e($invoice->address)) !!}<br>@endif
                            @if($invoice->phone){{ $invoice->phone }}@endif
                        </div>
                    </div>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 45%">Item Description</th>
                        <th class="text-center" style="width: 12%">Qty</th>
                        <th class="text-right" style="width: 14%">Unit Price</th>
                        <th class="text-right" style="width: 14%">Tax</th>
                        <th class="text-right" style="width: 15%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoicesItems as $item)
                        <tr>
                            <td>
                                <div class="item-name">{{ $item->item }}</div>
                                @if($item->description)
                                    <div class="item-description">{{ $item->description }}</div>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-right">{{ number_format($item->price, 2) }}</td>
                            <td class="text-right">{{ number_format($item->vat, 2) }}</td>
                            <td class="text-right">{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="bottom-section">
                <div class="bottom-left">
                    @if($invoice->notes)
                        <div class="notes-box">
                            <div class="notes-title">Notes</div>
                            <div class="notes-content">{!! nl2br(e($invoice->notes)) !!}</div>
                        </div>
                    @endif
                </div>
                <div class="bottom-right">
                    <div class="totals-box">
                        <div class="totals-row">
                            <div class="totals-label">Subtotal</div>
                            <div class="totals-value">{{ number_format($invoice->total, 2) }}</div>
                        </div>
                        @if($invoice->vat > 0)
                            <div class="totals-row">
                                <div class="totals-label">Tax</div>
                                <div class="totals-value">{{ number_format($invoice->vat, 2) }}</div>
                            </div>
                        @endif
                        @if($invoice->discount > 0)
                            <div class="totals-row">
                                <div class="totals-label">Discount</div>
                                <div class="totals-value">-{{ number_format($invoice->discount, 2) }}</div>
                            </div>
                        @endif
                        @if($invoice->paid > 0)
                            <div class="totals-row">
                                <div class="totals-label">Amount Paid</div>
                                <div class="totals-value">-{{ number_format($invoice->paid, 2) }}</div>
                            </div>
                            <div class="totals-row">
                                <div class="totals-label">Balance Due</div>
                                <div class="totals-value">{{ number_format($invoice->total - $invoice->paid, 2) }}</div>
                            </div>
                        @endif
                        <div class="totals-row grand-total">
                            <div class="totals-label">Total Amount</div>
                            <div class="totals-value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</div>
                        </div>
                    </div>
                </div>
            </div>

            @if($settings->include_terms && $settings->terms_text)
                <div class="terms-section">
                    <div class="terms-title">Terms & Conditions</div>
                    {!! nl2br(e($settings->terms_text)) !!}
                </div>
            @endif

            <div class="footer">
                Thank you for your business!
            </div>
        </div>
    </div>
</body>
</html>
