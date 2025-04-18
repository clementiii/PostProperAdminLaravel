<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use PhpOffice\PhpWord\TemplateProcessor;
use phpseclib3\Crypt\RSA;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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

        // 3. Fill in user details
        $template->setValue('NAME', $request->Name ?? '');
        $template->setValue('AGE', $request->Age ?? '');
        $template->setValue('ADDRESS', $request->Address ?? '');
        $template->setValue('LENGTH_OF_STAY', $request->LengthOfStay ?? '');
        $template->setValue('DATE_OF_BIRTH', $request->birthday ?? '');
        $template->setValue('ALIAS', $request->Alias ?? '');
        $template->setValue('CIVIL_STATUS', $request->CivilStatus ?? '');
        $template->setValue('TIN_NO', $request->TIN_No ?? '');
        $template->setValue('OCCUPATION', $request->Occupation ?? '');
        $template->setValue('PLACE_OF_BIRTH', $request->PlaceOfBirth ?? '');
        $template->setValue('SEX', $request->Gender ?? '');
        $template->setValue('PURPOSE', $request->Purpose ?? '');

        // Fill in document fields not from the database
        $template->setValue('ISSUED_ON', Carbon::now()->format('F d, Y'));
        $template->setValue('ISSUE_AT', 'Barangay Post Proper Southside');
        $template->setValue('CURRENT_DATE', Carbon::now()->format('F d, Y'));

        // 4. Generate a digital signature (simple example: sign the user's details)
        $private = RSA::createKey(2048);
        $public = $private->getPublicKey();
        $dataToSign = $request->Name . '|' . $request->Address . '|' . $request->birthday;
        $signature = base64_encode($private->sign($dataToSign));

        // 5. Embed the signature in the document
        $template->setValue('DIGITAL_SIGNATURE', $signature);

        // 6. Save the generated document to a temp location
        $filename = 'Barangay_Clearance_' . Str::slug($request->Name) . '_' . $request->Id . '.docx';
        $tempPath = storage_path('app/' . $filename);
        $template->saveAs($tempPath);

        // 7. Return the file as a download
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
