<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'announcement_title' => 'required|string|max:255',
            'description_text' => 'required|string',
            'announcement_images' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('announcement_images')) {
            $imagePath = $request->file('announcement_images')->store('assets/uploads/announcements', 'public');
        }

        Announcement::create([
            'announcement_title' => $request->announcement_title,
            'description_text' => $request->description_text,
            'announcement_images' => $imagePath,
            'created_at' => now(),
            'posted_at' => now(),
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement posted successfully.');
    }
}
