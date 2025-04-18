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
        $request = DocumentRequest::findOrFail($id);
        $templatePath = resource_path('docs/barangay_clearance_template.docx');

        // Preprocess: Copy template and replace {PLACEHOLDER} with ${PLACEHOLDER}
        $tempTemplatePath = storage_path('app/barangay_clearance_template_temp_' . uniqid() . '.docx');
        copy($templatePath, $tempTemplatePath);

        // Use ZipArchive to replace placeholders in the document.xml part of the docx
        $zip = new \ZipArchive();
        if ($zip->open($tempTemplatePath) === TRUE) {
            $xml = $zip->getFromName('word/document.xml');
            // Replace {PLACEHOLDER} with ${PLACEHOLDER}
            $fields = [
                'NAME','AGE','ADDRESS','LENGTH_OF_STAY','DATE_OF_BIRTH','ALIAS','CIVIL_STATUS','TIN_NO','CTC_NO','OCCUPATION','PLACE_OF_BIRTH','SEX','PURPOSE','CURRENT_DATE','ISSUED_ON','ISSUE_AT','DIGITAL_SIGNATURE'
            ];
            foreach ($fields as $field) {
                $xml = str_replace('{' . $field . '}', '${' . $field . '}', $xml);
            }
            $zip->addFromString('word/document.xml', $xml);
            $zip->close();
        }

        $template = new TemplateProcessor($tempTemplatePath);

        // Format birthdate
        $formattedBirthday = $request->birthday ?? '';
        if (!empty($request->birthday) && strpos($request->birthday, '-') !== false) {
            try {
                $formattedBirthday = Carbon::createFromFormat('m-d-y', $request->birthday)->format('F d, Y');
            } catch (\Exception $e) {
                $formattedBirthday = $request->birthday;
            }
        }

        // Fill values
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
        $template->setValue('CURRENT_DATE', Carbon::now()->format('F d, Y'));
        $template->setValue('ISSUED_ON', Carbon::now()->format('F d, Y'));
        $template->setValue('ISSUE_AT', 'Barangay Post Proper Southside');
        $private = RSA::createKey(2048);
        $dataToSign = $request->Name . '|' . $request->Address . '|' . $request->birthday;
        $signature = base64_encode($private->sign($dataToSign));
        $template->setValue('DIGITAL_SIGNATURE', $signature);

        $filename = 'Barangay_Clearance_' . Str::slug($request->Name) . '_' . $request->Id . '.docx';
        $tempPath = storage_path('app/' . $filename);
        $template->saveAs($tempPath);
        // Clean up temp template
        @unlink($tempTemplatePath);
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
