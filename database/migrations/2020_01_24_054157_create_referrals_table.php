<?php

use Davidnadejdin\LaravelReferral\Models\Referral;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralsTable extends Migration
{
    public function up()
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->unsignedBigInteger('referral_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('referrals');
    }
}
