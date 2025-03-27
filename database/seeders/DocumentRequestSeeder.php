<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            'Barangay Clearance',
            'Barangay Certification',
            'Certificate of Indigency'
        ];

        $names = [
            'John Smith',
            'Maria Garcia',
            'David Johnson',
            'Sarah Wilson',
            'Michael Brown',
            'Emily Davis',
            'James Anderson',
            'Lisa Martinez',
            'Robert Taylor',
            'Jennifer Thomas',
            'William White',
            'Patricia Moore',
            'Richard Jackson',
            'Elizabeth Lee',
            'Joseph Harris',
            'Margaret Clark',
            'Charles Rodriguez',
            'Susan Lewis',
            'Daniel Walker',
            'Nancy Hall'
        ];

        $statuses = ['pending', 'approved', 'rejected', 'overdue'];

        // Generate 20 document requests
        for ($i = 0; $i < 20; $i++) {
            $date = Carbon::now()->subDays(rand(0, 30))->format('Y-m-d H:i:s');
            
            DB::table('document_requests')->insert([
                'Name' => $names[$i],
                'Address' => '123 Sample Street, Barangay Sample',
                'Age' => rand(18, 70),
                'birthday' => Carbon::now()->subYears(rand(18, 70))->format('Y-m-d'),
                'PlaceOfBirth' => 'Manila',
                'Alias' => '',
                'Citizenship' => 'Filipino',
                'Occupation' => 'Employee',
                'Gender' => rand(0, 1) ? 'Male' : 'Female',
                'CivilStatus' => array_rand(['Single' => 0, 'Married' => 1, 'Widowed' => 2]),
                'LengthOfStay' => rand(1, 20),
                'DocumentType' => $documentTypes[array_rand($documentTypes)],
                'Purpose' => 'Personal Requirement',
                'TIN_No' => (string)rand(100000000, 999999999),
                'CTC_No' => (string)rand(10000, 99999),
                'Quantity' => rand(1, 5),
                'Status' => $statuses[array_rand($statuses)], // Assign random status
                'rejection_reason' => '',
                'date_approved' => $date,
                'valid_id' => 'sample_valid_id.jpg',
                'valid_id_front' => '',
                'valid_id_back' => '',
                'request_picture' => 'sample_request.jpg',
                'pickup_status' => 'pending',
                'DateRequested' => $date
            ]);
        }
    }
}
