<?php

namespace App\Repositories;

use App\Models\Component;
use App\Repositories\Interfaces\ComponentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ComponentRepository implements ComponentRepositoryInterface
{
    private $component;

    public function __construct()
    {
        $this->component = new Component();
    }

    /**
     * update
     * @param array $data
     * @return array
     */
    public function createOrUpdate(array $data): array
    {
        $newComponent = [];

        return DB::transaction(function () use ($data, $newComponent) {
            foreach ($data as $index => $value) {
                $component = $this->component
                    ->where('id', $value['id'])
                    ->first();

                if (is_null($component)){
                    $component = $this->component
                        ->create([
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
                    $component->columns()
                        ->updateOrCreate(
                            [
                                'component_id' => $columns['component_id'],
                                'order' => $columns['order']
                            ],
                            $columns
                        );
                }
            }

            return $newComponent;
        });
    }

    /**
     * delete
     * @param array $data
     * @return bool
     */
    public function deleteAll(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            foreach ($data as $key => $value) {
                $component = $this->component::where('id', $value['id'])->first();

                if (!is_null($component)) {
                    $component->delete();
                }
            }

            return true;
        });
    }
}
