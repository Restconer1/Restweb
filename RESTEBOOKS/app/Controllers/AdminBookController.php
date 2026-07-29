<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Csrf;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;

class AdminBookController extends Controller
{
    private const ALLOWED_EBOOK_EXT = ['pdf', 'epub', 'docx', 'zip', 'rar'];
    private const ALLOWED_COVER_EXT = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_EBOOK_BYTES = 100 * 1024 * 1024; // 100MB
    private const MAX_COVER_BYTES = 5 * 1024 * 1024;   // 5MB

    public function index(): void
    {
        $this->view('admin/books/index', [
            'title' => 'Manage Books — RESTEBOOKS',
            'books' => Book::all(200),
        ], 'layouts/admin');
    }

    public function create(): void
    {
        $this->view('admin/books/upload', [
            'title' => 'Upload Ebook — RESTEBOOKS',
            'categories' => Category::all(50),
            'authors' => Author::all(200),
        ], 'layouts/admin');
    }

    public function store(): void
    {
        if (!Csrf::verify($this->input('csrf_token'))) {
            $this->flash('error', 'Session expired, please retry.');
            $this->redirect('/admin/books/create');
            return;
        }

        $title = trim((string) $this->input('title', ''));
        if ($title === '') {
            $this->flash('error', 'Title is required.');
            $this->redirect('/admin/books/create');
            return;
        }

        // Ebooks are stored OUTSIDE the web root — they can only be reached
        // via the authenticated /books/{slug}/download paywall route.
        // Covers are stored under public/uploads so <img> tags can load them.
        $ebookPath = $this->storeUpload('ebook_file', BASE_PATH . '/storage/ebooks', self::ALLOWED_EBOOK_EXT, self::MAX_EBOOK_BYTES);
        $coverPath = $this->storeUpload('cover_image', BASE_PATH . '/public/uploads/covers', self::ALLOWED_COVER_EXT, self::MAX_COVER_BYTES);

        if ($ebookPath === false || $coverPath === false) {
            $this->flash('error', 'Upload failed validation — check file type/size and try again.');
            $this->redirect('/admin/books/create');
            return;
        }

        $slug = $this->slugify($title) . '-' . substr(md5(uniqid('', true)), 0, 6);

        Book::insert([
            'title' => $title,
            'slug' => $slug,
            'author_id' => (int) $this->input('author_id') ?: null,
            'category_id' => (int) $this->input('category_id') ?: null,
            'description' => trim((string) $this->input('description', '')),
            'language' => trim((string) $this->input('language', 'English')),
            'pages' => (int) $this->input('pages') ?: null,
            'file_path' => $ebookPath ? basename($ebookPath) : null,
            'file_type' => $this->extensionOf($ebookPath) ?: 'pdf',
            'file_size_kb' => $ebookPath ? (int) round(filesize($ebookPath) / 1024) : null,
            'cover_path' => $coverPath ? basename($coverPath) : null,
            'is_premium' => $this->input('is_premium') ? 1 : 0,
            'is_featured' => $this->input('is_featured') ? 1 : 0,
            'status' => $this->input('status', 'draft'),
            'published_at' => $this->input('status') === 'published' ? date('Y-m-d H:i:s') : null,
        ]);

        $this->flash('success', 'Ebook uploaded.');
        $this->redirect('/admin/books');
    }

    public function destroy(int $id): void
    {
        Book::delete($id);
        $this->flash('success', 'Book removed.');
        $this->redirect('/admin/books');
    }

    /**
     * Validates and moves an uploaded file outside the web root.
     * Returns the stored path, null if no file was sent, or false on
     * validation failure.
     */
    private function storeUpload(string $field, string $destinationDir, array $allowedExt, int $maxBytes)
    {
        if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $file = $_FILES[$field];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        if ($file['size'] > $maxBytes) {
            return false;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) {
            return false;
        }

        // Never trust the client MIME type; sniff finfo instead as a second check.
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = [
            'pdf' => ['application/pdf'],
            'epub' => ['application/epub+zip', 'application/zip'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip'],
            'zip' => ['application/zip'],
            'rar' => ['application/x-rar-compressed', 'application/octet-stream'],
            'jpg' => ['image/jpeg'],
            'jpeg' => ['image/jpeg'],
            'png' => ['image/png'],
            'webp' => ['image/webp'],
        ];
        if (!in_array($mime, $allowedMimes[$ext] ?? [], true)) {
            return false;
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $ext;
        $destination = rtrim($destinationDir, '/') . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return false;
        }

        return $destination;
    }

    private function extensionOf($path): ?string
    {
        return $path ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : null;
    }

    private function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
