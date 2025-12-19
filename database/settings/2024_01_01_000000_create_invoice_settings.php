<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Company Information
        $this->migrator->add('invoices.company_name', '');
        $this->migrator->add('invoices.company_logo', null);
        $this->migrator->add('invoices.company_address', '');
        $this->migrator->add('invoices.company_phone', '');
        $this->migrator->add('invoices.company_email', '');
        $this->migrator->add('invoices.company_tax_id', '');

        // Default Settings
        $this->migrator->add('invoices.default_currency', 'USD');
        $this->migrator->add('invoices.default_tax_rate', 0.0);
        $this->migrator->add('invoices.default_payment_terms', 30);

        // Email Configuration
        $this->migrator->add('invoices.email_subject_template', 'Invoice #{uuid} from {company_name}');
        $this->migrator->add('invoices.email_body_template', "Dear {customer_name},\n\nPlease find attached invoice #{uuid} for your reference.\n\nTotal Amount: {total} {currency}\nDue Date: {due_date}\n\nThank you for your business.\n\nBest regards,\n{company_name}");
        $this->migrator->add('invoices.email_cc', null);
        $this->migrator->add('invoices.email_bcc', null);
        $this->migrator->add('invoices.email_from_name', '');
        $this->migrator->add('invoices.email_from_email', '');

        // PDF Options
        $this->migrator->add('invoices.default_template', 'classic');
        $this->migrator->add('invoices.paper_size', 'a4');
        $this->migrator->add('invoices.include_terms', false);
        $this->migrator->add('invoices.terms_text', '');
    }
};
