<?php

namespace App\Imports;
use Illuminate\Support\Collection;
use App\Models\Data;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;

class DataImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Remove header
        $rows->shift();

        foreach ($rows as $row) {
            try {
                Data::create([
                    'tgl'       => Carbon::createFromFormat('d/m/Y', $row[0])->format('Y-m-d'),
                    'nama_roti' => $row[1],
                    'produksi'  => $row[2],
                    'penjualan' => $row[3],
                    'rijek'     => $row[4],
                ]);
            } catch (\Exception $e) {
                // Optional: Log or handle rows with invalid date format or data
                Log::error('Import error: ' . $e->getMessage());
            }
        }
    }
}
