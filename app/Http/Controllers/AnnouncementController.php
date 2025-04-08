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

    public function store(Request $request)
    {
        $request->validate([
            'announcement_title' => 'required|string|max:255',
            'description_text' => 'required|string',
            'announcement_images' => 'nullable|array|max:5', // Limit to 5 images
            'announcement_images.*' => 'image|mimes:jpeg,png,jpg|max:10240', // 10MB limit
        ]);

        $imagePaths = [];

        if ($request->hasFile('announcement_images')) {
            // Check if directory exists, if not create it
            $this->ensureDirectoryExists();
            
            // Limit to 5 images
            $images = array_slice($request->file('announcement_images'), 0, 5);
            
            foreach ($images as $image) {
                if ($image->isValid()) {
                    // Generate unique filename with timestamp
                    $timestamp = time();
                    $uniqueId = uniqid();
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $timestamp . '_' . $uniqueId . '.' . $extension;
                    
                    // Define the path
                    $path = $this->storagePath . '/' . $fileName;
                    
                    // Store the file in the public storage directory
                    Storage::disk('public')->put($path, File::get($image));
                    
                    // Save just the path that will be used in the API
                    $imagePaths[] = $path;
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
            'announcement_images' => 'nullable|array|max:5', // Limit to 5 images
            'announcement_images.*' => 'image|mimes:jpeg,png,jpg|max:10240', // 10MB limit
        ]);

        $announcement->announcement_title = $request->announcement_title;
        $announcement->description_text = $request->description_text;

        if ($request->hasFile('announcement_images')) {
            // Delete old images
            if ($announcement->announcement_images) {
                $oldImages = json_decode($announcement->announcement_images, true);
                foreach ($oldImages as $image) {
                    $this->deleteImage($image);
                }
            }

            // Ensure directory exists
            $this->ensureDirectoryExists();
            
            // Upload new images (max 5)
            $imagePaths = [];
            $images = array_slice($request->file('announcement_images'), 0, 5);
            
            foreach ($images as $image) {
                if ($image->isValid()) {
                    // Generate unique filename with timestamp
                    $timestamp = time();
                    $uniqueId = uniqid();
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $timestamp . '_' . $uniqueId . '.' . $extension;
                    
                    // Define the path
                    $path = $this->storagePath . '/' . $fileName;
                    
                    // Store the file in the public storage directory
                    Storage::disk('public')->put($path, File::get($image));
                    
                    // Save just the path that will be used in the API
                    $imagePaths[] = $path;
                }
            }
            $announcement->announcement_images = json_encode($imagePaths);
        }

        $announcement->save();

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
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