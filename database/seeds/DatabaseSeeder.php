<?php

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Component;
use App\Models\Column;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Page::class, 1)->create()->each(function ($page) {
            $page->components()->saveMany(factory(Component::class, 4)->create([
                'page_id' => $page->id
            ]))->each(function($component) {
                $component->columns()->save(factory(Column::class)->create([
                    'component_id' => $component->id
                ]));
            });
        });
    }
}
