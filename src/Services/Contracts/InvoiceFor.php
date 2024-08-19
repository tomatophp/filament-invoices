<?php

namespace TomatoPHP\FilamentInvoices\Services\Contracts;

class InvoiceFor
{
    public string $label;
    public string $model;
    public string $column = 'name';

    public static function make(string $model)
    {
        return (new static())->model($model);
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
