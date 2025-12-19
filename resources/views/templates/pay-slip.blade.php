<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt - {{ $invoice->uuid }}</title>
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
            color: #333;
            background: #fff;
        }
        .receipt-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .company-logo {
            max-width: 100px;
            max-height: 50px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .company-info {
            font-size: 10px;
            color: #666;
        }
        .receipt-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #22c55e;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f0fdf4;
            border: 1px solid #22c55e;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .detail-row {
            width: 100%;
            margin-bottom: 8px;
        }
        .detail-row-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-label {
            width: 40%;
            font-weight: bold;
            color: #555;
            padding: 5px 0;
            vertical-align: top;
        }
        .detail-value {
            width: 60%;
            color: #333;
            padding: 5px 0;
            text-align: right;
            vertical-align: top;
        }
        .divider {
            border-top: 1px dashed #ccc;
            margin: 15px 0;
        }
        .amount-section {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
        }
        .amount-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .amount-value {
            font-size: 24px;
            font-weight: bold;
            color: #22c55e;
        }
        .invoice-info {
            background-color: #f0f9ff;
            padding: 15px;
            margin-bottom: 20px;
        }
        .invoice-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }
        .invoice-number {
            font-size: 14px;
            font-weight: bold;
            color: #0369a1;
        }
        .customer-section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            margin-bottom: 8px;
        }
        .customer-name {
            font-weight: bold;
            color: #333;
        }
        .customer-details {
            font-size: 11px;
            color: #666;
        }
        .receipt-footer {
            text-align: center;
            border-top: 2px dashed #ccc;
            padding-top: 20px;
            margin-top: 20px;
        }
        .thank-you {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .footer-note {
            font-size: 10px;
            color: #999;
        }
        .timestamp {
            font-size: 10px;
            color: #999;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            @if($settings->company_logo)
                <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="Logo" class="company-logo">
            @endif
            <div class="company-name">{{ $settings->company_name ?: 'Your Company' }}</div>
            <div class="company-info">
                @if($settings->company_address){{ $settings->company_address }}<br>@endif
                @if($settings->company_phone){{ $settings->company_phone }} | @endif
                @if($settings->company_email){{ $settings->company_email }}@endif
            </div>
        </div>

        <div class="receipt-title">Payment Receipt</div>

        <div class="amount-section">
            <div class="amount-label">Amount Paid</div>
            <div class="amount-value">{{ number_format($payment->value, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</div>
        </div>

        <div class="invoice-info">
            <table class="detail-row-table">
                <tr>
                    <td class="detail-label">
                        <div class="invoice-label">Invoice Reference</div>
                        <div class="invoice-number">#{{ $invoice->uuid }}</div>
                    </td>
                    <td class="detail-value">
                        <div class="invoice-label">Payment Date</div>
                        <div style="font-weight: bold;">{{ $payment->created_at->format('M d, Y') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="customer-section">
            <div class="section-title">Received From</div>
            <div class="customer-name">{{ $invoice->name }}</div>
            <div class="customer-details">
                @if($invoice->address){!! nl2br(e($invoice->address)) !!}<br>@endif
                @if($invoice->phone){{ $invoice->phone }}@endif
            </div>
        </div>

        <div class="divider"></div>

        <div class="receipt-details">
            <table class="detail-row-table">
                <tr>
                    <td class="detail-label">Invoice Total</td>
                    <td class="detail-value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Total Paid</td>
                    <td class="detail-value">{{ number_format($invoice->paid, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Balance Due</td>
                    <td class="detail-value" style="font-weight: bold; color: {{ ($invoice->total - $invoice->paid) > 0 ? '#dc2626' : '#22c55e' }};">
                        {{ number_format($invoice->total - $invoice->paid, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="receipt-footer">
            <div class="thank-you">Thank You!</div>
            <div class="footer-note">This is an official payment receipt.</div>
            <div class="timestamp">Generated on {{ now()->format('M d, Y \a\t h:i A') }}</div>
        </div>
    </div>
</body>
</html>
