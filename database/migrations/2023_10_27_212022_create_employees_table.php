<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->required(); // First name (required)
            $table->string('last_name')->required(); // Last name (required)
            $table->unsignedBigInteger('company_id'); // Company (foreign key)
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade'); // Add onDelete('cascade') here
            $table->string('email')->nullable(); // Email
            $table->string('phone')->nullable(); // Phone
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
        Schema::dropIfExists('employees');
    }
}
