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
        
        // Log detailed information about the template and values for debugging
        Log::info('Template path: ' . $templatePath);
        Log::info('Document request data:', [
            'id' => $id,
            'Name' => $request->Name,
            'TIN_No' => $request->TIN_No,
            'CTC_No' => $request->CTC_No,
            'Purpose' => $request->Purpose,
        ]);
        
        // IMPORTANT: Based on the template format, use ONLY the {PLACEHOLDER} format
        // Focus specifically on the problematic fields
        try {
            // Set all values with {PLACEHOLDER} format
            $template->setValue('{NAME}', $request->Name ?? '');
            $template->setValue('{AGE}', $request->Age ?? '');
            $template->setValue('{ADDRESS}', $request->Address ?? '');
            $template->setValue('{LENGTH_OF_STAY}', $request->LengthOfStay ?? '');
            $template->setValue('{DATE_OF_BIRTH}', $formattedBirthday);
            $template->setValue('{ALIAS}', $request->Alias ?? '');
            $template->setValue('{CIVIL_STATUS}', $request->CivilStatus ?? '');
            // Special handling for problematic fields
            $template->setValue('{TIN_NO}', $request->TIN_No ?? '');  // Make sure this exactly matches the template
            $template->setValue('{CTC_NO}', $request->CTC_No ?? '');  // Make sure this exactly matches the template
            $template->setValue('{OCCUPATION}', $request->Occupation ?? '');
            $template->setValue('{PLACE_OF_BIRTH}', $request->PlaceOfBirth ?? '');
            $template->setValue('{SEX}', $request->Gender ?? '');
            $template->setValue('{PURPOSE}', $request->Purpose ?? ''); // Make sure this exactly matches the template
            
            // Non-database fields
            $template->setValue('{ISSUED_ON}', Carbon::now()->format('F d, Y'));
            $template->setValue('{ISSUE_AT}', 'Barangay Post Proper Southside');
            $template->setValue('{CURRENT_DATE}', Carbon::now()->format('F d, Y'));
            
            // Generate digital signature
            $private = RSA::createKey(2048);
            $dataToSign = $request->Name . '|' . $request->Address . '|' . $request->birthday;
            $signature = base64_encode($private->sign($dataToSign));
            $template->setValue('{DIGITAL_SIGNATURE}', $signature);
            
            // Also try with exact case matching on the problematic fields
            // Sometimes Word templates use inconsistent casing
            if ($request->TIN_No) {
                $template->setValue('{tin_no}', $request->TIN_No);
                $template->setValue('{Tin_No}', $request->TIN_No);
            }
            if ($request->CTC_No) {
                $template->setValue('{ctc_no}', $request->CTC_No);
                $template->setValue('{Ctc_No}', $request->CTC_No);
            }
            if ($request->Purpose) {
                $template->setValue('{purpose}', $request->Purpose);
                $template->setValue('{Purpose}', $request->Purpose);
            }
            
        } catch (\Exception $e) {
            Log::error('Error setting template values: ' . $e->getMessage());
            return back()->with('error', 'Error generating document: ' . $e->getMessage());
        }

        // Save the generated document
        $filename = 'Barangay_Clearance_' . Str::slug($request->Name) . '_' . $request->Id . '.docx';
        $tempPath = storage_path('app/' . $filename);
        $template->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
