<?php

namespace App\Services\Section;

use App\Models\Section;
use App\Repositories\Section\SectionRepositoryInterface;
use Illuminate\Support\Collection;

class SectionService implements SectionServiceInterface
{
    public function __construct(
        private SectionRepositoryInterface $repository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function store(array $data): Section
    {
        return $this->repository->create($data);
    }
}
