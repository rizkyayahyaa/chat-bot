<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $message = strtolower($request->input('message'));

        // Logika untuk jawaban "iya" tanpa perlu kata "kia"
        if (preg_match('/^iya+a*$/', $message)) {
            $length = strlen($message) - 3; // Panjang tambahan 'a' setelah "iya"
            if ($length == 0) {
                return response()->json(['response' => 'ko iya aja sii']);
            } elseif ($length == 1) {
                return response()->json(['response' => 'yahh iya nya cuman 2']);
            } else {
                return response()->json(['response' => 'yesss iyaa nya banyak tapi ko iya doangg ada apa']);
            }
        }

        // Validasi pesan harus mengandung kata "kia" untuk respons lain
        if (!str_contains($message, 'kia')) {
            return response()->json(['error' => 'Pesan harus mengandung kata "kia"']);
        }

        // Cek variasi morning kiaa dan variasi lainnya
        if (preg_match('/^(good\s*)?morn(ing|nn|n|g+)?\s*kia+[aj]*$/i', $message) ||
            preg_match('/^god+d+\s*morn(ing|nn|n|g+)?\s*kia+[aj]*$/i', $message)) {
            return response()->json(['response' => 'morningggg zahra cantiku']);
        }

        // Array respons untuk berbagai pertanyaan
        $responses = [
            // Sapaan
            'hai kia' => 'Halo Zaraaaaaa! kalo kamu cuman jawab iya doang gaakan aku bantuu',
            'halo kia' => 'Hai Zaraaaaaa! kalo kamu cuman jawab iya doang gaakan aku bantuu',
            'kia lagi apa?' => 'aku lagi nungguin kamuuuuuuu',
            'kia udah makan belum?' => 'belummm ahh da gapernah laper',
            'kia bisa bantu aku ga?'  => 'bolehh kenapa araa cantikk?',
            'kia bisa tolong aku ga?' => 'bolehh kenapa araa cantikk?',
            'kia aku mau curhat' => 'bolehh kenapa araa cantikk?',

            // Informasi Program Studi
            'kia aku mau nanya kuliahan' => 'bolehh araaaa, mau nanya apaan nihh',
            'apa itu osce?' => 'OSCE adalah ujian praktik untuk menilai keterampilan klinis mahasiswa kebidanan dalam skenario yang menyerupai situasi nyata. Mahasiswa harus menunjukkan kemampuan melakukan prosedur sesuai standar.',
            'bagaimana langkah langkah pemeriksaan leopold?' => 'Leopold I: Palpasi bagian fundus untuk menentukan bagian janin (kepala atau bokong).
                        Leopold II: Palpasi di sisi perut ibu untuk menentukan posisi punggung janin.
                        Leopold III: Palpasi bagian bawah rahim untuk menentukan bagian janin yang akan keluar lebih dulu.
                        Leopold IV: Palpasi lebih dalam ke arah pelvis untuk memastikan posisi kepala janin.',
        ];

        // Cari jawaban yang paling cocok
        foreach ($responses as $key => $response) {
            if (str_contains($message, $key)) {
                return response()->json(['response' => $response]);
            }
        }

        // Jika tidak ada jawaban yang cocok
        return response()->json([
            'response' => 'Maaf, aku belum nambahin respon nya, nanya yg lain deh:(('
        ]);
    }
}
