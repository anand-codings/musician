<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('original_photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('original_cover_photo')->nullable();
            $table->longText('description')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('timezone')->nullable();
            $table->string('rating')->nullable()->default(0);
            $table->string('rating_percentage')->nullable()->default(0);
            $table->string('number_of_reviews')->nullable()->default(0);
            $table->dateTime('last_login')->nullable();
            $table->string('fb_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('since')->nullable();
            $table->boolean('is_web')->default(0);
            $table->enum('type', ['user', 'artist']);
            $table->string('emaillestorecode')->nullable();
            $table->string('social_photo')->nullable();
            $table->string('dob')->nullable();
            $table->boolean('allow_booking')->default(0);
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('language')->nullable();
            $table->string('genre')->nullable();
            $table->string('speciality')->nullable();
            $table->string('gender')->default('male');
            $table->string('artist_lat')->nullable();
            $table->string('artist_lng')->nullable();
            $table->bigInteger('union_id')->nullable()->unsigned();
            $table->foreign('union_id')->references('id')->on('unions')->onDelete('cascade');
            $table->string('account_status')->nullable();
            $table->string('stripe_payout_account_id')->nullable();
            $table->string('stripe_payout_account_public_key')->nullable();
            $table->string('stripe_payout_account_secret_key')->nullable();
            $table->string('stripe_payout_account_info')->nullable();
            $table->string('exp_month')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('card_id')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->boolean('is_bank_account_verified')->default(0);
            $table->boolean('is_online')->default(1);
            $table->boolean('is_private')->default(0);
            $table->boolean('is_active')->default(1);
            $table->boolean('is_returned')->default(0);
            $table->boolean('is_featured_by_admin')->default(0);
            $table->enum('contact_info_privacy', ['musician', 'following', 'customers']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
