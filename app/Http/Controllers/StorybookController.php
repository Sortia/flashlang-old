<?php

namespace App\Http\Controllers;

use App\Jobs\TranslateText;
use App\Models\Storybook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorybookController extends Controller
{
    public function index(): View
    {
        $storybooks = Storybook::all();

        return view('storybook.index', compact('storybooks'));
    }

    public function create()
    {
        return view('storybook.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $storybook = Storybook::create($request->all());

        TranslateText::dispatch($storybook);

        return redirect()->back();
    }

    public function show(Storybook $storybook)
    {
        return view('storybook.show', compact('storybook'));
    }

}
