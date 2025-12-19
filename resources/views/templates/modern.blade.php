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
            line-height: 1.6;
            color: #2d3748;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header-bar {
            background-color: #667eea;
            padding: 40px;
            color: #fff;
        }
        .header-content {
            display: table;
            width: 100%;
        }
        .header-left {
            display: table-cell;
            width: 60%;
            vertical-align: middle;
        }
        .header-right {
            display: table-cell;
            width: 40%;
            vertical-align: middle;
            text-align: right;
        }
        .company-logo {
            max-width: 150px;
            max-height: 60px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .invoice-label {
            font-size: 14px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .invoice-number {
            font-size: 24px;
            font-weight: bold;
        }
        .content-area {
            padding: 40px;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }
        .info-col {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
        }
        .info-box {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            margin-right: 15px;
        }
        .info-col:last-child .info-box {
            margin-right: 0;
        }
        .info-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #718096;
            margin-bottom: 8px;
        }
        .info-value {
            font-size: 13px;
            color: #2d3748;
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background: #c6f6d5; color: #22543d; }
        .status-pending { background: #fefcbf; color: #744210; }
        .status-overdue { background: #fed7d7; color: #742a2a; }
        .status-draft { background: #e2e8f0; color: #4a5568; }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: #667eea;
            color: #fff;
            padding: 15px 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .items-table th:first-child {
            border-radius: 8px 0 0 0;
        }
        .items-table th:last-child {
            border-radius: 0 8px 0 0;
        }
        .items-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table tbody tr:hover {
            background: #f7fafc;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .item-description {
            font-size: 11px;
            color: #718096;
            margin-top: 4px;
        }
        .summary-section {
            display: table;
            width: 100%;
        }
        .summary-left {
            display: table-cell;
            width: 55%;
            vertical-align: top;
            padding-right: 30px;
        }
        .summary-right {
            display: table-cell;
            width: 45%;
            vertical-align: top;
        }
        .notes-box {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .notes-title {
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 10px;
        }
        .totals-box {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
        }
        .total-row {
            display: table;
            width: 100%;
            padding: 8px 0;
        }
        .total-label {
            display: table-cell;
            color: #718096;
        }
        .total-value {
            display: table-cell;
            text-align: right;
            font-weight: 600;
            color: #2d3748;
        }
        .grand-total {
            border-top: 2px solid #667eea;
            margin-top: 10px;
            padding-top: 15px;
        }
        .grand-total .total-label,
        .grand-total .total-value {
            font-size: 16px;
            color: #667eea;
            font-weight: bold;
        }
        .terms-section {
            margin-top: 30px;
            padding: 20px;
            background: #f7fafc;
            border-radius: 8px;
            font-size: 11px;
            color: #718096;
        }
        .terms-title {
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #718096;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header-bar">
            <div class="header-content">
                <div class="header-left">
                    @if($settings->company_logo)
                        <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="Logo" class="company-logo">
                    @endif
                    <div class="company-name">{{ $settings->company_name ?: 'Your Company' }}</div>
                </div>
                <div class="header-right">
                    <div class="invoice-label">Invoice</div>
                    <div class="invoice-number">#{{ $invoice->uuid }}</div>
                </div>
            </div>
        </div>

        <div class="content-area">
            <div class="info-row">
                <div class="info-col">
                    <div class="info-box">
                        <div class="info-label">Bill To</div>
                        <div class="info-value">
                            <strong>{{ $invoice->name }}</strong><br>
                            @if($invoice->address){!! nl2br(e($invoice->address)) !!}<br>@endif
                            @if($invoice->phone){{ $invoice->phone }}@endif
                        </div>
                    </div>
                </div>
                <div class="info-col">
                    <div class="info-box">
                        <div class="info-label">Invoice Date</div>
                        <div class="info-value">{{ $invoice->date?->format('M d, Y') }}</div>
                        <div class="info-label" style="margin-top: 15px;">Due Date</div>
                        <div class="info-value">{{ $invoice->due_date?->format('M d, Y') }}</div>
                    </div>
                </div>
                <div class="info-col">
                    <div class="info-box">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ strtolower($invoice->status) }}">{{ $invoice->status }}</span>
                        </div>
                        <div class="info-label" style="margin-top: 15px;">Currency</div>
                        <div class="info-value">{{ $invoice->currency?->iso ?? $settings->default_currency }}</div>
                    </div>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 45%">Description</th>
                        <th class="text-center" style="width: 12%">Qty</th>
                        <th class="text-right" style="width: 15%">Price</th>
                        <th class="text-right" style="width: 13%">Tax</th>
                        <th class="text-right" style="width: 15%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoicesItems as $item)
                        <tr>
                            <td>
                                {{ $item->item }}
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

            <div class="summary-section">
                <div class="summary-left">
                    @if($invoice->notes)
                        <div class="notes-box">
                            <div class="notes-title">Notes</div>
                            {!! nl2br(e($invoice->notes)) !!}
                        </div>
                    @endif
                </div>
                <div class="summary-right">
                    <div class="totals-box">
                        <div class="total-row">
                            <div class="total-label">Subtotal</div>
                            <div class="total-value">{{ number_format($invoice->total, 2) }}</div>
                        </div>
                        @if($invoice->vat > 0)
                            <div class="total-row">
                                <div class="total-label">Tax</div>
                                <div class="total-value">{{ number_format($invoice->vat, 2) }}</div>
                            </div>
                        @endif
                        @if($invoice->discount > 0)
                            <div class="total-row">
                                <div class="total-label">Discount</div>
                                <div class="total-value">-{{ number_format($invoice->discount, 2) }}</div>
                            </div>
                        @endif
                        <div class="total-row grand-total">
                            <div class="total-label">Total</div>
                            <div class="total-value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</div>
                        </div>
                        @if($invoice->paid > 0)
                            <div class="total-row" style="margin-top: 10px;">
                                <div class="total-label">Paid</div>
                                <div class="total-value">-{{ number_format($invoice->paid, 2) }}</div>
                            </div>
                            <div class="total-row">
                                <div class="total-label">Balance Due</div>
                                <div class="total-value">{{ number_format($invoice->total - $invoice->paid, 2) }}</div>
                            </div>
                        @endif
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
