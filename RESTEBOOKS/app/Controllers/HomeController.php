<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(): void
    {
        $featured = Book::featured(8);
        $categories = Category::all(20);

        $this->view('home/index', [
            'featured' => $featured,
            'categories' => $categories,
            'title' => 'RESTEBOOKS — Your Premium Digital Library',
        ]);
    }

    public function about(): void
    {
        $this->view('home/about', ['title' => 'About — RESTEBOOKS']);
    }

    public function faq(): void
    {
        $this->view('home/faq', ['title' => 'FAQ — RESTEBOOKS']);
    }

    public function contact(): void
    {
        $this->view('home/contact', ['title' => 'Contact — RESTEBOOKS']);
    }

    public function submitContact(): void
    {
        // Contact form -> messages table. Kept intentionally simple here;
        // wire up validation + persistence the same way AuthController does.
        $this->flash('success', 'Thanks — your message has been received. We\'ll reply by email shortly.');
        $this->redirect('/contact');
    }
}
