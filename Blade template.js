<form method="post" action="{{ route('video.upload') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="video" id="video-upload">
    <button type="submit">Upload Video</button>
</form>

<script>
    const videoFile = document.getElementById('video-upload').files[0];
    const video = document.createElement('video');
    video.preload = 'metadata';
    video.src = URL.createObjectURL(videoFile);

    video.onloadedmetadata = function() {
        if (video.duration >= 180) {
            alert('Video duration should be no more than 3 minutes');
            return false;
        } else {
            // Proceed with uploading the video
            return true;
        }
    };
</script>
