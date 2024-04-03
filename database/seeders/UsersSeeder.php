<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'nama' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1990-01-01',
                'no_hp' => '1234567890123',
                'saldo' => 0,
                'poin' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Jane Doe',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1995-05-05',
                'no_hp' => '9876543210987',
                'saldo' => 0,
                'poin' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Alice Smith',
                'email' => 'alice@example.com',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1985-12-12',
                'no_hp' => '5555555555555',
                'saldo' => 0,
                'poin' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1988-07-20',
                'no_hp' => '7777777777777',
                'saldo' => 0,
                'poin' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Emily Wilson',
                'email' => 'emily@example.com',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1992-04-15',
                'no_hp' => '9999999999999',
                'saldo' => 0,
                'poin' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Charlie Brown',
                'email' => 'charlie@example.com',
                'password' => Hash::make('password'),
                'tanggal_lahir' => '1993-06-30',
                'no_hp' => '1111111111111',
                'saldo' => 0,
                'poin' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
