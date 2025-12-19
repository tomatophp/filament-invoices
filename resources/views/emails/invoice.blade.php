<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->uuid }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #374151;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #1f2937;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-header .invoice-number {
            margin-top: 10px;
            font-size: 14px;
            opacity: 0.8;
        }
        .email-body {
            padding: 30px;
        }
        .email-body p {
            margin: 0 0 16px;
        }
        .invoice-summary {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .summary-row:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 18px;
            padding-top: 12px;
        }
        .summary-label {
            color: #6b7280;
        }
        .summary-value {
            color: #111827;
        }
        .cta-button {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 500;
            margin: 20px 0;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
        .company-info {
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $settings->company_name ?: 'Invoice' }}</h1>
            <div class="invoice-number">Invoice #{{ $invoice->uuid }}</div>
        </div>

        <div class="email-body">
            {!! nl2br(e($body)) !!}

            <div class="invoice-summary">
                <div class="summary-row">
                    <span class="summary-label">Invoice Date</span>
                    <span class="summary-value">{{ $invoice->date?->format('M d, Y') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Due Date</span>
                    <span class="summary-value">{{ $invoice->due_date?->format('M d, Y') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Status</span>
                    <span class="summary-value">{{ $invoice->status }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Total Amount</span>
                    <span class="summary-value">{{ number_format($invoice->total, 2) }} {{ $invoice->currency?->iso ?? $settings->default_currency }}</span>
                </div>
            </div>

            <p style="font-size: 14px; color: #6b7280;">
                Please find the invoice PDF attached to this email.
            </p>
        </div>

        <div class="email-footer">
            <p>Thank you for your business!</p>
            <div class="company-info">
                @if($settings->company_name)
                    <strong>{{ $settings->company_name }}</strong><br>
                @endif
                @if($settings->company_address)
                    {{ $settings->company_address }}<br>
                @endif
                @if($settings->company_phone)
                    {{ $settings->company_phone }}<br>
                @endif
                @if($settings->company_email)
                    {{ $settings->company_email }}
                @endif
            </div>
        </div>
    </div>
</body>
</html>
