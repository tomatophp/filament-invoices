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
            color: #1a1a1a;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 60px 50px;
        }
        .header {
            margin-bottom: 60px;
        }
        .invoice-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #999;
            margin-bottom: 5px;
        }
        .invoice-number {
            font-size: 28px;
            font-weight: 300;
            color: #1a1a1a;
        }
        .meta-section {
            display: table;
            width: 100%;
            margin-bottom: 50px;
        }
        .meta-col {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
        }
        .meta-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #999;
            margin-bottom: 8px;
        }
        .meta-value {
            font-size: 13px;
            color: #1a1a1a;
        }
        .meta-value strong {
            font-weight: 600;
        }
        .company-info {
            font-size: 11px;
            color: #666;
            line-height: 1.8;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid #1a1a1a;
        }
        .status-paid { border-color: #22c55e; color: #22c55e; }
        .status-pending { border-color: #f59e0b; color: #f59e0b; }
        .status-overdue { border-color: #ef4444; color: #ef4444; }
        .status-draft { border-color: #9ca3af; color: #9ca3af; }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .items-table th {
            border-top: 1px solid #1a1a1a;
            border-bottom: 1px solid #1a1a1a;
            padding: 15px 0;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .items-table td {
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .item-name {
            font-weight: 500;
        }
        .item-description {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
        }
        .summary-section {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }
        .summary-left {
            display: table-cell;
            width: 55%;
            vertical-align: top;
        }
        .summary-right {
            display: table-cell;
            width: 45%;
            vertical-align: top;
        }
        .totals-table {
            width: 100%;
        }
        .totals-row {
            display: table;
            width: 100%;
            padding: 8px 0;
        }
        .totals-label {
            display: table-cell;
            font-size: 11px;
            color: #666;
        }
        .totals-value {
            display: table-cell;
            text-align: right;
            font-weight: 500;
        }
        .grand-total {
            border-top: 1px solid #1a1a1a;
            margin-top: 15px;
            padding-top: 15px;
        }
        .grand-total .totals-label,
        .grand-total .totals-value {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }
        .notes-section {
            padding: 20px 0;
            border-top: 1px solid #eee;
        }
        .notes-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #999;
            margin-bottom: 10px;
        }
        .notes-text {
            font-size: 12px;
            color: #666;
        }
        .terms-section {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 10px;
            color: #999;
        }
        .terms-label {
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 10px;
            color: #999;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="invoice-title">Invoice</div>
            <div class="invoice-number">#{{ $invoice->uuid }}</div>
        </div>

        <div class="meta-section">
            <div class="meta-col">
                <div class="meta-label">From</div>
                <div class="meta-value">
                    <strong>{{ $settings->company_name ?: 'Your Company' }}</strong>
                </div>
                <div class="company-info">
                    @if($settings->company_address){!! nl2br(e($settings->company_address)) !!}<br>@endif
                    @if($settings->company_phone){{ $settings->company_phone }}<br>@endif
                    @if($settings->company_email){{ $settings->company_email }}@endif
                </div>
            </div>
            <div class="meta-col">
                <div class="meta-label">Bill To</div>
                <div class="meta-value">
                    <strong>{{ $invoice->name }}</strong>
                </div>
                <div class="company-info">
                    @if($invoice->address){!! nl2br(e($invoice->address)) !!}<br>@endif
                    @if($invoice->phone){{ $invoice->phone }}@endif
                </div>
            </div>
            <div class="meta-col">
                <div class="meta-label">Details</div>
                <div class="company-info">
                    Date: {{ $invoice->date?->format('M d, Y') }}<br>
                    Due: {{ $invoice->due_date?->format('M d, Y') }}<br>
                    <span class="status-badge status-{{ strtolower($invoice->status) }}">{{ $invoice->status }}</span>
                </div>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%">Description</th>
                    <th class="text-center" style="width: 12%">Qty</th>
                    <th class="text-right" style="width: 13%">Rate</th>
                    <th class="text-right" style="width: 12%">Tax</th>
                    <th class="text-right" style="width: 13%">Amount</th>
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

        <div class="summary-section">
            <div class="summary-left">
                @if($invoice->notes)
                    <div class="notes-section">
                        <div class="notes-label">Notes</div>
                        <div class="notes-text">{!! nl2br(e($invoice->notes)) !!}</div>
                    </div>
                @endif
            </div>
            <div class="summary-right">
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
                <div class="totals-row grand-total">
                    <div class="totals-label">Total</div>
                    <div class="totals-value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</div>
                </div>
                @if($invoice->paid > 0)
                    <div class="totals-row" style="margin-top: 10px;">
                        <div class="totals-label">Amount Paid</div>
                        <div class="totals-value">-{{ number_format($invoice->paid, 2) }}</div>
                    </div>
                    <div class="totals-row">
                        <div class="totals-label">Balance Due</div>
                        <div class="totals-value">{{ number_format($invoice->total - $invoice->paid, 2) }}</div>
                    </div>
                @endif
            </div>
        </div>

        @if($settings->include_terms && $settings->terms_text)
            <div class="terms-section">
                <div class="terms-label">Terms & Conditions</div>
                {!! nl2br(e($settings->terms_text)) !!}
            </div>
        @endif

        <div class="footer">
            Thank you
        </div>
    </div>
</body>
</html>
