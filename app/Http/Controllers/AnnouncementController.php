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

        if ($request->hasFile('announcement_images')) {
            foreach ($request->file('announcement_images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('uploads/announcements', 'public');
                    $imagePaths[] = $path; // Save relative path
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
            'announcement_images' => 'nullable|array',
            'announcement_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:51200',
        ]);

        $announcement->announcement_title = $request->announcement_title;
        $announcement->description_text = $request->description_text;

        if ($request->hasFile('announcement_images')) {
            // Delete old images
            if ($announcement->announcement_images) {
                $oldImages = json_decode($announcement->announcement_images, true);
                foreach ($oldImages as $image) {
                    $imagePath = storage_path('app/public/' . $image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }

            // Upload new images
            $imagePaths = [];
            foreach ($request->file('announcement_images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('uploads/announcements', 'public');
                    $imagePaths[] = $path; // Save relative path
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
                $imagePath = public_path($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
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
}
