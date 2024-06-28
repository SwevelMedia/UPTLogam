<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\SubProses;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder for users
        $users = [
            [
                'name' => 'Admin',
                'nip' => '1234567890',
                'role' => 'admin',
                'email' => 'admin@gmail.com',
            ],
            [
                'name' => 'PPIC',
                'nip' => '1234567891',
                'role' => 'ppic',
                'email' => 'ppic@gmail.com',
            ],
            [
                'name' => 'Drafter',
                'nip' => '1234567892',
                'role' => 'drafter',
                'email' => 'drafter@gmail.com',
            ],
            [
                'name' => 'Programmer',
                'nip' => '1234567892',
                'role' => 'programmer',
                'email' => 'programmer@gmail.com',
            ],
            [
                'name' => 'Toolman',
                'nip' => '1234567894',
                'role' => 'toolman',
                'email' => 'toolman@gmail.com',
            ],
            [
                'name' => 'Operator',
                'nip' => '1234567895',
                'role' => 'operator',
                'email' => 'operator@gmail.com',
            ],
            [
                'name' => 'Operator2',
                'nip' => '1234567895',
                'role' => 'operator',
                'email' => 'operator2@gmail.com',
            ],
            [
                'name' => 'Machiner',
                'nip' => '1234567895',
                'role' => 'machiner',
                'email' => 'machiner@gmail.com',
            ],
        ];

        foreach ($users as $user) {
            $user['tanggal_masuk'] = now();
            $user['password'] = Hash::make('123456');
            DB::table('users')->insert($user);
        }

        // Seeder for machines
        $machines = [
            [
                'name' => 'VMC Machine',
                'machine_codes' => ['VMCM1', 'VMCM2', 'VMCM3'],
                'status' => 1,
            ],
            [
                'name' => 'CNC Lathe Machine',
                'machine_codes' => ['CNCLM1', 'CNCLM2', 'CNCLM3'],
                'status' => 1,
            ],
        ];

        // Insert data into the machines table
        foreach ($machines as $machine) {
            foreach ($machine['machine_codes'] as $code) {
                DB::table('machines')->insert([
                    'name' => $machine['name'],
                    'machine_code' => $code,
                    'status' => $machine['status'],
                ]);
            }
        }


        $tools = [
            ['tool_name' => 'Piston Mold', 'size' => '10', 'tool_code' => 'PM001', 'status' => '1'],
            ['tool_name' => 'Piston Mold', 'size' => '10', 'tool_code' => 'PM002', 'status' => '1'],
            ['tool_name' => 'Crucible', 'size' => '20', 'tool_code' => 'CR001', 'status' => '1'],
            ['tool_name' => 'Crucible', 'size' => '20', 'tool_code' => 'CR002', 'status' => '1'],
            ['tool_name' => 'Foundry Ladle', 'size' => '30', 'tool_code' => 'FL001', 'status' => '1'],
            ['tool_name' => 'Foundry Ladle', 'size' => '30', 'tool_code' => 'FL002', 'status' => '1'],
            ['tool_name' => 'Tongs', 'size' => '40', 'tool_code' => 'TN001', 'status' => '1'],
            ['tool_name' => 'Tongs', 'size' => '40', 'tool_code' => 'TN002', 'status' => '1'],
            ['tool_name' => 'Molding Sand', 'size' => '50', 'tool_code' => 'MS001', 'status' => '1'],
            ['tool_name' => 'Molding Sand', 'size' => '50', 'tool_code' => 'MS002', 'status' => '1'],
            ['tool_name' => 'Pouring Cup', 'size' => '60', 'tool_code' => 'PC001', 'status' => '1'],
            ['tool_name' => 'Pouring Cup', 'size' => '60', 'tool_code' => 'PC002', 'status' => '1'],
            ['tool_name' => 'Casting Flask', 'size' => '70', 'tool_code' => 'CF001', 'status' => '1'],
            ['tool_name' => 'Casting Flask', 'size' => '70', 'tool_code' => 'CF002', 'status' => '1'],
            ['tool_name' => 'Pattern', 'size' => '80', 'tool_code' => 'PT001', 'status' => '1'],
            ['tool_name' => 'Pattern', 'size' => '80', 'tool_code' => 'PT002', 'status' => '1'], // Sama dengan sebelumnya
            ['tool_name' => 'Core Box', 'size' => '90', 'tool_code' => 'CB001', 'status' => '1'],
            ['tool_name' => 'Core Box', 'size' => '90', 'tool_code' => 'CB002', 'status' => '1'],
            ['tool_name' => 'Sprue Cutter', 'size' => '100', 'tool_code' => 'SC001', 'status' => '1'],
            ['tool_name' => 'Sprue Cutter', 'size' => '100', 'tool_code' => 'SC002', 'status' => '1'],
            ['tool_name' => 'Crucible Tongs', 'size' => '110', 'tool_code' => 'CT01', 'status' => '1'],
            ['tool_name' => 'Crucible Tongs', 'size' => '110', 'tool_code' => 'CT02', 'status' => '1'],
            ['tool_name' => 'Mold Release Agent', 'size' => '120', 'tool_code' => 'MR001', 'status' => '1'],
            ['tool_name' => 'Mold Release Agent', 'size' => '120', 'tool_code' => 'MR002', 'status' => '1'],
            ['tool_name' => 'Riser Sleeve', 'size' => '130', 'tool_code' => 'RS001', 'status' => '1'],
            ['tool_name' => 'Riser Sleeve', 'size' => '130', 'tool_code' => 'RS002', 'status' => '1'],
            ['tool_name' => 'Cope', 'size' => '140', 'tool_code' => 'CP001', 'status' => '1'],
            ['tool_name' => 'Cope', 'size' => '140', 'tool_code' => 'CP002', 'status' => '1'],
            ['tool_name' => 'Cope', 'size' => '140', 'tool_code' => 'CP003', 'status' => '1'], // Sama dengan sebelumnya
            ['tool_name' => 'Drag', 'size' => '150', 'tool_code' => 'DR001', 'status' => '1'],
            ['tool_name' => 'Drag', 'size' => '150', 'tool_code' => 'DR002', 'status' => '1'],
            ['tool_name' => 'Skimming Spoon', 'size' => '160', 'tool_code' => 'SS001', 'status' => '1'],
            ['tool_name' => 'Skimming Spoon', 'size' => '160', 'tool_code' => 'SS002', 'status' => '1'],
            ['tool_name' => 'Ingot Mold', 'size' => '170', 'tool_code' => 'IM001', 'status' => '1'],
            ['tool_name' => 'Ingot Mold', 'size' => '170', 'tool_code' => 'IM002', 'status' => '1'],
            ['tool_name' => 'Vibrating Table', 'size' => '180', 'tool_code' => 'VT001', 'status' => '1'],
            ['tool_name' => 'Vibrating Table', 'size' => '180', 'tool_code' => 'VT002', 'status' => '1'],
        ];

        // Insert data into the database
        DB::table('tools')->insert($tools);

        $previousMonth = date('Y-m', strtotime('-1 month'));
        // Data dummy untuk diisi ke tabel clients
        $clients = [
            [
                'name' => 'PT Cahaya Gemilang ',
                'phone' => '085702848252',
                'address' => 'Jl. Cendrawasih No. 789, Surabaya',
                'created_at' => date('Y-m-d H:i:s', strtotime($previousMonth)),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'PT Inti Makmur ',
                'phone' => '085702848252',
                'address' => 'Jl. Diponegoro No. 567, Yogyakarta',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Masukkan data dummy ke dalam tabel clients
        foreach ($clients as $client) {
            DB::table('clients')->insert($client);
        }

        $orders = [];

        $cncProducts = ['Gear', 'Bracket', 'Pulley', 'Shaft', 'Plate', 'Block', 'Cam', 'Coupling', 'Flange', 'Hub'];
        $materials = ['Aluminium', 'Steel', 'Kayu', 'Titanium', 'Plastic', 'Cast Iron', 'Bronze']; // Contoh jenis material

        // Misalkan kita ingin membuat pesanan untuk produk-produk mesin

        $previousMonth = date('Y-m', strtotime('-1 month'));
        $thisMonth = date('Y-m', strtotime('0 month'));

        for ($i = 0; $i < 3; $i++) {
            if($i<3){
                $orderNumber = "ORD-" . date('ym', strtotime($previousMonth)) . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            }else{
                $orderNumber = "ORD-" . date('ym', strtotime($thisMonth)) . str_pad($i-3 + 1, 3, '0', STR_PAD_LEFT);
            }

            if ($i < 1) {
                $createdAt = date('Y-m-d H:i:s', strtotime($previousMonth)); // Menggunakan bulan sebelumnya
            } else {
                $createdAt = now(); // Menggunakan tanggal saat ini
            }

            $orders[] = [
                'order_number' => $orderNumber,
                'order_name' => $cncProducts[$i % count($cncProducts)],
                'material' => $materials[$i % count($materials)],
                'client_id' => rand(1, 2),
                'status' => 0,
                'created_at' => $createdAt,
                'updated_at' => now()
            ];
        }



        // Memasukkan data pesanan ke dalam tabel
        DB::table('orders')->insert($orders);

        $now = Carbon::now();

        // Data bahan/material yang akan dimasukkan
        $materials = ['Aluminium', 'Steel', 'Brass', 'Titanium', 'Plastic', 'Copper', 'Bronze'];

        // Looping untuk memasukkan data bahan/material ke dalam database
        foreach ($materials as $material) {
            // Masukkan data bahan/material bersama waktu sekarang sebagai created_at dan updated_at
            $data = [
                'name' => $material,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            DB::table('materials')->insert($data);
        }
    }
}
