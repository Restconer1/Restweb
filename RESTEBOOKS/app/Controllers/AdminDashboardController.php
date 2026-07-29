<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class AdminDashboardController extends Controller
{
    public function index(): void
    {
        $db = Database::connection();

        $stats = [
            'total_users' => (int) $db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
            'active_subscribers' => (int) $db->query("SELECT COUNT(*) FROM subscriptions WHERE status='active' AND expires_at > NOW()")->fetchColumn(),
            'total_revenue' => (float) $db->query("SELECT COALESCE(SUM(amount),0) FROM payments WHERE status='success'")->fetchColumn(),
            'books_uploaded' => (int) $db->query("SELECT COUNT(*) FROM books")->fetchColumn(),
            'books_downloaded' => (int) $db->query("SELECT COUNT(*) FROM download_history")->fetchColumn(),
        ];

        $mostDownloaded = $db->query(
            "SELECT title, downloads_count FROM books ORDER BY downloads_count DESC LIMIT 5"
        )->fetchAll();

        $recentPayments = $db->query(
            "SELECT p.*, u.full_name, u.email FROM payments p
             JOIN users u ON u.id = p.user_id
             ORDER BY p.created_at DESC LIMIT 10"
        )->fetchAll();

        $recentUsers = $db->query(
            "SELECT id, full_name, email, created_at FROM users ORDER BY created_at DESC LIMIT 10"
        )->fetchAll();

        $monthlyIncome = $db->query(
            "SELECT DATE_FORMAT(paid_at, '%Y-%m') AS month, SUM(amount) AS total
             FROM payments WHERE status='success' AND paid_at IS NOT NULL
             GROUP BY month ORDER BY month DESC LIMIT 6"
        )->fetchAll();

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard — RESTEBOOKS',
            'stats' => $stats,
            'mostDownloaded' => $mostDownloaded,
            'recentPayments' => $recentPayments,
            'recentUsers' => $recentUsers,
            'monthlyIncome' => array_reverse($monthlyIncome),
        ], 'layouts/admin');
    }
}
