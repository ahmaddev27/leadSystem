<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commission_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('lead_type_id')->constrained()->onDelete('cascade');
            $table->decimal('commission_percentage', 5, 2);
            $table->timestamps();

            $table->unique(['category_id', 'lead_type_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commission_structures');
    }
};
