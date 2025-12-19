<?php

namespace TomatoPHP\FilamentInvoices\Settings;

use Spatie\LaravelSettings\Settings;

class InvoiceSettings extends Settings
{
    // Company Information
    public string $company_name;

    public ?string $company_logo;

    public string $company_address;

    public string $company_phone;

    public string $company_email;

    public string $company_tax_id;

    // Default Settings
    public string $default_currency;

    public float $default_tax_rate;

    public int $default_payment_terms;

    // Email Configuration
    public string $email_subject_template;

    public string $email_body_template;

    public ?string $email_cc;

    public ?string $email_bcc;

    public string $email_from_name;

    public string $email_from_email;

    // PDF Options
    public string $default_template;

    public string $paper_size;

    public bool $include_terms;

    public string $terms_text;

    public static function group(): string
    {
        return 'invoices';
    }
}
