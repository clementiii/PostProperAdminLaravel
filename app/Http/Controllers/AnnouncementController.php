<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AnnouncementController extends Controller
{
    // Storage path for announcement images
    protected $storagePath = 'uploads/announcement_images';

    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    private function uploadToCloudinary($file)
    {
        try {
            $cloudName = env('CLOUDINARY_CLOUD_NAME', '');
            $apiKey = env('CLOUDINARY_API_KEY', '');
            $apiSecret = env('CLOUDINARY_API_SECRET', '');
            
            if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
                Log::error('Cloudinary credentials not found');
                throw new \Exception('Cloud storage is not properly configured.');
            }
            
            $filePath = $file->getRealPath();
            
            // Prepare upload parameters
            $timestamp = time();
            $folder = 'announcement_images';
            $publicId = 'announcement_' . $timestamp . '_' . uniqid();
            
            // Generate signature
            $params = [
                'folder' => $folder,
                'public_id' => $publicId,
                'timestamp' => $timestamp,
            ];
            ksort($params);
            
            $signature = '';
            foreach ($params as $key => $value) {
                $signature .= $key . '=' . $value . '&';
            }
            $signature = rtrim($signature, '&');
            $signature .= $apiSecret;
            $signature = sha1($signature);
            
            // Prepare multipart form data
            $postFields = [
                'file' => new \CURLFile($filePath),
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'folder' => $folder,
                'public_id' => $publicId,
                'signature' => $signature,
            ];
            
            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                Log::error('Cloudinary cURL error: ' . curl_error($ch));
                curl_close($ch);
                throw new \Exception('Failed to upload image to cloud storage.');
            }
            
            curl_close($ch);
            $result = json_decode($response, true);
            
            if (!isset($result['secure_url'])) {
                Log::error('Cloudinary upload failed: ' . json_encode($result));
                throw new \Exception('Failed to upload image to cloud storage.');
            }
            
            return $result['secure_url'];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'announcement_title' => 'required|string|max:255',
            'description_text' => 'required|string',
            'announcement_images' => 'nullable|array|max:5',
            'announcement_images.*' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        try {
            $imagePaths = [];

            if ($request->hasFile('announcement_images')) {
                $images = array_slice($request->file('announcement_images'), 0, 5);
                
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $cloudinaryUrl = $this->uploadToCloudinary($image);
                        $imagePaths[] = $cloudinaryUrl;
                    }
                }
            }

            Announcement::create([
                'announcement_title' => $request->announcement_title,
                'description_text' => $request->description_text,
                'announcement_images' => $imagePaths ? json_encode($imagePaths) : null,
                'created_at' => now(),
                'posted_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Announcement posted successfully!');
        } catch (\Exception $e) {
            Log::error('Announcement creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create announcement. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return redirect()->route('announcements.index')->withErrors('Announcement not found.');
        }

        $request->validate([
            'announcement_title' => 'required|string|max:255',
            'description_text' => 'required|string',
            'announcement_images' => 'nullable|array|max:5',
            'announcement_images.*' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        try {
            $announcement->announcement_title = $request->announcement_title;
            $announcement->description_text = $request->description_text;

            if ($request->hasFile('announcement_images')) {
                $imagePaths = [];
                $images = array_slice($request->file('announcement_images'), 0, 5);
                
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $cloudinaryUrl = $this->uploadToCloudinary($image);
                        $imagePaths[] = $cloudinaryUrl;
                    }
                }
                $announcement->announcement_images = json_encode($imagePaths);
            }

            $announcement->save();

            return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
        } catch (\Exception $e) {
            Log::error('Announcement update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update announcement. Please try again.');
        }
    }

    public function destroy($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found.'], 404);
        }

        // Delete associated images
        if ($announcement->announcement_images) {
            $images = json_decode($announcement->announcement_images, true);
            foreach ($images as $image) {
                $this->deleteImage($image);
            }
        }

        $announcement->delete();

        return response()->json(['message' => 'Announcement deleted successfully.'], 200);
    }

    public function edit($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return redirect()->route('announcements.index')->withErrors('Announcement not found.');
        }

        return view('announcements.edit-announcement', compact('announcement'));
    }
    
    /**
     * Ensure the storage directory exists
     */
    private function ensureDirectoryExists()
    {
        $path = Storage::disk('public')->path($this->storagePath);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }
    
    /**
     * Delete an image from storage
     */
    private function deleteImage($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}