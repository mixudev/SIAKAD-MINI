<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DocsController extends Controller
{
    public function index(): View
    {
        return view('docs.index');
    }

    public function show(string $view): View
    {
        $basePath = 'docs.'.str_replace('/', '.', $view);
        $viewPath = $basePath;

        if (! view()->exists($viewPath)) {
            $viewPath = $basePath.'.index';
        }

        abort_unless(view()->exists($viewPath), 404);

        return view($viewPath);
    }
}
