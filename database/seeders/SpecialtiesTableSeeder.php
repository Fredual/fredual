<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            'Neurología',
            'Quirúrgia',
            'Pedriatria',
            'Cardiologia',
            'Urologia',
            'Ortodoncia'
        ];
        foreach ($specialties as $specialty){
            Specialty::create([
                'nombre' => $specialty
            ]);
        }
    }
}
