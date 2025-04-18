<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use PhpOffice\PhpWord\TemplateProcessor;
use phpseclib3\Crypt\RSA;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DocumentPrintController extends Controller
{
    /**
     * Generate and download a signed Barangay Clearance document.
     */
    public function printBarangayClearance($id)
    {
        // Fetch the document request
        $request = DocumentRequest::findOrFail($id);

        // Load the template
        $templatePath = resource_path('docs/barangay_clearance_template.docx');
        $template = new TemplateProcessor($templatePath);

        // Check that the template file exists
        if (!file_exists($templatePath)) {
            abort(500, 'Barangay clearance template file not found');
        }

        // Format birthdate to a more readable format if available
        $formattedBirthday = $request->birthday ?? '';
        if (!empty($request->birthday) && strpos($request->birthday, '-') !== false) {
            try {
                $formattedBirthday = Carbon::createFromFormat('m-d-y', $request->birthday)->format('F d, Y');
            } catch (\Exception $e) {
                $formattedBirthday = $request->birthday;
            }
        }

        // Try multiple placeholder formats to ensure compatibility with the template
        
        // Try various formats for the problematic fields
        $tinNo = $request->TIN_No ?? '';
        $ctcNo = $request->CTC_No ?? '';
        $purpose = $request->Purpose ?? '';
        
        // Detailed logging to diagnose the issue
        Log::info('Document data for problematic fields:', [
            'TIN_No' => $tinNo,
            'CTC_No' => $ctcNo,
            'Purpose' => $purpose,
        ]);

        // Format 1: ${PLACEHOLDER}
        $template->setValue('NAME', $request->Name ?? '');
        $template->setValue('AGE', $request->Age ?? '');
        $template->setValue('ADDRESS', $request->Address ?? '');
        $template->setValue('LENGTH_OF_STAY', $request->LengthOfStay ?? '');
        $template->setValue('DATE_OF_BIRTH', $formattedBirthday);
        $template->setValue('ALIAS', $request->Alias ?? '');
        $template->setValue('CIVIL_STATUS', $request->CivilStatus ?? '');
        $template->setValue('TIN_NO', $tinNo);
        $template->setValue('CTC_NO', $ctcNo);
        $template->setValue('OCCUPATION', $request->Occupation ?? '');
        $template->setValue('PLACE_OF_BIRTH', $request->PlaceOfBirth ?? '');
        $template->setValue('SEX', $request->Gender ?? '');
        $template->setValue('PURPOSE', $purpose);
        
        $template->setValue('ISSUED_ON', Carbon::now()->format('F d, Y'));
        $template->setValue('ISSUE_AT', 'Barangay Post Proper Southside');
        $template->setValue('CURRENT_DATE', Carbon::now()->format('F d, Y'));

        // Try alternative placeholder formats for problematic fields
        try {
            // Format 2: {PLACEHOLDER}
            $template->setValue('{NAME}', $request->Name ?? '');
            $template->setValue('{AGE}', $request->Age ?? '');
            $template->setValue('{ADDRESS}', $request->Address ?? '');
            $template->setValue('{LENGTH_OF_STAY}', $request->LengthOfStay ?? '');
            $template->setValue('{DATE_OF_BIRTH}', $formattedBirthday);
            $template->setValue('{ALIAS}', $request->Alias ?? '');
            $template->setValue('{CIVIL_STATUS}', $request->CivilStatus ?? '');
            $template->setValue('{TIN_NO}', $tinNo);
            $template->setValue('{CTC_NO}', $ctcNo);
            $template->setValue('{OCCUPATION}', $request->Occupation ?? '');
            $template->setValue('{PLACE_OF_BIRTH}', $request->PlaceOfBirth ?? '');
            $template->setValue('{SEX}', $request->Gender ?? '');
            $template->setValue('{PURPOSE}', $purpose);
            
            $template->setValue('{ISSUED_ON}', Carbon::now()->format('F d, Y'));
            $template->setValue('{ISSUE_AT}', 'Barangay Post Proper Southside');
            $template->setValue('{CURRENT_DATE}', Carbon::now()->format('F d, Y'));
        } catch (\Exception $e) {
            Log::warning('Failed to set placeholders using {PLACEHOLDER} format: ' . $e->getMessage());
        }

        try {
            // Format 3: ${placeholder} - case-sensitive match issues are common
            $template->setValue('${TIN_NO}', $tinNo);
            $template->setValue('${CTC_NO}', $ctcNo);
            $template->setValue('${PURPOSE}', $purpose);
        } catch (\Exception $e) {
            Log::warning('Failed to set placeholders using ${PLACEHOLDER} format: ' . $e->getMessage());
        }

        try {
            // Format 4: «PLACEHOLDER» (used in some Word templates)
            $template->setValue('«TIN_NO»', $tinNo);
            $template->setValue('«CTC_NO»', $ctcNo);
            $template->setValue('«PURPOSE»', $purpose);
        } catch (\Exception $e) {
            Log::warning('Failed to set placeholders using «PLACEHOLDER» format: ' . $e->getMessage());
        }

        try {
            // Format 5: Try lowercase versions
            $template->setValue('tin_no', $tinNo);
            $template->setValue('ctc_no', $ctcNo);
            $template->setValue('purpose', $purpose);
        } catch (\Exception $e) {
            Log::warning('Failed to set placeholders using lowercase format: ' . $e->getMessage());
        }
        
        // Generate digital signature
        $private = RSA::createKey(2048);
        $dataToSign = $request->Name . '|' . $request->Address . '|' . $request->birthday;
        $signature = base64_encode($private->sign($dataToSign));
        
        // Set signature with multiple formats
        $template->setValue('DIGITAL_SIGNATURE', $signature);
        try { $template->setValue('{DIGITAL_SIGNATURE}', $signature); } catch (\Exception $e) {}

        // Save the generated document
        $filename = 'Barangay_Clearance_' . Str::slug($request->Name) . '_' . $request->Id . '.docx';
        $tempPath = storage_path('app/' . $filename);
        $template->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
