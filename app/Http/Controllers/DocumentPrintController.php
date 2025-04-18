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
        // 1. Fetch the document request
        $request = DocumentRequest::findOrFail($id);

        // 2. Load the template
        $templatePath = resource_path('docs/barangay_clearance_template.docx');
        $template = new TemplateProcessor($templatePath);

        // Check that the template file exists
        if (!file_exists($templatePath)) {
            abort(500, 'Barangay clearance template file not found');
        }

        // Format birthdate to a more readable format if available
        $formattedBirthday = $request->birthday ?? '';
        if (!empty($request->birthday) && strpos($request->birthday, '-') !== false) {
            // Converting MM-DD-YY to Month Day, Year format
            try {
                $formattedBirthday = Carbon::createFromFormat('m-d-y', $request->birthday)->format('F d, Y');
            } catch (\Exception $e) {
                $formattedBirthday = $request->birthday;
            }
        }

        // Try different placeholder formats to ensure compatibility with the template
        
        // Format 1: ${NAME}
        $template->setValue('NAME', $request->Name ?? '');
        $template->setValue('AGE', $request->Age ?? '');
        $template->setValue('ADDRESS', $request->Address ?? '');
        $template->setValue('LENGTH_OF_STAY', $request->LengthOfStay ?? '');
        $template->setValue('DATE_OF_BIRTH', $formattedBirthday);
        $template->setValue('ALIAS', $request->Alias ?? '');
        $template->setValue('CIVIL_STATUS', $request->CivilStatus ?? '');
        $template->setValue('TIN_NO', $request->TIN_No ?? '');
        $template->setValue('CTC_NO', $request->CTC_No ?? '');
        $template->setValue('OCCUPATION', $request->Occupation ?? '');
        $template->setValue('PLACE_OF_BIRTH', $request->PlaceOfBirth ?? '');
        $template->setValue('SEX', $request->Gender ?? '');
        $template->setValue('PURPOSE', $request->Purpose ?? '');
        
        // Document fields not from database
        $template->setValue('ISSUED_ON', Carbon::now()->format('F d, Y'));
        $template->setValue('ISSUE_AT', 'Barangay Post Proper Southside');
        $template->setValue('CURRENT_DATE', Carbon::now()->format('F d, Y'));

        // Format 2: {NAME} - Try alternate format
        try {
            $template->setValue('{NAME}', $request->Name ?? '');
            $template->setValue('{AGE}', $request->Age ?? '');
            $template->setValue('{ADDRESS}', $request->Address ?? '');
            $template->setValue('{LENGTH_OF_STAY}', $request->LengthOfStay ?? '');
            $template->setValue('{DATE_OF_BIRTH}', $formattedBirthday);
            $template->setValue('{ALIAS}', $request->Alias ?? '');
            $template->setValue('{CIVIL_STATUS}', $request->CivilStatus ?? '');
            $template->setValue('{TIN_NO}', $request->TIN_No ?? '');
            $template->setValue('{CTC_NO}', $request->CTC_No ?? '');
            $template->setValue('{OCCUPATION}', $request->Occupation ?? '');
            $template->setValue('{PLACE_OF_BIRTH}', $request->PlaceOfBirth ?? '');
            $template->setValue('{SEX}', $request->Gender ?? '');
            $template->setValue('{PURPOSE}', $request->Purpose ?? '');
            
            $template->setValue('{ISSUED_ON}', Carbon::now()->format('F d, Y'));
            $template->setValue('{ISSUE_AT}', 'Barangay Post Proper Southside');
            $template->setValue('{CURRENT_DATE}', Carbon::now()->format('F d, Y'));
        } catch (\Exception $e) {
            // Ignore errors for this format if not found
        }
        
        // 4. Generate a digital signature
        $private = RSA::createKey(2048);
        $public = $private->getPublicKey();
        $dataToSign = $request->Name . '|' . $request->Address . '|' . $request->birthday;
        $signature = base64_encode($private->sign($dataToSign));
        
        // Try both formats for signature
        $template->setValue('DIGITAL_SIGNATURE', $signature);
        try {
            $template->setValue('{DIGITAL_SIGNATURE}', $signature);
        } catch (\Exception $e) {
            // Ignore errors if not found
        }
        
        // For debugging - log the values being set
        Log::info('Template values for Barangay Clearance:', [
            'Name' => $request->Name,
            'Address' => $request->Address,
            'Template Path' => $templatePath,
            'CTC_No' => $request->CTC_No
        ]);

        // 6. Save the generated document to a temp location
        $filename = 'Barangay_Clearance_' . Str::slug($request->Name) . '_' . $request->Id . '.docx';
        $tempPath = storage_path('app/' . $filename);
        $template->saveAs($tempPath);

        // 7. Return the file as a download
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
