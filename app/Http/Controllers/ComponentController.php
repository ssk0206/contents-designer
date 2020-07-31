<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Component;

class ComponentController extends Controller
{
    /**
     * コンポーネント新規作成
     */
    public function store(Request $request, $id)
    {
        $page = Page::find($id);
        $component = new Component;
        $component->fill($request->all());
        $page->components()->save($component);
        return response()->json($component, 201);
    }
}
