<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->back()->with('error', 'Username and password are required.');
        }

        $userModel = new UserModel();
        $user = $userModel->verifyCredentials($username, $password);

        if ($user !== false) {
            $session = session();
            $session->regenerate();
            $session->set([
                'user_id'      => $user->id,
                'username'     => $user->username ?? null,
                'is_logged_in' => true,
            ]);

            return redirect()->to('/landingpage');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}