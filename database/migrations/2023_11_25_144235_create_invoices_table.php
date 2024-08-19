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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->unique();

            $table->morphs('for');
            $table->morphs('from');

            //Link
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('types')->onDelete('cascade');

            //Customer Info
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->default('push')->nullable();

            //Status
            $table->string('status')->default('pending')->nullable();

            //Amounts
            $table->double('total')->default(0);
            $table->double('discount')->default(0);
            $table->double('shipping')->default(0);
            $table->double('vat')->default(0);
            $table->double('paid')->default(0);

            //Dates
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();

            //Options
            $table->boolean('is_activated')->default(0)->nullable();
            $table->boolean('is_offer')->default(0)->nullable();
            $table->boolean('insert_in_to_inventory')->default(0)->nullable();
            $table->boolean('send_email')->default(0)->nullable();

            //Bank Account
            $table->foreignId('currency_id')->nullable()->constrained('currencies');
            $table->boolean('is_bank_transfer')->default(false)->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_account_owner')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('bank_swift')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_city')->nullable();
            $table->string('bank_country')->nullable();

            //Has Note
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
