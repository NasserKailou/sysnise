<?php

namespace App\Imports;

use App\Models\UniteIndicateur;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UniteIndicateursImport implements ToCollection, WithHeadingRow
{
    protected array $failedRows = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                UniteIndicateur::create([
                    'intitule' => $row['intitule']
                ]);
            } catch (\Throwable $e) {
				$message = strtolower($e->getMessage());
                // On mémorise les uniteIndicateurs non insérés
                $this->failedRows[] = [
                    'intitule' => $row['intitule'] ?? 'N/A',
					'raison'   => (
						str_contains($message, 'duplicate') ||
						str_contains($message, 'unique') ||
						str_contains($message, 'dupliquée') ||
						str_contains($message, 'doublon')
					)
						? 'Doublon'
						: 'Erreur technique',
					
                ];

                // On continue l'import
                continue;
            }
        }
    }

    public function getFailedRows(): array
    {
        return $this->failedRows;
    }
}