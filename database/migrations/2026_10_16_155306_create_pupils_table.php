<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('pupils', function (Blueprint $table) {
        $table->id();

        $table->foreignId('school_class_id')
            ->constrained('school_classes')
            ->cascadeOnDelete();

        $table->string('full_name', 150);

        $table->date('birth_date');

        $table->string('email', 100)
            ->unique();

        $table->decimal('average_score', 3, 2);

        $table->boolean('has_benefit')
            ->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('pupils');
}
};
