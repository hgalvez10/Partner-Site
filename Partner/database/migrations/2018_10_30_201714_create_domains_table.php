<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domainName');
            $table->string('sld');
            $table->string('tld');
            $table->string('ns');
            $table->string('registrant_id');
            $table->string('admin_contact_id');
            $table->string('billing_contact_id');
            $table->string('tech_contact_id');
            $table->timestamp('renew_date')->nullable()->default(null);
            $table->timestamp('expirate_date')->nullable()->default(null);
            $table->timestamp('terminate_date')->nullable()->default(null);
            $table->string('authinfo');
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
        Schema::dropIfExists('domains');
    }
}
