<?php

namespace Pirumart\Uganda\Locale\Database\Seeders\Concerns;

use Illuminate\Support\Facades\DB;

trait SeedsFromCsv
{
    protected function seedFromCsv(string $table, string $csvPath, int $chunkSize = 500)
    {
        $handle = fopen($csvPath, 'rb');
        $header = fgetcsv($handle);

        $rows = [];
        while (($data = fgetcsv($handle)) !== false) {
            $rows[] = array_combine($header, $data);
        }
        fclose($handle);

        foreach (array_chunk($rows, $chunkSize) as $chunk) {
            DB::table($table)->insert($chunk);
        }
    }
}
