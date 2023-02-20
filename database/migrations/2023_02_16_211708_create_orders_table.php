<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer(Order::MAIL_ID)->unique()->index();
            $table->string(Order::SUBJECT);
            $table->string(Order::RECEIVED_FROM);
            $table->text(Order::BODY);
            $table->timestamp(Order::RECEIVED_AT);
            $table->timestamp(Order::REPLIED_AT)->nullable();
            $table->string(Order::REPLY_MESSAGE)->nullable();
            $table->timestamp(Order::SEEN_AT)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
