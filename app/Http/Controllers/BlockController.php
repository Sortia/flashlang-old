<?php

namespace App\Http\Controllers;

use App\Block;
use App\Status;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        return view('block.list', ['blocks' => Block::with('status')->get()]);
    }

    public function create()
    {
        return view('block.form', [
            'statuses' => Status::all(),
        ]);
    }

    public function edit(Block $block)
    {
        return view('block.form', [
            'block' => $block,
            'statuses' => Status::all(),
        ]);
    }

    public function store(Request $request)
    {
//        dd($request->all());
        Block::on()->updateOrCreate(['id' => $request->get('id')], $request->all());

        return redirect(route('block.index'));
    }

    public function destroy(Block $block)
    {
        $block->delete();

        return redirect(route('block.index'));
    }
}
