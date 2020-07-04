<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamp('date');
            $table->foreignId('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
        });
        $events = ['Выставка Пустота', 'Гонка героев', 'Быстрые свидания', 'Колесница озорная'];
        $data = [];
        $cities = DB::table('cities')->pluck('id');
        foreach ($events as $event) {
            $data[] = [
                'title' => $event,
                'date' => Carbon::now()->addDays(mt_rand(1, 10))->addHours(mt_rand(1, 24)),
                'city_id' => $cities->random()
            ];
        }
        DB::table('events')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
