<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Component;
use App\Models\Column;

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

    /**
     * コンポーネント情報更新
     */
    public function update(Request $request, $id)
    {
        foreach ($request->all() as $key => $value) {
            $component = Component::find($value['id']);
            $component->update(['order' => $key+1]);
            foreach ($value['columns'] as $arr) {
                $component->columns()->updateOrCreate(
                    ['component_id' => $arr['component_id'], 'order' => $arr['order']],
                    $arr
                );
            }
        }
        return response(204);
    }
}
