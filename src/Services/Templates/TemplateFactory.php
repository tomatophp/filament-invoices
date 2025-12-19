<?php

namespace TomatoPHP\FilamentInvoices\Services\Templates;

use InvalidArgumentException;
use TomatoPHP\FilamentInvoices\Contracts\InvoiceTemplateInterface;

class TemplateFactory
{
    /**
     * @var array<string, class-string<InvoiceTemplateInterface>>
     */
    protected static array $templates = [];

    /**
     * Register a template class with the factory.
     *
     * @param  class-string<InvoiceTemplateInterface>  $templateClass
     */
    public static function register(string $name, string $templateClass): void
    {
        if (! is_subclass_of($templateClass, InvoiceTemplateInterface::class)) {
            throw new InvalidArgumentException(
                "Template class [{$templateClass}] must implement " . InvoiceTemplateInterface::class
            );
        }

        static::$templates[$name] = $templateClass;
    }

    /**
     * Get a template instance by name.
     */
    public static function make(string $name): InvoiceTemplateInterface
    {
        if (! isset(static::$templates[$name])) {
            throw new InvalidArgumentException("Template [{$name}] is not registered.");
        }

        return app(static::$templates[$name]);
    }

    /**
     * Check if a template is registered.
     */
    public static function has(string $name): bool
    {
        return isset(static::$templates[$name]);
    }

    /**
     * Get all registered template names.
     *
     * @return array<string>
     */
    public static function getRegisteredNames(): array
    {
        return array_keys(static::$templates);
    }

    /**
     * Get all registered templates as options array (name => label).
     *
     * @return array<string, string>
     */
    public static function getOptions(): array
    {
        $options = [];

        foreach (static::$templates as $name => $class) {
            $template = app($class);
            $options[$name] = $template->getLabel();
        }

        return $options;
    }

    /**
     * Get all registered template instances.
     *
     * @return array<string, InvoiceTemplateInterface>
     */
    public static function all(): array
    {
        $templates = [];

        foreach (static::$templates as $name => $class) {
            $templates[$name] = app($class);
        }

        return $templates;
    }

    /**
     * Clear all registered templates (useful for testing).
     */
    public static function clear(): void
    {
        static::$templates = [];
    }
}
