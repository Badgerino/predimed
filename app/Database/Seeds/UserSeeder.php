<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $existing = $this->db->table('users')->where('username', 'admin')->get()->getRow();

        if ($existing) {
            return;
        }

        $this->db->table('users')->insert([
            'username'   => 'admin',
            'email'      => 'admin@predimed.local',
            'password'   => password_hash('admin123', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
