<?php

namespace App\Repositories\Interfaces;

use App\Models\Component;
use Illuminate\Database\Eloquent\Collection;

interface ComponentRepositoryInterface
{
    public function createOrUpdate(array $data): array;
    public function deleteAll(array $data): bool;
}