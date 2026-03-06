<?php

use App\Models\User;
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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->enum('theme', ['light', 'dark', 'system'])->default('system');
            $table->enum('language', ['fr', 'en'])->default('fr');
            $table->string('timezone')->default('Africa/Dakar');
            $table->integer('notification_delay')->default(1);
            $table->enum('notification_unit', ['minutes', 'hours', 'days'])->default('hours');
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
