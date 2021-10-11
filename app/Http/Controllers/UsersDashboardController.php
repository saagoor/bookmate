<?php

namespace App\Http\Controllers;

use App\Models\Challange;
use App\Models\Exchange;
use Illuminate\Http\Request;

class UsersDashboardController extends Controller
{

    public function index()
    {
        return view('users.dashboard.index');
    }

    public function exchanges()
    {
        $exchanges = Exchange::query()
            ->where('user_id', auth()->user()->id)
            ->orWhereRelation('offers', 'user_id', auth()->user()->id)
            ->with(['user', 'book'])
            ->latest()
            ->paginate();

        return view('users.dashboard.exchanges', compact('exchanges'));
    }

    public function challanges()
    {
        $challanges = Challange::query()
            ->where('user_id', auth()->user()->id)
            ->orWhereRelation('participants', 'user_id', auth()->user()->id)
            ->with(['user', 'book'])
            ->latest()
            ->paginate();

        return view('users.dashboard.challanges', compact('challanges'));
    }
}
