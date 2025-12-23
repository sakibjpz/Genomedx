<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('query_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Alaset, VIASURE, etc.
            $table->string('display_name'); // User-friendly name
            $table->text('description')->nullable();
            $table->foreignId('team_id')->constrained('query_teams')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Migrate existing query types from contact_queries table
        $this->migrateExistingQueryTypes();
    }

    private function migrateExistingQueryTypes()
    {
        // Get unique query types from existing contact_queries
        $existingTypes = \DB::table('contact_queries')
            ->select('query_type')
            ->distinct()
            ->pluck('query_type')
            ->toArray();

        $teamMappings = [
            'Alaset' => 'Sales',
            'VIASURE' => 'Sales', 
            'VIASURE NGS' => 'Sales',
            'Pharma' => 'Sales',
            'Immunodiagnostic - Rapid Test' => 'Technical Support',
            'Immunodiagnostic - Turbidimetry' => 'Technical Support',
            'Immunodiagnostic - CLIA' => 'Technical Support',
            'Otros' => 'General Support'
        ];

        foreach ($existingTypes as $type) {
            $teamName = $teamMappings[$type] ?? 'General Support';
            $team = \DB::table('query_teams')->where('name', $teamName)->first();
            
            if ($team) {
                \DB::table('query_types')->insert([
                    'name' => $type,
                    'display_name' => $type,
                    'team_id' => $team->id,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('query_types');
    }
};