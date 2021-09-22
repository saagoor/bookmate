<?php

namespace App\Http\Controllers;

use App\Models\Challange;
use Illuminate\Http\Request;

class ChallangeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['join', 'updateParticipant']);
    }

    public function index()
    {
        $query = Challange::search();

        if (request('participated') && auth()->check()) {
            $query = $query->whereRelation('participants', 'user_id', auth()->user()->id);
        } else if (auth()->check()) {
            $query = $query->whereRelation('participants', 'user_id', '!=', auth()->user()->id);
        }

        // Load challanges with necessary relations
        $challanges = $query->with(['book.writers', 'book.translators', 'user', 'participants'])->paginate(5);
        $new_count = null;
        $participated_count = null;

        if (auth()->check()) {
            $new_count = Challange::where('finish_at', '>=', now())
                ->whereRelation('participants', 'user_id', '!=', auth()->user()->id)
                ->count();

            $participated_count = Challange::whereRelation('participants', 'user_id', auth()->user()->id)->count();
        }

        return view('challanges.index', compact('challanges', 'new_count', 'participated_count'));
    }

    public function create()
    {
        return view('challanges.create');
    }

    public function store(Request $request)
    {
        $challange = $request->validate([
            'book_id'   => 'required|integer|exists:books,id',
            'finish_at' => 'required|date|after:tomorrow'
        ]);

        $challange['user_id'] = $request->user()->id;
        $challange = Challange::create($challange);
        $challange->addParticipant($request->user());
        return redirect()->route('challanges.show', $challange)->with('success', 'You have created a new challange successfully.');
    }

    public function show(Challange $challange)
    {
        return view('challanges.show', compact('challange'));
    }

    public function join(Challange $challange)
    {
        $challange->addParticipant(auth()->user());
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

    public function invite(Request $request, Challange $challange)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $challange->invite($request->email);
    }
}
