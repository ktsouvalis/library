<?php

use App\Models\User;
use App\Models\PublicVisit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_visit_counter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('public_visits');
            $table->timestamps();
        });

        $users = User::all();

        foreach ($users as $user) {
            PublicVisit::create([
                'user_id' => $user->id,
                'public_visits' => 0,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public_visit_counter');
    }
};
