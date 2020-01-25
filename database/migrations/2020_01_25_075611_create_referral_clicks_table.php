<?php

use Davidnadejdin\LaravelReferral\Models\Referral\Click;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Click::getModel()->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip');
            $table->unsignedBigInteger('referral_id');

            $table->unique([
                'ip',
                'referral_id',
            ]);

            $table->foreign('referral_id')->references('id')
                ->on(config('referral.model')::getModel()->getTable());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Click::getModel()->getTable());
    }
}
