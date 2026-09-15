# Changelog

## v5.0.0

- Support Filament v5 and Laravel 12 / 13 (PHP 8.2+), with filament-locations, filament-types and filament-translation-component ^5.0.
- Invoice settings behind optional fields are nullable, so saving the settings page with an empty field no longer fails.
- The invoice page no longer requires the billed model to have a `locations()` relation or a billed-from record.
- Recording a payment on an invoice without a currency no longer fails.
- Item totals ignore empty item rows instead of failing.
- The invoice `user()` relation uses the configured auth user model instead of `App\Models\User`.
- Action forms use the v5 `schema()` API.
- Test suite for every invoice page, create, payments, email, statuses, settings and the install command.
