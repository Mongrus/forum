<?php

namespace App\Repositories\Section;

use App\Models\Section;
use Illuminate\Support\Collection;

class SectionRepository implements SectionRepositoryInterface
{
    public function getAll(): Collection
    {
        return Section::get();
    }

    public function create(array $data): Section
    {
        return Section::create($data);
    }
}
