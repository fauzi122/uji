<?php

namespace App\Library;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;

class APIBap
{
    const BASE_URL = "https://apibap.bsi.ac.id/api"; // API BAP
    const API_KEY = "5GgKR0sJdQaCtyWjwcTZD+HuBxWkew4YDsoJ9xBV9kE="; // API Key

    /**
     * Fungsi untuk menentukan apakah SSL harus digunakan
     */
    private function httpOptions()
    {
        return [
            'verify' => false // Hanya verifikasi SSL jika di mode production
        ];
    }

    /**
     * Fungsi untuk request GET
     */
    public function get($endpoint, $params = [])
    {
        try {
            // Kirim request POST dengan parameter tambahan
            $response = Http::withHeaders([
                'X-API-KEY' => self::API_KEY
            ])->withOptions($this->httpOptions())
                ->post(self::BASE_URL . $endpoint, $params);
            // dd($response);
            return $response->json();
        } catch (\Exception $e) {
            return ['error' => "Kesalahan: " . $e->getMessage()];
        }
    }

    /**
     * Fungsi untuk request POST (dapat menangani unggahan file)
     */
    public function post($endpoint, $data)
    {
        try {
            $httpRequest = Http::withHeaders([
                'X-API-KEY' => self::API_KEY
            ])->withOptions($this->httpOptions());

            // Jika ada file, gunakan attach untuk multipart/form-data
            if (isset($data['file']) && $data['file']->isValid()) {
                $httpRequest = $httpRequest->attach(
                    'file',
                    file_get_contents($data['file']->getRealPath()),
                    $data['file']->getClientOriginalName()
                );
                unset($data['file']); // Hapus file dari data agar tidak dikirim dua kali
            }

            $response = $httpRequest->post(self::BASE_URL . $endpoint, $data);

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => "Kesalahan: " . $e->getMessage()];
        }
    }

    /**
     * Fungsi untuk request PUT (dapat menangani unggahan file)
     */
    public function put($endpoint, $data)
    {
        try {
            $httpRequest = Http::withHeaders([
                'X-API-KEY' => self::API_KEY
            ])->withOptions($this->httpOptions());

            // Jika ada file, gunakan multipart/form-data
            if (isset($data['file']) && $data['file']->isValid()) {
                $httpRequest = $httpRequest->attach(
                    'file',
                    file_get_contents($data['file']->getRealPath()),
                    $data['file']->getClientOriginalName()
                );
            }

            // Kirim request dengan parameter tambahan (override PUT menggunakan POST)
            $response = $httpRequest->post(self::BASE_URL . $endpoint, [
                '_method' => 'PUT', // Override PUT dengan POST
                'filename_lama' => $data['filename_lama'],
                'tahun' => $data['tahun']
            ]);

            return $response->json() ?? ['error' => 'API tidak memberikan response'];
        } catch (\Exception $e) {
            return ['error' => "Kesalahan: " . $e->getMessage()];
        }
    }



    /**
     * Fungsi untuk request DELETE
     */
    public function delete($endpoint)
    {
        try {
            $response = Http::withHeaders([
                'X-API-KEY' => self::API_KEY
            ])->withOptions($this->httpOptions())
                ->delete(self::BASE_URL . $endpoint);

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => "Kesalahan: " . $e->getMessage()];
        }
    }
}
