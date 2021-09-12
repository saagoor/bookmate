<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\Request;

class WriterController extends Controller
{

    public function index()
    {
        
    }

    public function create()
    {
        $writer = new Writer();
        return view('writers.save', compact('writer'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        $this->save($request, new Writer());
        return redirect()->route('admin.writers')->with('success', 'New writer has been added.');
    }

    public function edit(Writer $writer)
    {
        return view('writers.save', compact('writer'));
    }

    public function update(Request $request, Writer $writer)
    {
        $request->validate($this->rules());
        $this->save($request, $writer);
        return redirect()->route('admin.writers')->with('success', 'The writer has been updated.');
    }

    public function destroy(Writer $writer)
    {
        $writer->delete();
        return back()->with('success', "The writer $writer->name has been deleted.");
    }

    protected function rules()
    {
        return [
            'image'     => 'nullable|image',
            'name'      => 'required|string',
            'date_of_birth' => 'nullable|date',
            'location'  => 'nullable',
        ];
    }

    protected function save(Request $request, Writer $writer)
    {
        $writer->fill($request->only(['name', 'date_of_birth', 'location']));
        if($request->hasFile('image')){
            $writer->image = $request->image->store('writers');
        }
        $writer->save();
        return $writer;
    }
}
