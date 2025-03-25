<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lead_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default lead types
        \Illuminate\Support\Facades\DB::table('lead_types')->insert([
            ['name' => 'Unqualified Lead', 'slug' => 'unqualified', 'description' => 'Campaign Lead', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Qualified Lead', 'slug' => 'qualified', 'description' => 'Call Centre Verified', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Converted Lead', 'slug' => 'converted', 'description' => 'Contract Signed', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('lead_types');
    }
};
