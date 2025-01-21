<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $message = strtolower($request->input('message'));

        // Validasi pesan harus mengandung kata "kia"
        if (!str_contains($message, 'kia')) {
            return response()->json(['error' => 'Pesan harus mengandung kata "kia"']);
        }

        // Array respons untuk berbagai pertanyaan
        $responses = [
            // Sapaan
            'hai kia' => 'Halo Zaraaaaaa! kalo kamu cuman jawab iya doang gaakan aku bantuu',
            'halo kia' => 'Hai Zaraaaaaa! kalo kamu cuman jawab iya doang gaakan aku bantuu',
            'kia lagi apa?' => 'aku lagi nungguin kamuuuuuuu',
            'kia udah makan belum?' => 'belummm ahh da gapernah laper',



            // Informasi Program Studi
            'kia program studi apa saja' => 'STIKES memiliki program studi D3 Kebidanan dan D4 Kebidanan',
            'kia jurusan apa saja' => 'Di STIKES tersedia jurusan D3 Kebidanan dan D4 Kebidanan',

            // Informasi Pendaftaran
            'kia cara daftar' => 'Untuk mendaftar di STIKES, kamu bisa:
1. Datang langsung ke kampus
2. Daftar online melalui website
3. Siapkan dokumen: Ijazah, SKHU, KTP, Kartu Keluarga
4. Bayar biaya pendaftaran',

            // Informasi Biaya
            'kia biaya kuliah' => 'Biaya kuliah per semester:
- D3 Kebidanan: Rp 4.500.000
- D4 Kebidanan: Rp 5.500.000
Tersedia program cicilan dan beasiswa',

            // Informasi Fasilitas
            'kia fasilitas apa saja' => 'Fasilitas STIKES meliputi:
- Laboratorium Kebidanan lengkap
- Perpustakaan
- WiFi
- Ruang Praktik
- Klinik
- Aula',

            // Informasi Akreditasi
            'kia akreditasi' => 'Program Studi Kebidanan terakreditasi B oleh BAN-PT',

            // Informasi Prospek Kerja
            'kia prospek kerja' => 'Lulusan dapat bekerja di:
- Rumah Sakit
- Klinik
- Puskesmas
- Bidan Praktik Mandiri
- Dosen
- Peneliti Kesehatan',

            // Informasi Masa Studi
            'kia berapa lama kuliah' => 'Lama studi:
- D3 Kebidanan: 3 tahun
- D4 Kebidanan: 4 tahun',

            // Informasi Praktik
            'kia tempat praktik dimana' => 'Praktik dilaksanakan di:
- RS Mitra STIKES
- Puskesmas
- Klinik Bersalin
- BPM (Bidan Praktik Mandiri)',

            // Informasi Kompetensi
            'kia kompetensi lulusan' => 'Kompetensi lulusan:
- Asuhan Kebidanan
- Penanganan Persalinan Normal
- Perawatan Ibu dan Anak
- Konseling KB
- Deteksi Dini Komplikasi'
        ];

        // Cari jawaban yang paling cocok
        foreach ($responses as $key => $response) {
            if (str_contains($message, $key)) {
                return response()->json(['response' => $response]);
            }
        }

        // Jika tidak ada jawaban yang cocok
        return response()->json([
            'response' => 'Maaf, saya belum bisa menjawab pertanyaan tersebut.
Silakan tanya tentang:
- Program studi
- Cara pendaftaran
- Biaya kuliah
- Fasilitas kampus
- Akreditasi
- Prospek kerja
- Masa studi
- Tempat praktik
- Kompetensi lulusan'
        ]);
    }
}
