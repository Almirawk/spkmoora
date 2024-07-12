<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            ['nama' => 'Event A',
             'deskripsi' =>'Ini deskripsi Event A', 
             'tanggal_mulai' => '2022-01-01', 
             'tanggal_selesai' => '2025-01-01'],
             ['nama' => 'Event B',
             'deskripsi' =>'Ini deskripsi Event B', 
             'tanggal_mulai' => '2022-01-01', 
             'tanggal_selesai' => '2023-01-01'],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
