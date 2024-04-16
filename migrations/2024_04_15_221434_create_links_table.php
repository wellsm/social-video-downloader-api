<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->string('id');
            $table->string('platform', 50);
            $table->string('source_url', 300)->unique();
            $table->string('destination_url', 1000);
            $table->datetime('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
}
