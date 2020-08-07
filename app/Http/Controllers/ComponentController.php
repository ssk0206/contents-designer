<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ComponentRepository;
use App\Repositories\Interfaces\ComponentRepositoryInterface;


class ComponentController extends Controller
{
    private ComponentRepositoryInterface $componentRepo;

    public function __construct(
        ComponentRepositoryInterface $componentRepo = null
    )
    {
        $this->componentRepo = $componentRepo ?? new ComponentRepository;
    }

    /**
     * コンポーネント情報更新
     */
    public function update(Request $request, $id)
    {
        $newComponent = $this->componentRepo->createOrUpdate($request->all());

        if (empty($newComponent)) {
            return response(204);
        }

        return response()->json($newComponent, 201);
    }

    public function destroy(Request $request, $id)
    {
        $this->componentRepo->deleteAll($request->all());
        return response(200);
    }
}
