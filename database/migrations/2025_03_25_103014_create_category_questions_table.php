<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('question');
            $table->string('field_type')->default('text'); // text, textarea, select, checkbox, etc.
            $table->string('icon', 50)->nullable();
            $table->string('placeholder')->nullable();
            $table->json('options')->nullable(); // For select, radio, checkbox options
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_questions');
    }
};
