<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location')->nullable();
            $table->string('price')->nullable();
            $table->string('time')->nullable();
            $table->dateTime('booking_time')->nullable();
            $table->enum('status', ['cancelled', 'pending', 'approved', 'rejected', 'postponed', 'postponed_updated', 'payment_requested', 'payment_approved', 'payment_rejected', 'payment_delivered', 'admin_requested', 'admin_rejected', 'disputed', 'partial_refund_requested', 'payment_refunded'])->nullable();
            $table->bigInteger('booked_by')->unsigned();
            $table->foreign('booked_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('gig_type', ['custom', 'gig', 'group', 'teaching_studio', 'accompanist'])->nullable();
            $table->text('notes')->nullable();
            $table->string('event_name')->nullable();
            $table->text('booking_description')->nullable();
            $table->bigInteger('gig_id')->unsigned()->nullable();
            $table->foreign('gig_id')->references('id')->on('post_events')->onDelete('cascade');
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->bigInteger('teaching_studio_id')->unsigned()->nullable();
            $table->foreign('teaching_studio_id')->references('id')->on('teaching_studios')->onDelete('cascade');
            $table->bigInteger('accompanist_id')->unsigned()->nullable();
            $table->foreign('accompanist_id')->references('id')->on('accompanists')->onDelete('cascade');
            $table->string('stripe_charge_id')->nullable();
            $table->boolean('is_viewed_by_user')->default(0);
            $table->boolean('is_viewed_by_musician')->default(0);
            $table->boolean('is_reviewed')->default(0);
            $table->boolean('is_user_submitted_evidence')->default(0);
            $table->boolean('is_musician_submitted_evidence')->default(0);
            $table->boolean('is_refunding')->default(0);
            $table->dateTime('dispute_start_time_utc')->nullable();
            $table->string('partial_refund_requested_percentage')->nullable();
            $table->string('partial_refund_reason')->nullable();
            $table->string('tip_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('bookings');
    }

}
