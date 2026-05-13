<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $users = [
            [
                'username' => 'admin',
                'password' => 'admin123',
                'role'     => 'superadmin',
            ],
            [
                'username'   => 'bupati_smi',
                'password'   => 'smi12345',
                'role'       => 'bupati',
                'region_key' => 'region-jawa-barat-kota-sukabumi',
            ],
        ];

        foreach ($users as $user) {
            $existing = $userModel->where('username', $user['username'])->first();
            
            if ($existing) {
                if ($userModel->update($existing['id'], $user) === false) {
                    echo "Gagal update {$user['username']}: " . print_r($userModel->errors(), true) . "\n";
                } else {
                    echo "Berhasil update {$user['username']}\n";
                }
            } else {
                if ($userModel->insert($user) === false) {
                    echo "Gagal insert {$user['username']}: " . print_r($userModel->errors(), true) . "\n";
                } else {
                    echo "Berhasil insert {$user['username']}\n";
                }
            }
        }
    }
}
