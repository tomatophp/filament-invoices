<?php

namespace TomatoPHP\FilamentInvoices\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceItem;
use TomatoPHP\FilamentLocations\Models\Currency;

class CreateInvoice
{
    public string $for_type;
    public string $for_id;
    public string $from_type;
    public string $from_id;
    public ?string $name= null;
    public ?string $phone= null;
    public ?string $address= null;
    public ?Carbon $due_date = null;
    public ?Carbon $date = null;
    public ?string $status = 'draft';
    public ?string $type = 'push';
    public ?int $currency = null;
    public ?string $notes = null;
    public float $shipping = 0;
    public array $items = [];

    public function for(Model $for): static
    {
        $this->for_type = get_class($for);
        $this->for_id = $for->id;
        $this->name = $for->name;
        $this->phone = $for->phone;
        $this->address = $for->address;

        return $this;
    }

    public function from(Model $from): static
    {
        $this->from_type = get_class($from);
        $this->from_id = $from->id;
        return $this;
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function phone(string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function address(string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function dueDate(Carbon $due_date): static
    {
        $this->due_date = $due_date;
        return $this;
    }

    public function date(Carbon $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function shipping(float $shipping): static
    {
        $this->shipping = $shipping;
        return $this;
    }

    public function status(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function currency(int $currency): static
    {
        $this->currency = $currency;
        return $this;
    }

    public function notes(string $notes): static
    {
        $this->notes = $notes;
        return $this;
    }

    public function items(array|InvoiceItem $items): static
    {
        if(is_array($items)) {
            foreach ($items as $item){
                $this->items[] = $item;
            }
        }
        else {
            $this->items[] = $items;
        }

        return $this;
    }

    public function save()
    {
       $uuid = 'INV-'. \Illuminate\Support\Str::random(8);
       $checkUUID = Invoice::query()->where('uuid', $uuid)->first();
       while($checkUUID){
          $uuid = 'INV-'. \Illuminate\Support\Str::random(8);
          $checkUUID = Invoice::query()->where('uuid', $uuid)->first();
       }
       $invoice = new Invoice();
       $invoice->uuid = $uuid;
       $invoice->user_id = auth()->user()->id;
       $invoice->for_type = $this->for_type;
       $invoice->for_id = $this->for_id;
       $invoice->from_type = $this->from_type;
       $invoice->from_id = $this->from_id;
       $invoice->name = $this->name;
       $invoice->phone = $this->phone;
       $invoice->address = $this->address;
       $invoice->due_date = $this->due_date?? Carbon::now();
       $invoice->date = $this->date?? Carbon::now();
       $invoice->status = $this->status;
       $invoice->type = $this->type;
       $invoice->currency_id = $this->currency ?? Currency::query()->where('iso', 'USD')->first()->id;
       $invoice->notes = $this->notes;
       $invoice->shipping = $this->shipping;
       $invoice->save();

       if($invoice){

           foreach ($this->items as $item) {
               $invoice->invoicesItems()->create([
                   'item' => $item->item,
                   'description' => $item->description,
                   'qty' => $item->qty,
                   'price' => $item->price,
                   'discount' => $item->discount,
                   'vat' => $item->vat,
                   'total' => $item->qty * (($item->price + $item->vat) - $item->discount),
               ]);
           }

           $invoice->vat = collect($invoice->invoicesItems)->sum(function($item){
               return $item->qty * $item->vat;
           });
           $invoice->discount = collect($invoice->invoicesItems)->sum(function($item){
               return $item->qty * $item->discount;
           });
           $invoice->total = collect($invoice->invoicesItems)->sum('total');
           $invoice->save();


           $invoice->invoiceLogs()->create([
               'type' => "created",
               'log' => 'Invoice created',
           ]);

           return $invoice;
       }

       else {
           return false;
       }
    }
}
