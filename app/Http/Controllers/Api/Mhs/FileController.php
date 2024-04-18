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
        $filePath = 'public/soal/' . $filename;

        // Memastikan file ada
        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        // Mendapatkan tipe file dan kembalikan sebagai response
        return Storage::disk('public')->response($filePath);
    }
}
