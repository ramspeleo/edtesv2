<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;

class OfficeSeeder extends Seeder
{
    public function run(): void
    {
        Office::truncate();

        // Central Office
        $co = Office::create([
            'office_code' => 'CO',
            'office_name' => 'Central Office',
            'office_type' => 'central',
            'is_active' => true,
        ]);

        // Regional Office
        $ro = Office::create([
            'office_code' => 'RO',
            'office_name' => 'Regional Office',
            'office_type' => 'regional',
            'is_active' => true,
        ]);

        // Central Office Divisions
        $coOffices = [
            ['WRED', 'WORKPLACE RELATIONS ENHANCEMENT DIVISION'],
            ['VAD', 'VOLUNTARY ARBITRATION DIVISION'],
            ['CMD', 'CONCILIATION AND MEDIATION DIVISION'],
            ['RID', 'RESEARCH AND INFORMATION DIVISION'],
            ['AD', 'ADMINISTRATIVE DIVISION'],
            ['FMD', 'FINANCIAL MANAGEMENT DIVISION'],
            ['OED', 'OFFICE OF THE EXECUTIVE DIRECTOR'],
            ['ODED', 'OFFICE OF THE DEPUTY EXECUTIVE DIRECTOR'],
            ['TSD', 'OFFICE OF THE TS DIRECTOR'],
            ['ISD', 'OFFICE OF THE IS DIRECTOR'],
            ['CO-COA', 'CO-COMMISSION ON AUDIT'],
        ];

        foreach ($coOffices as $office) {
            Office::create([
                'office_code' => $office[0],
                'office_name' => $office[1],
                'office_type' => 'division',
                'parent_office_id' => $co->id,
                'is_active' => true,
            ]);
        }

        // Regional Office Units
        $roOffices = [
            ['ASU', 'ADMINISTRATIVE SERVICES UNIT'],
            ['TSU', 'TECHNICAL SERVICES UNIT'],
            ['CMU', 'CONCILIATION AND MEDIATION UNIT'],
            ['TSD-RO', 'OFFICE OF THE TS DIRECTOR'],
            ['RB-COA', 'RB-COMMISSION ON AUDIT'],
        ];

        foreach ($roOffices as $office) {
            Office::create([
                'office_code' => $office[0],
                'office_name' => $office[1],
                'office_type' => 'section',
                'parent_office_id' => $ro->id,
                'is_active' => true,
            ]);
        }
    }
}