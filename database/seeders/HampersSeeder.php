<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HampersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * INSERT INTO `hampers` (`id_hampers`, `nama`, `deskripsi`, `harga`) VALUES
     * (1, 'Paket A', 'Paket A adalah pilihan sempurna untuk Anda yang menginginkan kombinasi manis dan gurih dalam satu hampers. Nikmati Lapis Legit setengah loyang yang lembut dan kaya rasa, disertai dengan Brownies setengah loyang yang lezat. Setiap hampers juga dilengkapi dengan sebuah kotak eksklusif dan kartu ucapan, menjadikannya pilihan ideal untuk hadiah istimewa.', 650000),
     * (2, 'Paket B', 'Paket B menyajikan kombinasi yang menggugah selera dengan sentuhan tradisional. Rasakan kelezatan Lapis Surabaya setengah loyang yang klasik, dipadu dengan Roti Sosis yang lezat dan mengenyangkan. Setiap hampers disajikan dalam sebuah kotak eksklusif beserta kartu ucapan, membuatnya menjadi hadiah yang berkesan untuk kerabat dan teman.', 500000),
     * (3, 'Paket C', 'Paket C menghadirkan pengalaman unik dengan kombinasi rasa yang menawan. Cicipi kelezatan Spikoe setengah loyang yang renyah dan legit, dilengkapi dengan Matcha Creamy Latte yang segar dan memikat. Tiap hampers disajikan dalam sebuah kotak eksklusif dan dilengkapi dengan kartu ucapan, menjadikannya hadiah yang sempurna untuk merayakan momen istimewa.', 350000);
     */
    public function run(): void
    {
        //DB::table('hampers')->delete();
        DB::table('hampers')->insert(
            [
                ['id_hampers' => 1, 'nama_hampers' => 'Paket A', 'foto_hampers' => 'hampers/paket-a.jpg', 'deskripsi_hampers' => 'Paket A adalah pilihan sempurna untuk Anda yang menginginkan kombinasi manis dan gurih dalam satu hampers. Nikmati Lapis Legit setengah loyang yang lembut dan kaya rasa, disertai dengan Brownies setengah loyang yang lezat. Setiap hampers juga dilengkapi dengan sebuah kotak eksklusif dan kartu ucapan, menjadikannya pilihan ideal untuk hadiah istimewa.', 'harga_hampers' => 650000, 'created_at' => now(), 'updated_at' => now()],
                ['id_hampers' => 2, 'nama_hampers' => 'Paket B', 'foto_hampers' => 'hampers/paket-b.jpg', 'deskripsi_hampers' => 'Paket B menyajikan kombinasi yang menggugah selera dengan sentuhan tradisional. Rasakan kelezatan Lapis Surabaya setengah loyang yang klasik, dipadu dengan Roti Sosis yang lezat dan mengenyangkan. Setiap hampers disajikan dalam sebuah kotak eksklusif beserta kartu ucapan, membuatnya menjadi hadiah yang berkesan untuk kerabat dan teman.', 'harga_hampers' => 500000, 'created_at' => now(), 'updated_at' => now()],
                ['id_hampers' => 3, 'nama_hampers' => 'Paket C', 'foto_hampers' => 'hampers/paket-c.jpg', 'deskripsi_hampers' => 'Paket C menghadirkan pengalaman unik dengan kombinasi rasa yang menawan. Cicipi kelezatan Spikoe setengah loyang yang renyah dan legit, dilengkapi dengan Matcha Creamy Latte yang segar dan memikat. Tiap hampers disajikan dalam sebuah kotak eksklusif dan dilengkapi dengan kartu ucapan, menjadikannya hadiah yang sempurna untuk merayakan momen istimewa.', 'harga_hampers' => 350000, 'created_at' => now(), 'updated_at' => now()]
            ]
        );
    }
}
