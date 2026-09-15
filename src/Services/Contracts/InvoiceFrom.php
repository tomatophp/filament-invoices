<?php

namespace TomatoPHP\FilamentInvoices\Services\Contracts;

class InvoiceFrom
{
    public string $label;

    public string $model;

    public string $column = 'name';

    final public function __construct() {}

    public static function make(string $model): static
    {
        return (new static)->model($model);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function model(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function column(string $column): static
    {
        $this->column = $column;

        return $this;
    }
}
