<?php

use App\Models\Feedback;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure every existing feedback row has a unique, random response_code
        Feedback::query()
            ->whereNull('response_code')
            ->orWhere('response_code', '=', '111')
            ->chunkById(100, function ($items) {
                foreach ($items as $item) {
                    $item->response_code = (string) Str::uuid();
                    $item->save();
                }
            });

        Schema::table('feedback', function (Blueprint $table) {
            $table->unique('response_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropUnique('feedback_response_code_unique');
        });
    }
};

