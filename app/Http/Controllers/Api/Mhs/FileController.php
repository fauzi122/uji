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
        // Memastikan file ada
        if (!Storage::exists('public/soal/' . $filename)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        // Mengambil file
        $file = Storage::get('public/soal/' . $filename);

        // Mendapatkan tipe file
        $type = Storage::mimeType('public/soal/' . $filename);

        // Membuat response file
        $response = response($file, Response::HTTP_OK);
        $response->header("Content-Type", $type);

        return $response;
    }
}
