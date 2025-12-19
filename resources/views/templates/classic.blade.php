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
            color: #333;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        .invoice-header {
            display: table;
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .invoice-header-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .invoice-header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            text-align: right;
        }
        .company-logo {
            max-width: 180px;
            max-height: 80px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .company-details {
            font-size: 11px;
            color: #666;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 14px;
            color: #666;
        }
        .invoice-meta {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .invoice-meta-left,
        .invoice-meta-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .meta-section {
            margin-bottom: 20px;
        }
        .meta-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 5px;
        }
        .meta-value {
            font-size: 12px;
            color: #333;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-overdue { background: #f8d7da; color: #721c24; }
        .status-draft { background: #e2e3e5; color: #383d41; }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: #f8f9fa;
            border-bottom: 2px solid #333;
            padding: 12px 8px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #666;
        }
        .items-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #e9ecef;
        }
        .items-table .text-right {
            text-align: right;
        }
        .items-table .text-center {
            text-align: center;
        }
        .item-description {
            font-size: 10px;
            color: #666;
            margin-top: 4px;
        }
        .totals-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .totals-left {
            display: table-cell;
            width: 60%;
        }
        .totals-right {
            display: table-cell;
            width: 40%;
        }
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px;
        }
        .totals-table .label {
            text-align: right;
            color: #666;
        }
        .totals-table .value {
            text-align: right;
            font-weight: bold;
        }
        .totals-table .grand-total {
            font-size: 16px;
            border-top: 2px solid #333;
        }
        .notes-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .notes-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .terms-section {
            border-top: 1px solid #e9ecef;
            padding-top: 20px;
            font-size: 10px;
            color: #666;
        }
        .terms-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="invoice-header-left">
                @if($settings->company_logo)
                    <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="Company Logo" class="company-logo">
                @endif
                <div class="company-name">{{ $settings->company_name ?: 'Your Company' }}</div>
                <div class="company-details">
                    @if($settings->company_address)
                        {!! nl2br(e($settings->company_address)) !!}<br>
                    @endif
                    @if($settings->company_phone)
                        {{ $settings->company_phone }}<br>
                    @endif
                    @if($settings->company_email)
                        {{ $settings->company_email }}<br>
                    @endif
                    @if($settings->company_tax_id)
                        Tax ID: {{ $settings->company_tax_id }}
                    @endif
                </div>
            </div>
            <div class="invoice-header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-number">#{{ $invoice->uuid }}</div>
            </div>
        </div>

        <div class="invoice-meta">
            <div class="invoice-meta-left">
                <div class="meta-section">
                    <div class="meta-label">Bill To</div>
                    <div class="meta-value">
                        <strong>{{ $invoice->name }}</strong><br>
                        @if($invoice->address)
                            {!! nl2br(e($invoice->address)) !!}<br>
                        @endif
                        @if($invoice->phone)
                            {{ $invoice->phone }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="invoice-meta-right">
                <div class="meta-section">
                    <div class="meta-label">Invoice Date</div>
                    <div class="meta-value">{{ $invoice->date?->format('M d, Y') }}</div>
                </div>
                <div class="meta-section">
                    <div class="meta-label">Due Date</div>
                    <div class="meta-value">{{ $invoice->due_date?->format('M d, Y') }}</div>
                </div>
                <div class="meta-section">
                    <div class="meta-label">Status</div>
                    <div class="meta-value">
                        <span class="status-badge status-{{ strtolower($invoice->status) }}">
                            {{ $invoice->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 40%">Item</th>
                    <th class="text-center" style="width: 15%">Qty</th>
                    <th class="text-right" style="width: 15%">Price</th>
                    <th class="text-right" style="width: 15%">Tax</th>
                    <th class="text-right" style="width: 15%">Total</th>
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

        <div class="totals-section">
            <div class="totals-left">
                @if($invoice->notes)
                    <div class="notes-section">
                        <div class="notes-title">Notes</div>
                        {!! nl2br(e($invoice->notes)) !!}
                    </div>
                @endif
            </div>
            <div class="totals-right">
                <table class="totals-table">
                    <tr>
                        <td class="label">Subtotal</td>
                        <td class="value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                    </tr>
                    @if($invoice->vat > 0)
                        <tr>
                            <td class="label">Tax</td>
                            <td class="value">{{ number_format($invoice->vat, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                        </tr>
                    @endif
                    @if($invoice->discount > 0)
                        <tr>
                            <td class="label">Discount</td>
                            <td class="value">-{{ number_format($invoice->discount, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                        </tr>
                    @endif
                    @if($invoice->shipping > 0)
                        <tr>
                            <td class="label">Shipping</td>
                            <td class="value">{{ number_format($invoice->shipping, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                        </tr>
                    @endif
                    <tr class="grand-total">
                        <td class="label">Total</td>
                        <td class="value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                    </tr>
                    @if($invoice->paid > 0)
                        <tr>
                            <td class="label">Paid</td>
                            <td class="value">-{{ number_format($invoice->paid, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                        </tr>
                        <tr>
                            <td class="label">Balance Due</td>
                            <td class="value">{{ number_format($invoice->total - $invoice->paid, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                        </tr>
                    @endif
                </table>
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
</body>
</html>
