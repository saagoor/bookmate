<?php

namespace App\Http\Controllers;

use App\Models\Challange;
use Illuminate\Http\Request;

class ChallangeController extends Controller
{
    public function __construct() {
        $this->middleware(['auth'])->only(['join', 'updateParticipant']);
    }

    public function index()
    {
        $challanges = $this->search(Challange::class)->paginate(10);
        $challanges->load(['book', 'user', 'participants']);
        return view('challanges.index', compact('challanges'));
    }

    public function create()
    {
        return view('challanges.create');
    }

    public function show(Challange $challange)
    {
        return view('challanges.show', compact('challange'));
    }

    public function join(Challange $challange)
    {
        $challange->participants()->syncWithoutDetaching(auth()->user());
        return back()->with('success', 'Congratulation, you have taken this challange. Good luck.');
    }

    public function updateParticipant(Request $request, Challange $challange)
    {
        $request->validate([
            'percentage'    => 'required|integer|between:0,100'
        ]);

        $challange->participants()->sync([auth()->user()->id => ['percentage' => $request->percentage]], false);

        return back()->with('success', 'Your reading percentage has been updated.');
    }
}
