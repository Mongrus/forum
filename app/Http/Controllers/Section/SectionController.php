<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Services\Section\SectionServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{
    public function __construct(
        private SectionServiceInterface $service
    ) {
    }

    public function index()
    {

        $sections = $this->service->getAll();

        return Inertia::render('Section/Section', [
            'sections' => $sections
        ]);
    }

    public function create()
    {
        return Inertia::render('Section/CreateSection');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|min:3|max:100'
        ]);

        $this->service->store($data);

        return redirect()->route('section.index')->with('success', 'Раздел успешно создан');
    }
}
