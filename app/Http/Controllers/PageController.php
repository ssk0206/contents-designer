<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * ページリスト表示
     */
    public function index(Request $request)
    {
        $pages = Page::all();
        return $pages;
    }

    /**
     * ページ編集
     */
    public function edit(int $id)
    {
        $page = Page::with('components.columns')->find($id);
        return $page;
    }
}
