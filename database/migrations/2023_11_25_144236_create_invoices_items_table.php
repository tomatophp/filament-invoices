<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_items', function (Blueprint $table) {
            $table->id();

            $table->string('type')->default('item')->nullable();

            //Link
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');

            //Item
            $table->string('item_type')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();

            //Item
            $table->string('item')->nullable();
            $table->string('description')->nullable();
            $table->string('note')->nullable();

            //Prices
            $table->double('qty')->default(1)->nullable();
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->double('vat')->default(0);
            $table->double('total')->default(0);

            //Returned
            $table->double('returned_qty')->default(0);
            $table->double('returned')->default(0);

            //Is Free
            $table->boolean('is_free')->default(0)->nullable();
            $table->boolean('is_returned')->default(0)->nullable();

            $table->json('options')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices_items');
    }
};
