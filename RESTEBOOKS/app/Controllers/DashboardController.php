<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Bookmark;
use App\Models\DownloadHistory;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(): void
    {
        $user = Auth::user();
        $subscription = Subscription::activeFor($user['id']);
        $downloads = DownloadHistory::forUser($user['id']);

        $this->view('user/dashboard', [
            'title' => 'My Dashboard — RESTEBOOKS',
            'user' => $user,
            'subscription' => $subscription,
            'recentDownloads' => array_slice($downloads, 0, 5),
            'downloadCount' => count($downloads),
        ], 'layouts/dashboard');
    }

    public function library(): void
    {
        $user = Auth::user();
        $this->view('user/library', [
            'title' => 'My Library — RESTEBOOKS',
            'downloads' => DownloadHistory::forUser($user['id']),
        ], 'layouts/dashboard');
    }

    public function bookmarks(): void
    {
        $user = Auth::user();
        $this->view('user/bookmarks', [
            'title' => 'Bookmarks — RESTEBOOKS',
            'bookmarks' => Bookmark::forUser($user['id']),
        ], 'layouts/dashboard');
    }

    public function subscription(): void
    {
        $user = Auth::user();
        $this->view('user/subscription', [
            'title' => 'Subscription — RESTEBOOKS',
            'subscription' => Subscription::activeFor($user['id']),
        ], 'layouts/dashboard');
    }

    public function payments(): void
    {
        $user = Auth::user();
        $this->view('user/payments', [
            'title' => 'Payment History — RESTEBOOKS',
            'payments' => Payment::historyFor($user['id']),
        ], 'layouts/dashboard');
    }

    public function profile(): void
    {
        $this->view('user/profile', [
            'title' => 'My Profile — RESTEBOOKS',
            'user' => Auth::user(),
        ], 'layouts/dashboard');
    }

    public function updateProfile(): void
    {
        $user = Auth::user();
        User::update($user['id'], [
            'full_name' => trim((string) $this->input('full_name', $user['full_name'])),
            'phone' => trim((string) $this->input('phone', $user['phone'] ?? '')),
        ]);
        $this->flash('success', 'Profile updated.');
        $this->redirect('/dashboard/profile');
    }
}
