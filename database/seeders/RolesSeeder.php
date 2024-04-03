<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //B::table('roles')->delete();
        DB::table('roles')->insert([
            ['nama_role' => 'Owner',
             'nominal_gaji'=> 0,
             'created_at' => now(),
             'updated_at' => now()
            ],
            ['nama_role' => 'Admin',
             'nominal_gaji'=> 3000000,
             'created_at' => now(),
             'updated_at' => now()
            ],
            ['nama_role' => 'Manajer Operasional',
             'nominal_gaji'=> 3000000,
             'created_at' => now(),
             'updated_at' => now()
            ],
            ['nama_role' => 'Kurir',
             'nominal_gaji'=> 2500000,
             'created_at' => now(),
             'updated_at' => now()
            ],
             ['nama_role'=>'Koki',
             'nominal_gaji'=> 2500000,
             'created_at' => now(),
             'updated_at' => now()
             ]
        ]);
    }
}
