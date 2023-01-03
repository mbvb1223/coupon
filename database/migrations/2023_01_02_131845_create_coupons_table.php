<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('key', 64)->unique();
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('quota')->default(0);
            $table->text('qr');
            $table->unsignedBigInteger('price');
            $table->unsignedTinyInteger('type');
            $table->unsignedBigInteger('coupon_category_id')->nullable();
            $table->unsignedBigInteger('redemption_id')->nullable();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();

            $table->foreign('coupon_category_id')
                ->references('id')
                ->on('coupon_categories')
                ->onDelete('restrict');
            $table->foreign('redemption_id')
                ->references('id')
                ->on('redemptions')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
