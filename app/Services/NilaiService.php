<?php

namespace App\Services;

use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiService
{
    public function nilaiRt()
    {
        $data = collect(DB::select("
            SELECT nama, nisn, skor, nama_pelajaran
            FROM nilai 
            WHERE materi_uji_id = 7 
            AND nama_pelajaran != 'Pelajaran Khusus' 
            ORDER BY nama, nama_pelajaran ASC
        "));

        $grouped = $data->groupBy('nisn')->map(function ($items) {
            return [
                'nama' => $items->first()->nama,
                'nisn' => $items->first()->nisn,
                'nilaiRt' => $items->pluck('skor', 'nama_pelajaran')->all(),
            ];
        })->values();

        return response()->json($grouped);
    }

    public function nilaiSt()
    {
        $data = collect(DB::select("
            SELECT 
                nama,
                nisn,
                nama_pelajaran,
                SUM(
                    CASE 
                        WHEN pelajaran_id = 44 THEN skor * 41.67
                        WHEN pelajaran_id = 45 THEN skor * 29.67
                        WHEN pelajaran_id = 46 THEN skor * 100
                        WHEN pelajaran_id = 47 THEN skor * 23.81
                        ELSE 0
                    END
                ) AS skor
            FROM nilai
            WHERE materi_uji_id = 4 AND pelajaran_id IN (44, 45, 46, 47)
            GROUP BY nama, nisn, nama_pelajaran
            ORDER BY nama, nama_pelajaran ASC
        "));

        $grouped = $data->groupBy('nisn')->map(function ($items) {
            return [
                'nama' => $items->first()->nama,
                'nisn' => $items->first()->nisn,
                'listNilai' => $items->pluck('skor', 'nama_pelajaran')->all(),
                'total' => $items->sum('skor')
            ];
        })->sortByDesc('total')->values();

        return response()->json($grouped);
    }
}
