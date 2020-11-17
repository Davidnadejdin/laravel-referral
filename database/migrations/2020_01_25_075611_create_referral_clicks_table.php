<?php

use Davidnadejdin\LaravelReferral\Models\Referral\Click;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralClicksTable extends Migration
{
    public function up()
    {
        Schema::create('referral_clicks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip');
            $table->unsignedBigInteger('referral_id');

            $table->unique([
                'ip',
                'referral_id',
            ]);

            $table->foreign('referral_id')->references('id')
                ->on('referrals');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_clicks');
    }
}
