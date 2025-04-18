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
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Exception;

class DocumentPrintController extends Controller
{
    /**
     * Generate and download a signed Barangay Clearance document.
     */
    public function printBarangayClearance($id)
    {
        $request = DocumentRequest::findOrFail($id);

        // Map document types to template filenames
        $typeToTemplate = [
            'Barangay Clearance' => 'barangay_clearance_template.docx',
            'First Time Job Certificate' => 'certificate_of_first_time_job_seeker_template.docx',
            'Barangay Certification' => 'barangay_certificate_template.docx',
            'Certificate of Indigency' => 'certificate_of_indigency_template.docx',
        ];
        $docType = $request->DocumentType;
        $templateFile = $typeToTemplate[$docType] ?? 'barangay_clearance_template.docx';
        $templatePath = resource_path('docs/' . $templateFile);

        // Preprocess: Copy template and replace {PLACEHOLDER} with ${PLACEHOLDER}
        $tempTemplatePath = storage_path('app/' . pathinfo($templateFile, PATHINFO_FILENAME) . '_temp_' . uniqid() . '.docx');
        copy($templatePath, $tempTemplatePath);

        // Use ZipArchive to replace placeholders in the document.xml part of the docx
        $zip = new \ZipArchive();
        if ($zip->open($tempTemplatePath) === TRUE) {
            $xml = $zip->getFromName('word/document.xml');
            // Replace {PLACEHOLDER} with ${PLACEHOLDER} (with underscores)
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

        // Fill values (use underscores in keys)
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
        
        // Generate RSA signature
        $private = RSA::createKey(2048);
        $dataToSign = $request->Name . '|' . $request->Address . '|' . $request->birthday;
        $signature = base64_encode($private->sign($dataToSign));
        
        // Check if GD extension is available
        if (extension_loaded('gd') && function_exists('imagecreate')) {
            try {
                // Generate QR code from signature
                $qrCode = new QrCode($signature);
                
                // Use the PngWriter to create a PNG image
                $writer = new PngWriter();
                $qrResult = $writer->write($qrCode);
                
                // Save QR code image
                $qrImagePath = storage_path('app/qrcode_' . uniqid() . '.png');
                file_put_contents($qrImagePath, $qrResult->getString());
                
                // Add QR code image to document
                $template->setImageValue('DIGITAL_SIGNATURE', [
                    'path' => $qrImagePath,
                    'width' => 200, // Increased from 100
                    'height' => 200, // Increased from 100
                ]);
                
                // Remember to clean up the temp file later
                $tempQrPath = $qrImagePath;
            } catch (Exception $e) {
                // Log the error
                Log::error('Failed to generate QR code: ' . $e->getMessage());
                
                // Fall back to text signature
                $template->setValue('DIGITAL_SIGNATURE', 'Digital Signature: ' . substr($signature, 0, 40) . '...');
                $tempQrPath = null;
            }
        } else {
            // GD extension not available, fall back to text signature
            Log::warning('GD library not available for QR code generation. Using text signature instead.');
            $template->setValue('DIGITAL_SIGNATURE', 'Digital Signature: ' . substr($signature, 0, 40) . '...');
            $tempQrPath = null;
        }

        $filename = pathinfo($templateFile, PATHINFO_FILENAME) . '_' . Str::slug($request->Name) . '_' . $request->Id . '.docx';
        $tempPath = storage_path('app/' . $filename);
        $template->saveAs($tempPath);
        
        // Clean up temp files
        @unlink($tempTemplatePath);
        if ($tempQrPath) {
            @unlink($tempQrPath);
        }
        
        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
