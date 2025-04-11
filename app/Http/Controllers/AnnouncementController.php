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

    /**
     * Display announcements index page
     */
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Upload an image to Cloudinary
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|bool
     */
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
            $extension = strtolower($file->getClientOriginalExtension());
            
            // Prepare upload parameters
            $timestamp = time();
            $folder = 'announcement_images';
            $publicId = 'announcement_' . $timestamp . '_' . uniqid();
            
            // Generate signature
            $params = [
                'folder' => $folder,
                'public_id' => $publicId,
                'timestamp' => $timestamp,
                'format' => $extension,  // Explicitly specify the format
            ];
            ksort($params); // Sort params alphabetically
            
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
                'format' => $extension,  // Explicitly specify the format
                'signature' => $signature,
            ];
            
            // Initialize cURL and set options
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Execute request
            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                Log::error('Cloudinary cURL error: ' . curl_error($ch));
                curl_close($ch);
                return false;
            }
            
            curl_close($ch);
            $result = json_decode($response, true);
            
            if (!isset($result['secure_url'])) {
                Log::error('Cloudinary upload failed: ' . json_encode($result));
                return false;
            }
            
            return $result['secure_url'];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Store a new announcement
     */
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
                // Limit to 5 images
                $images = array_slice($request->file('announcement_images'), 0, 5);
                
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $cloudinaryUrl = $this->uploadToCloudinary($image);
                        
                        if ($cloudinaryUrl) {
                            $imagePaths[] = $cloudinaryUrl;
                        } else {
                            Log::error('Failed to upload image to Cloudinary');
                        }
                    }
                }
            }

            Announcement::create([
                'announcement_title' => $request->announcement_title,
                'description_text' => $request->description_text,
                'announcement_images' => !empty($imagePaths) ? json_encode($imagePaths) : null,
                'created_at' => now(),
                'posted_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Announcement posted successfully!');
        } catch (\Exception $e) {
            Log::error('Announcement creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create announcement: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified announcement
     */
    public function edit($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return redirect()->route('announcements.index')->withErrors('Announcement not found.');
        }

        return view('announcements.edit-announcement', compact('announcement'));
    }

    /**
     * Update the specified announcement
     */
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
                        
                        if ($cloudinaryUrl) {
                            $imagePaths[] = $cloudinaryUrl;
                        }
                    }
                }
                
                $announcement->announcement_images = json_encode($imagePaths);
            }

            $announcement->save();

            return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
        } catch (\Exception $e) {
            Log::error('Announcement update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update announcement: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified announcement
     */
    public function destroy($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json(['message' => 'Announcement not found.'], 404);
        }

        try {
            $announcement->delete();
            return response()->json(['message' => 'Announcement deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting announcement: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete announcement.'], 500);
        }
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
