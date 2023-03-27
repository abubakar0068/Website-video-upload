<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the file input
        $request->validate([
            'video' => 'required|mimes:mp4|max:100000',
        ]);

        // Get the uploaded file
        $videoFile = $request->file('video');

        // Check the duration of the video
        $duration = $this->getVideoDuration($videoFile);
        if ($duration >= 180) {
            return back()->withErrors(['Video duration should be no more than 3 minutes']);
        }

        // Upload the video
        $videoFile->store('videos');

        return back()->with('success', 'Video uploaded successfully.');
    }

    private function getVideoDuration($videoFile)
    {
        // Load the video into a video element
        $video = "<video src='" . $videoFile->getRealPath() . "'></video>";

        // Get the duration of the video
        $output = shell_exec("echo '$video' | ffmpeg -i - 2>&1");
        preg_match("/Duration: (\d{2}):(\d{2}):(\d{2})/", $output, $matches);
        $duration = ($matches[1] * 3600) + ($matches[2] * 60) + $matches[3];

        return $duration;
    }
}
