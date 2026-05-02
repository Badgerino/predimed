<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Find a user by username.
     */
    public function findByUsername(string $username)
    {
        return $this->where('username', trim($username))->first();
    }

    /**
     * Verify username/password. Returns user object without password on success, false on failure.
     */
    public function verifyCredentials(string $username, string $password)
    {
        $user = $this->findByUsername($username);

        if (! $user || ! isset($user->password)) {
            return false;
        }

        $storedPassword = (string) $user->password;
        $isValid = false;

        // Support legacy plain-text passwords and auto-upgrade to hash after successful login.
        if (password_get_info($storedPassword)['algo'] === null || password_get_info($storedPassword)['algo'] === 0) {
            if (hash_equals($storedPassword, $password)) {
                $isValid = true;
                $this->update($user->id, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
            }
        } elseif (password_verify($password, $storedPassword)) {
            $isValid = true;

            if (password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
                $this->update($user->id, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
            }
        }

        if ($isValid) {
            unset($user->password);
            return $user;
        }

        return false;
    }

    /**
     * Create a new user (hashes password if provided).
     */
    public function createUser(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->insert($data);
    }
}

