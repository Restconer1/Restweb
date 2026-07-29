<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index(): void
    {
        $this->view('admin/users/index', [
            'title' => 'Manage Users — RESTEBOOKS',
            'users' => User::all(200),
        ], 'layouts/admin');
    }

    public function suspend(int $id): void
    {
        User::update($id, ['status' => 'suspended']);
        $this->flash('success', 'User suspended.');
        $this->redirect('/admin/users');
    }

    public function activate(int $id): void
    {
        User::update($id, ['status' => 'active']);
        $this->flash('success', 'User reactivated.');
        $this->redirect('/admin/users');
    }

    public function destroy(int $id): void
    {
        User::delete($id);
        $this->flash('success', 'User deleted.');
        $this->redirect('/admin/users');
    }
}
