<?php

use Illuminate\Database\Seeder;

class SampleObjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<10; ++$i)
        {
            DB::table('sample_objects')->insert(['content' => 'SampleObject content' . $i]);
        }
    }
}
