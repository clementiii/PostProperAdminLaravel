<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
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
            'announcement_images' => 'nullable|array',
            'announcement_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:51200',
        ]);

        $imagePaths = [];
        $uploadPath = public_path('assets/uploads/announcements/');

        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
            Log::error('Failed to create upload directory: ' . $uploadPath);
            return redirect()->back()->withErrors('Failed to create upload directory.');
        }

        if ($request->hasFile('announcement_images')) {
            foreach ($request->file('announcement_images') as $image) {
                if (!$image->isValid()) {
                    Log::error('Invalid file detected: ' . $image->getClientOriginalName());
                    continue;
                }

                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                try {
                    $image->move($uploadPath, $fileName);
                    $imagePaths[] = 'assets/uploads/announcements/' . $fileName;
                    Log::info('File moved successfully: ' . $fileName);
                } catch (\Exception $e) {
                    Log::error('File move failed: ' . $e->getMessage());
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

        Log::info('Announcement created successfully!');

        return redirect()->back()->with('success', 'Announcement posted successfully!');
    }
    
}
