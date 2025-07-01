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
    Schema::table('posts', function (Blueprint $table) {
        if (Schema::hasColumn('posts', 'tag_id')) {
            $table->dropColumn('tag_id');
        }
    });
}


public function down(): void
{
    //
}
};
