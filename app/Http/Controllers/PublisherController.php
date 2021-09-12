<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        $publisher = new Publisher();
        return view('publishers.save', compact('publisher'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        $this->save($request, new Publisher());
        return redirect()->route('admin.publishers')->with('success', 'New publisher has been added.');
    }

    public function edit(Publisher $publisher)
    {
        return view('publishers.save', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $request->validate($this->rules());
        $this->save($request, $publisher);
        return redirect()->route('admin.publishers')->with('success', 'The publisher has been updated.');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return back()->with('success', "The publisher $publisher->name has been deleted.");
    }

    protected function rules()
    {
        return [
            'image' => 'nullable|image',
            'name'  => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'location'  => 'nullable',
        ];
    }

    protected function save(Request $request, Publisher $publisher)
    {
        $publisher->fill($request->only(['name', 'email', 'phone', 'location']));
        if($request->hasFile('image')){
            $publisher->image = $request->image->store('publishers');
        }
        $publisher->save();
        return $publisher;
    }
}
