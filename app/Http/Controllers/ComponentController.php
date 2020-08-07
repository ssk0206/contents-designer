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
        $newComponent = [];
        foreach ($request->all() as $index => $value) {
            $component = Component::where('id', $value['id'])->first();

            if (is_null($component)){
                $component = Component::create([
                    'page_id' => $value['page_id'],
                    'type' => $value['type'],
                    'trash' => $value['trash'],
                    'order' => $index+1,
                ]);
                $newComponent[] = $component;
            }

            $component->update([
                'trash' => $value['trash'],
                'order' => $index+1
            ]);

            foreach ($value['columns'] as $columns) {
                $columns['component_id'] = $component->id;
                $component->columns()->updateOrCreate(
                    ['component_id' => $columns['component_id'], 'order' => $columns['order']],
                    $columns
                );
            }
        }
        if (empty($newComponent)) {
            return response(204);
        }
        return response()->json($newComponent, 201);
    }

    public function destroy(Request $request, $id)
    {
        foreach ($request->all() as $key => $value) {
            $component = Component::where('id', $value['id'])->first();
            if (!is_null($component)) {
                $component->delete();
            }
        }
        return response(200);
    }
}
