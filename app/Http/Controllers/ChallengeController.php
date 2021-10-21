<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['join', 'updateParticipant']);
    }

    public function index()
    {
        $query = Challenge::search();

        if (request('participated') && auth()->check()) {
            $query = $query->whereRelation('participants', 'user_id', auth()->user()->id);
        } else if (auth()->check()) {
            $query = $query->whereRelation('participants', 'user_id', '!=', auth()->user()->id);
        }

        // Load challenges with necessary relations
        $challenges = $query->with([
            'book.writers',
            'book.translators',
            'user',
            'participants',
            'discussion',
        ])->paginate(5);
        $new_count = null;
        $participated_count = null;

        if (auth()->check()) {
            $new_count = Challenge::where('finish_at', '>=', now())
                ->whereRelation('participants', 'user_id', '!=', auth()->user()->id)
                ->count();

            $participated_count = Challenge::whereRelation('participants', 'user_id', auth()->user()->id)->count();
        }

        return view('challenges.index', compact('challenges', 'new_count', 'participated_count'));
    }

    public function create()
    {
        return view('challenges.create');
    }

    public function store(Request $request)
    {
        $challenge = $request->validate([
            'book_id'   => 'required|integer|exists:books,id',
            'finish_at' => 'required|date|after:tomorrow'
        ]);

        $challenge['user_id'] = $request->user()->id;
        $challenge = Challenge::create($challenge);
        $challenge->addParticipant($request->user());
        return redirect()->route('challenges.show', $challenge)->with('success', 'You have created a new challenge successfully.');
    }

    public function show(Challenge $challenge)
    {
        return view('challenges.show', compact('challenge'));
    }

    public function join(Challenge $challenge)
    {
        $challenge->addParticipant(auth()->user());
        return back()->with('success', 'Congratulation, you have taken this challenge. Good luck.');
    }

    public function updateParticipant(Request $request, Challenge $challenge)
    {
        $request->validate([
            'percentage'    => 'required|integer|between:0,100'
        ]);

        if($request->percentage == 100){
            // Increment book's read count
            $challenge->book->reads()->syncWithoutDetaching([$request->user()->id => ['user_id' => $request->user()->id]]);
        }

        $challenge->participants()->sync([auth()->user()->id => ['percentage' => $request->percentage]], false);

        return back()->with('success', 'Your reading percentage has been updated.');
    }

    public function invite(Request $request, Challenge $challenge)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $challenge->invite($request->email);
    }
}
