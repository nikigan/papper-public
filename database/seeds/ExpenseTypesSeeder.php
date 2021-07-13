<?php

use Illuminate\Database\Seeder;
use Vanguard\ExpenseType;
use Vanguard\VatRate;

class ExpenseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpenseType::query()->create([
            "id" => 700,
            "name" => "700 - Equipment",
            "vat_rate_id" => VatRate::first()->id
        ]);
    }
}
