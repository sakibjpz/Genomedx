<?php

namespace Database\Seeders;

use App\Models\QueryTeam;
use Illuminate\Database\Seeder;

class QueryTeamsSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Sales',
                'email' => 'sales@genomedxbd.com',
                'query_types' => ['Alaset', 'VIASURE', 'VIASURE NGS', 'Pharma'],
                'is_active' => true
            ],
            [
                'name' => 'Technical Support',
                'email' => 'support@genomedxbd.com',
                'query_types' => [
                    'Immunodiagnostic - Rapid Test',
                    'Immunodiagnostic - Turbidimetry', 
                    'Immunodiagnostic - CLIA'
                ],
                'is_active' => true
            ],
            [
                'name' => 'General Support',
                'email' => 'info@genomedxbd.com',
                'query_types' => ['Otros'],
                'is_active' => true
            ]
        ];

        foreach ($teams as $team) {
            QueryTeam::create($team);
        }
    }
}