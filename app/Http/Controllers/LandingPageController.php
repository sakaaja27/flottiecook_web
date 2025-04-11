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
        return view('livewire.pages.frontend.consultation.pageaibot');
    }

    function aibotwithimage(Request $request)    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $image = $request->file('image');
        $base64 = base64_encode(file_get_contents($image));
        $apikey = env( 'GEMINI_API_KEY' );
        $load = [
            'contens' => [
                [
                    'parts' => [
                        [
                            'text' => "Berikan nama makanan, alat dan bahan yang digunakan dan cara memasaknya dari gambar ini.".
                            "Pisahkan nama makanan dengan awalan '[NAMA MAKANAN]', pisahkan juga alat dan bahan dengan awalan '[Alat dan Bahan]', dan cara memasaknya dengan awalan '[Cara Memasak]'."
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
        $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apikey}",
            $load
        );
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
    }

    function aibotwithtext() {

    }
}
