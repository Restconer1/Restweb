<?php

use App\Controllers\AdminAuthController;
use App\Controllers\AdminBookController;
use App\Controllers\AdminDashboardController;
use App\Controllers\AdminUserController;
use App\Controllers\AuthController;
use App\Controllers\BookController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\PaymentController;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

/** @var \App\Core\Router $router */

// ---- Public pages ----------------------------------------------------
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/faq', [HomeController::class, 'faq']);
$router->get('/contact', [HomeController::class, 'contact']);
$router->post('/contact', [HomeController::class, 'submitContact']);

$router->get('/books', [BookController::class, 'browse']);
$router->get('/books/{slug}', [BookController::class, 'show']);
$router->get('/books/{slug}/download', [BookController::class, 'download']);

$router->get('/pricing', [PaymentController::class, 'pricing']);

// ---- Auth --------------------------------------------------------------
$router->get('/login', [AuthController::class, 'showLogin'], [GuestMiddleware::class]);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister'], [GuestMiddleware::class]);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/forgot-password', [AuthController::class, 'showForgotPassword']);
$router->post('/forgot-password', [AuthController::class, 'sendResetLink']);
$router->get('/reset-password/{token}', [AuthController::class, 'showResetPassword']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);

// ---- Payment / subscription (requires login) ---------------------------
$router->get('/payment/initialize', [PaymentController::class, 'initialize'], [AuthMiddleware::class]);
$router->get('/payment/verify', [PaymentController::class, 'verify'], [AuthMiddleware::class]);

// ---- User dashboard ------------------------------------------------------
$router->get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
$router->get('/dashboard/library', [DashboardController::class, 'library'], [AuthMiddleware::class]);
$router->get('/dashboard/bookmarks', [DashboardController::class, 'bookmarks'], [AuthMiddleware::class]);
$router->get('/dashboard/subscription', [DashboardController::class, 'subscription'], [AuthMiddleware::class]);
$router->get('/dashboard/payments', [DashboardController::class, 'payments'], [AuthMiddleware::class]);
$router->get('/dashboard/profile', [DashboardController::class, 'profile'], [AuthMiddleware::class]);
$router->post('/dashboard/profile', [DashboardController::class, 'updateProfile'], [AuthMiddleware::class]);

// ---- Admin ---------------------------------------------------------------
$router->get('/admin/login', [AdminAuthController::class, 'showLogin']);
$router->post('/admin/login', [AdminAuthController::class, 'login']);
$router->post('/admin/logout', [AdminAuthController::class, 'logout']);

$router->get('/admin/dashboard', [AdminDashboardController::class, 'index'], [AdminMiddleware::class]);

$router->get('/admin/books', [AdminBookController::class, 'index'], [AdminMiddleware::class]);
$router->get('/admin/books/create', [AdminBookController::class, 'create'], [AdminMiddleware::class]);
$router->post('/admin/books', [AdminBookController::class, 'store'], [AdminMiddleware::class]);
$router->post('/admin/books/{id}/delete', [AdminBookController::class, 'destroy'], [AdminMiddleware::class]);

$router->get('/admin/users', [AdminUserController::class, 'index'], [AdminMiddleware::class]);
$router->post('/admin/users/{id}/suspend', [AdminUserController::class, 'suspend'], [AdminMiddleware::class]);
$router->post('/admin/users/{id}/activate', [AdminUserController::class, 'activate'], [AdminMiddleware::class]);
$router->post('/admin/users/{id}/delete', [AdminUserController::class, 'destroy'], [AdminMiddleware::class]);
