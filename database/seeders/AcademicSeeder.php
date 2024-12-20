<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academics = [
            /* Ilmu Komputer */
            [
                'name' => 'Teknik Informatika',
                'status' => 1,
                'faculty_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sistem Komputer',
                'status' => 1,
                'faculty_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sistem Informasi',
                'status' => 1,
                'faculty_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Desain Komunikasi Visual',
                'status' => 1,
                'faculty_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Desain Interior',
                'status' => 1,
                'faculty_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sains Data',
                'status' => 1,
                'faculty_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pendidikan Teknologi Informasi',
                'status' => 1,
                'faculty_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            /* Ekonomi dan Bisnis */
            [
                'name' => 'Akuntansi',
                'status' => 1,
                'faculty_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Manajemen',
                'status' => 1,
                'faculty_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Bisnis Digital',
                'status' => 1,
                'faculty_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Hukum Bisnis',
                'status' => 1,
                'faculty_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Pariwisata',
                'status' => 1,
                'faculty_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('tbl_program_studi')->insert($academics);
    }
}
