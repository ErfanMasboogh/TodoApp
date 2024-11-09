<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Todo;
use Inertia\Inertia;
use App\Models\Image;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', auth()->user()->id)->get()->toArray();
        $categories = Category::all()->toArray();
        $context = [
            "todos" => $todos,
            "categories" => $categories,
        ];
        return Inertia::render('Index', compact('context'));
    }

    public function statusChanged(Request $request)
    {
        $todo = Todo::where('id', $request->todo_id)->first();
        $todo->is_done = 1;
        $todo->save();
        return redirect()->route('index');
    }
}
