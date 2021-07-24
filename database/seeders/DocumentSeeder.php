<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Vanguard\Document;

class DocumentSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(Document::class, 50)->create();
    }
}
