<?php

namespace App\Repositories\Section;

use App\Models\Section;
use Illuminate\Support\Collection;

interface SectionRepositoryInterface
{
    public function getAll(): Collection;

    public function create(array $data): Section;
}
