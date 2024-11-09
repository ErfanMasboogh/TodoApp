<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TodoController extends Controller
{
    public function new()
    {
        $categories = Category::where('user_id', auth()->user()->id)->orWhere('id', 1)->get()->toArray();
        $context = [
            "categories" => $categories
        ];
        return Inertia::render('NewTodo', compact('context'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:30',
            'description' => 'required',
            'category' => 'required',
        ]);

        $todo = new Todo;
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->category_id = $request->category;
        $todo->user_id = auth()->user()->id;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => "max:512|mimes:png,jpg,jpeg|min:32"
            ]);
            $imageExtension = $request->image->getClientOriginalExtension();
            $imageName = time() . '_' . rand('100000', '999999') . '.' . $imageExtension;
            $finalImage = $request->image->storeAs('/storage/images/todos', md5($imageName) . '.' . $imageExtension);
            $todo->image = $finalImage;
        } else {
            $todo->image = '/storage/images/todos/TodoDefault.jpg';
        }

        $todo->save();
        return redirect()->route('index');

    }

    public function completed()
    {
        $todos = Todo::where([['is_done', 1], ['user_id', auth()->user()->id]])->get()->toArray();
        $categories = Category::all()->toArray();
        $context = [
            'todos' => $todos,
            'categories' => $categories
        ];

        return Inertia::render('Completed', compact('context'));
    }
    public function uncompleted()
    {
        $todos = Todo::where([['is_done', 0], ['user_id', auth()->user()->id]])->get()->toArray();

        $categories = Category::all()->toArray();
        $context = [
            'todos' => $todos,
            'categories' => $categories
        ];

        return Inertia::render('Uncompleted', compact('context'));
    }

    public function delete(Todo $todo)
    {
        $todos = Todo::where('id', $todo->id)->first();
        if (!Gate::allows('delete-todo', $todos)) {
            return abort(403);
        }
        if (!$todos->image == "/storage/images/todos/TodoDefault.jpg") {
            Storage::delete($todos->image);
        }
        $todos->delete();

        return redirect()->route('index');
    }

    public function edit(Todo $todo)
    {
        $todos = Todo::where('id', $todo->id)->first();
        if (!Gate::allows('update-todo', $todos)) {
            return abort(403);
        }
        $categories = Category::where('user_id', auth()->user()->id)->orWhere('id', 1)->get()->toArray();
        $context = [
            "todos" => $todos,
            "categories" => $categories
        ];
        return Inertia::render('EditTodo', compact('context'));
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:30',
            'description' => 'required',
            'category' => 'required',
        ]);
        $todos = Todo::where('id', $todo->id)->first();
        $todos->title = $request->title;
        $todos->description = $request->description;
        $todos->category_id = $request->category;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => "max:512|mimes:png,jpg,jpeg|min:32"
            ]);
            if (!$todos->image == "/storage/images/todos/TodoDefault.jpg") {
                Storage::delete($todos->image);
            }
            $imageExtension = $request->image->getClientOriginalExtension();
            $imageName = time() . '_' . rand('100000', '999999') . '.' . $imageExtension;
            $finalImage = $request->image->storeAs('/storage/images/todos', md5($imageName) . '.' . $imageExtension);
            $todos->image = $finalImage;
        }
        $todos->save();
        return redirect()->route('index');

    }
}
