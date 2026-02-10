<?php

namespace App\Services\Section;

use App\Models\Section;
use Illuminate\Support\Collection;

interface SectionServiceInterface
{
    public function getAll(): Collection;

    public function store(array $data): Section;
}
