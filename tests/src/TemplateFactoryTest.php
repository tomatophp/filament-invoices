<?php

use TomatoPHP\FilamentInvoices\Contracts\InvoiceTemplateInterface;
use TomatoPHP\FilamentInvoices\Services\Templates\ClassicTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\CreativeTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\MinimalTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\ModernTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\ProfessionalTemplate;
use TomatoPHP\FilamentInvoices\Services\Templates\TemplateFactory;

beforeEach(function () {
    TemplateFactory::clear();
    TemplateFactory::register('classic', ClassicTemplate::class);
    TemplateFactory::register('modern', ModernTemplate::class);
    TemplateFactory::register('minimal', MinimalTemplate::class);
    TemplateFactory::register('professional', ProfessionalTemplate::class);
    TemplateFactory::register('creative', CreativeTemplate::class);
});

it('can register templates', function () {
    expect(TemplateFactory::has('classic'))->toBeTrue()
        ->and(TemplateFactory::has('modern'))->toBeTrue()
        ->and(TemplateFactory::has('minimal'))->toBeTrue()
        ->and(TemplateFactory::has('professional'))->toBeTrue()
        ->and(TemplateFactory::has('creative'))->toBeTrue();
});

it('can create template instances', function () {
    $classic = TemplateFactory::make('classic');

    expect($classic)->toBeInstanceOf(InvoiceTemplateInterface::class)
        ->and($classic)->toBeInstanceOf(ClassicTemplate::class);
});

it('throws exception for unregistered template', function () {
    TemplateFactory::make('nonexistent');
})->throws(InvalidArgumentException::class);

it('returns registered template names', function () {
    $names = TemplateFactory::getRegisteredNames();

    expect($names)->toContain('classic')
        ->and($names)->toContain('modern')
        ->and($names)->toContain('minimal')
        ->and($names)->toContain('professional')
        ->and($names)->toContain('creative');
});

it('returns template options with labels', function () {
    $options = TemplateFactory::getOptions();

    expect($options)->toHaveKey('classic')
        ->and($options)->toHaveKey('modern')
        ->and($options)->toHaveKey('minimal')
        ->and($options)->toHaveKey('professional')
        ->and($options)->toHaveKey('creative');
});

it('can get all template instances', function () {
    $templates = TemplateFactory::all();

    expect($templates)->toHaveCount(5)
        ->and($templates['classic'])->toBeInstanceOf(ClassicTemplate::class)
        ->and($templates['modern'])->toBeInstanceOf(ModernTemplate::class);
});

it('can clear all registered templates', function () {
    TemplateFactory::clear();

    expect(TemplateFactory::getRegisteredNames())->toBeEmpty();
});

it('validates template class implements interface', function () {
    TemplateFactory::register('invalid', stdClass::class);
})->throws(InvalidArgumentException::class);

it('each template has required methods', function () {
    $templates = [
        TemplateFactory::make('classic'),
        TemplateFactory::make('modern'),
        TemplateFactory::make('minimal'),
        TemplateFactory::make('professional'),
        TemplateFactory::make('creative'),
    ];

    foreach ($templates as $template) {
        expect($template->getName())->toBeString()
            ->and($template->getLabel())->toBeString()
            ->and($template->getDescription())->toBeString()
            ->and($template->getViewPath())->toBeString();
    }
});
