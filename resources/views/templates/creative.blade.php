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
            color: #374151;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .accent-bar {
            height: 8px;
            background-color: #ec4899;
        }
        .header {
            padding: 40px;
        }
        .header-table {
            width: 100%;
        }
        .header-left {
            width: 60%;
            vertical-align: top;
        }
        .header-right {
            width: 40%;
            vertical-align: top;
            text-align: right;
        }
        .company-logo {
            max-width: 140px;
            max-height: 60px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 26px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 10px;
        }
        .company-info {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.8;
        }
        .invoice-title {
            font-size: 42px;
            font-weight: bold;
            color: #ec4899;
            line-height: 1;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 14px;
            color: #6b7280;
        }
        .content {
            padding: 0 40px 40px;
        }
        .info-cards-table {
            width: 100%;
            margin-bottom: 40px;
        }
        .info-card-cell {
            width: 25%;
            padding-right: 10px;
            vertical-align: top;
        }
        .info-card-cell:last-child {
            padding-right: 0;
        }
        .card-inner {
            background-color: #fdf2f8;
            padding: 15px;
        }
        .card-inner-purple {
            background-color: #f3e8ff;
        }
        .card-inner-blue {
            background-color: #dbeafe;
        }
        .card-inner-green {
            background-color: #d1fae5;
        }
        .card-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 8px;
        }
        .card-value {
            font-size: 13px;
            font-weight: bold;
            color: #111827;
        }
        .bill-to-section {
            background-color: #f9fafb;
            padding: 25px;
            margin-bottom: 30px;
        }
        .bill-to-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #ec4899;
            margin-bottom: 10px;
        }
        .bill-to-name {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 8px;
        }
        .bill-to-details {
            color: #6b7280;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-overdue {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-draft {
            background-color: #f3f4f6;
            color: #4b5563;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #111827;
            color: #fff;
            padding: 14px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .items-table td {
            padding: 16px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .item-name {
            font-weight: bold;
            color: #111827;
        }
        .item-description {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 4px;
        }
        .bottom-table {
            width: 100%;
        }
        .bottom-left {
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        .bottom-right {
            width: 50%;
            vertical-align: top;
        }
        .notes-box {
            background-color: #fffbeb;
            padding: 20px;
            border-left: 4px solid #f59e0b;
        }
        .notes-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 10px;
            font-size: 12px;
        }
        .notes-content {
            color: #78350f;
            font-size: 12px;
        }
        .totals-box {
            background-color: #8b5cf6;
            padding: 25px;
            color: #fff;
        }
        .totals-table {
            width: 100%;
        }
        .totals-row td {
            padding: 6px 0;
        }
        .totals-label {
            font-size: 12px;
            color: #e9d5ff;
        }
        .totals-value {
            text-align: right;
            font-weight: bold;
            color: #fff;
        }
        .grand-total td {
            border-top: 2px solid #a78bfa;
            padding-top: 12px;
        }
        .grand-total .totals-label,
        .grand-total .totals-value {
            font-size: 16px;
            font-weight: bold;
            color: #fff;
        }
        .terms-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9fafb;
            font-size: 11px;
            color: #6b7280;
        }
        .terms-title {
            font-weight: bold;
            color: #374151;
            margin-bottom: 10px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #ec4899;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="accent-bar"></div>

        <div class="header">
            <table class="header-table">
                <tr>
                    <td class="header-left">
                        @if($settings->company_logo)
                            <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="Logo" class="company-logo">
                        @endif
                        <div class="company-name">{{ $settings->company_name ?: 'Your Company' }}</div>
                        <div class="company-info">
                            @if($settings->company_address){!! nl2br(e($settings->company_address)) !!}<br>@endif
                            @if($settings->company_phone){{ $settings->company_phone }}<br>@endif
                            @if($settings->company_email){{ $settings->company_email }}@endif
                        </div>
                    </td>
                    <td class="header-right">
                        <div class="invoice-title">Invoice</div>
                        <div class="invoice-number">#{{ $invoice->uuid }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="content">
            <table class="info-cards-table">
                <tr>
                    <td class="info-card-cell">
                        <div class="card-inner">
                            <div class="card-label">Issue Date</div>
                            <div class="card-value">{{ $invoice->date?->format('M d, Y') }}</div>
                        </div>
                    </td>
                    <td class="info-card-cell">
                        <div class="card-inner card-inner-purple">
                            <div class="card-label">Due Date</div>
                            <div class="card-value">{{ $invoice->due_date?->format('M d, Y') }}</div>
                        </div>
                    </td>
                    <td class="info-card-cell">
                        <div class="card-inner card-inner-blue">
                            <div class="card-label">Currency</div>
                            <div class="card-value">{{ $invoice->currency?->iso ?? $settings->default_currency }}</div>
                        </div>
                    </td>
                    <td class="info-card-cell">
                        <div class="card-inner card-inner-green">
                            <div class="card-label">Status</div>
                            <div class="card-value">
                                <span class="status-badge status-{{ strtolower($invoice->status) }}">{{ $invoice->status }}</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="bill-to-section">
                <div class="bill-to-label">Billed To</div>
                <div class="bill-to-name">{{ $invoice->name }}</div>
                <div class="bill-to-details">
                    @if($invoice->address){!! nl2br(e($invoice->address)) !!}<br>@endif
                    @if($invoice->phone){{ $invoice->phone }}@endif
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 45%">Description</th>
                        <th class="text-center" style="width: 12%">Qty</th>
                        <th class="text-right" style="width: 14%">Price</th>
                        <th class="text-right" style="width: 14%">Tax</th>
                        <th class="text-right" style="width: 15%">Amount</th>
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

            <table class="bottom-table">
                <tr>
                    <td class="bottom-left">
                        @if($invoice->notes)
                            <div class="notes-box">
                                <div class="notes-title">Notes</div>
                                <div class="notes-content">{!! nl2br(e($invoice->notes)) !!}</div>
                            </div>
                        @endif
                    </td>
                    <td class="bottom-right">
                        <div class="totals-box">
                            <table class="totals-table">
                                <tr class="totals-row">
                                    <td class="totals-label">Subtotal</td>
                                    <td class="totals-value">{{ number_format($invoice->total, 2) }}</td>
                                </tr>
                                @if($invoice->vat > 0)
                                    <tr class="totals-row">
                                        <td class="totals-label">Tax</td>
                                        <td class="totals-value">{{ number_format($invoice->vat, 2) }}</td>
                                    </tr>
                                @endif
                                @if($invoice->discount > 0)
                                    <tr class="totals-row">
                                        <td class="totals-label">Discount</td>
                                        <td class="totals-value">-{{ number_format($invoice->discount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="totals-row grand-total">
                                    <td class="totals-label">Total</td>
                                    <td class="totals-value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                                </tr>
                                @if($invoice->paid > 0)
                                    <tr class="totals-row">
                                        <td class="totals-label">Paid</td>
                                        <td class="totals-value">-{{ number_format($invoice->paid, 2) }}</td>
                                    </tr>
                                    <tr class="totals-row">
                                        <td class="totals-label">Balance Due</td>
                                        <td class="totals-value">{{ number_format($invoice->total - $invoice->paid, 2) }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

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
