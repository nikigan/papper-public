<?php

use Illuminate\Database\Seeder;
use Vanguard\VatRate;

class VatRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VatRate::query()->create([
            'vat_rate' => 1
        ]);
        VatRate::query()->create([
            'vat_rate' => 0.66
        ]);
        VatRate::query()->create([
            'vat_rate' => 0
        ]);

    }
}
