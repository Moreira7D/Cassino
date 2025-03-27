<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UpdateTables extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::table("settings", function ($table) {
            // $table->boolean('ezzepay_is_enable')->default(false);
            $table->decimal("limit_withdrawal")->nullable();
            $table->boolean("withdrawal_autom")->default(1);
        });
        Schema::table('withdrawals', function ($table) {
            $table->string('cpf')->nullable();
            $table->string('name')->nullable();
        });
        // Schema::table('gateways', function ($table) {
        //     $table->string('ezze_uri')->nullable();
        //     $table->string('ezze_client')->nullable();
        //     $table->string('ezze_secret')->nullable();
        //     $table->string('ezze_user')->nullable();
        //     $table->string('ezze_senha')->nullable();
        // });
        // Schema::table('games_keys', function ($table) {
        //     $table->string('playfiver_url')->nullable();
        //     $table->string('playfiver_secret')->nullable();
        //     $table->string('playfiver_code')->nullable();
        //     $table->string('playfiver_token')->nullable();
        // });
    }
}
