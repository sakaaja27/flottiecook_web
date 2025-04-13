<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LandingPageController extends Controller
{
    function home()
    {
        return view('livewire.pages.components-frontend.index');
    }

    function aibot()
    {
        return view('livewire.pages.frontend.aibot.sectionindex');
    }

    function publishrecipe(){
        return view('livewire.pages.frontend.publishrecipe.sectionindex');
    }

    function aibotwithimage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $image = $request->file('image');
        $base64 = base64_encode(file_get_contents($image));
        $apikey = env('GEMINI_API_KEY');
        $load = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "Berikan nama makanan, alat dan bahan yang digunakan berikan spesifik komponen alat bahan yang dibutuhkan dan cara pembuatan dari gambar ini." .
                                "Pisahkan nama makanan dengan awalan '[NAMA MAKANAN]', pisahkan juga alat dan bahan dengan awalan '[ALAT DAN BAHAN]', dan cara pembuatan dengan awalan '[CARA PEMBUATAN]'."
                        ],
                        [
                            'inlineData' => [
                                'mimeType' => $image->getMimeType(),
                                'data' => $base64
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $response = Http::timeout(60)
            ->withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apikey}", $load);


        if (!$response->ok()) {
            return response()->json([
                'status' => 'error',
                'result' => 'Gagal',
                'response' => $response->body()
            ], 500);
        }

        $data = $response->json();

        if (isset($data['candidates']) && isset($data['candidates'][0]['content']['parts'])) {
            $result = $data['candidates'][0]['content']['parts'][0]['text'];
            return response()->json([
                'status' => 'success',
                'result' => $result
            ]);
        } else {

            return response()->json([
                'status' => 'error',
                'result' => 'Tidak dapat menghasilkan output dari gambar ini.'
            ], 422);
        }
        if (!$response->ok()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal konek ke Gemini: ' . $response->body()
            ], 500);
        }
    }

    function aibotwithtext(Request $request) {
        $validate = $request->validate([
            'text' => 'required|string|max:100',
        ]);
        $text = $request->input('text');
        $apikey = env('GEMINI_API_KEY');
        $load = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "Berikan nama makanan, alat dan bahan yang digunakan berikan spesifik komponen alat bahan yang dibutuhkan dan cara pembuatan ini." .
                                "Pisahkan nama makanan dengan awalan '[NAMA MAKANAN]', pisahkan juga alat dan bahan dengan awalan '[ALAT DAN BAHAN]', dan cara pembuatan dengan awalan '[CARA PEMBUATAN]'."
                        ],
                        [
                            'text' => $text
                        ]
                    ]
                ]
            ]
        ];
        $response = Http::timeout(60)
            ->withoutVerifying()
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apikey}", $load);
        if (!$response->ok()) {
            return response()->json([
                'status' => 'error',
                'result' => 'Gagal',
                'response' => $response->body()
            ], 500);
        }
        $data = $response->json();
        if (isset($data['candidates']) && isset($data['candidates'][0]['content']['parts'])) {
            $result = $data['candidates'][0]['content']['parts'][0]['text'];
            return response()->json([
                'status' => 'success',
                'result' => $result
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'result' => 'Tidak dapat menghasilkan output.'
            ], 422);
        }

    }
}
