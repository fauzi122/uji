<?php

namespace App\Http\Controllers\Api\Mhs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    public function getFile($filename)
    {
        $filePath = storage_path('app/public/soal/' . $filename);

        // Memastikan file ada
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        // Kembalikan file sebagai response
        return response()->file($filePath);
    }
}
