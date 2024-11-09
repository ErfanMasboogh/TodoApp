<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function dashboard()
    {
        $categories = Category::where('user_id', auth()->user()->id)->get()->toArray();
        $context = [
            'categories' => $categories
        ];
        return Inertia::render('Dashboard', compact('context'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|max:30"
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->user_id = auth()->user()->id;
        $category->save();
        return redirect()->route('dashboard');
    }

    public function update(Request $request, Category $category)
    {
        $categories = Category::where('id', $category->id)->first();
        if (!Gate::allows('update-category', $categories)) {
            return abort(403);
        }
        $request->validate([
            "name" => "required|max:30"
        ]);
        $categories->name = $request->name;
        $categories->save();
        return redirect()->route('dashboard');

    }

    public function delete(Category $category)
    {
        $categories = Category::where('id', $category->id)->first();
        if (!Gate::allows('delete-category', $categories)) {
            return abort(403);
        }
        $categories->delete();
        return redirect()->route('dashboard');

    }
}
