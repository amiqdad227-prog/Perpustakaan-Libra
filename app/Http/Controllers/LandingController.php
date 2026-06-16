<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Category;
use App\Models\Loan;

class LandingController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalMembers = Member::count();
        $totalCategories = Category::count();
        $totalLoans = Loan::count();
        $latestBooks = Book::with('category')->latest()->take(4)->get();

        return view('landing', compact(
            'totalBooks',
            'totalMembers',
            'totalCategories',
            'totalLoans',
            'latestBooks'
        ));
    }
}