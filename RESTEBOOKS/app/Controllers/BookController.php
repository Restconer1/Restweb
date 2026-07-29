<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\DownloadHistory;
use App\Models\Subscription;

class BookController extends Controller
{
    public function browse(): void
    {
        $filters = [
            'q' => $this->input('q'),
            'category' => $this->input('category'),
            'sort' => $this->input('sort', 'newest'),
        ];
        $page = max(1, (int) $this->input('page', 1));
        $perPage = 12;

        $books = Book::browse($filters, $perPage, ($page - 1) * $perPage);
        $categories = Category::all(20);

        $this->view('books/browse', [
            'title' => 'Browse Books — RESTEBOOKS',
            'books' => $books,
            'categories' => $categories,
            'filters' => $filters,
            'page' => $page,
        ]);
    }

    public function show(string $slug): void
    {
        $book = Book::findBySlug($slug);
        if (!$book) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Book not found']);
            return;
        }

        $this->view('books/show', [
            'title' => $book['title'] . ' — RESTEBOOKS',
            'book' => $book,
        ]);
    }

    /**
     * Central paywall gate. Every download link in the app points here
     * instead of a direct file URL, so ebooks in /storage never need to
     * be web-accessible.
     */
    public function download(string $slug): void
    {
        $book = Book::findBySlug($slug);
        if (!$book) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Book not found']);
            return;
        }

        // 1) Not logged in -> go log in, then come back here.
        if (!Auth::checkUser()) {
            $_SESSION['redirect_after_login'] = '/books/' . $slug . '/download';
            $this->flash('error', 'Please log in to download this ebook.');
            $this->redirect('/login');
            return;
        }

        $user = Auth::user();

        // 2) Logged in but no active subscription -> paywall message + pricing.
        if (!Subscription::isActive($user['id'])) {
            $this->flash('paywall', 'You need an active Premium Subscription of ₦1,000 to download this ebook.');
            $this->redirect('/pricing?book=' . urlencode($slug));
            return;
        }

        // 3) Subscribed -> log the download and stream the file.
        DownloadHistory::insert(['user_id' => $user['id'], 'book_id' => $book['id']]);
        Book::incrementDownloads($book['id']);

        $filePath = BASE_PATH . '/storage/ebooks/' . basename($book['file_path'] ?? '');

        if (!$book['file_path'] || !is_file($filePath)) {
            $this->flash('error', 'This ebook file is not available yet. Please check back soon.');
            $this->redirect('/books/' . $slug);
            return;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}
