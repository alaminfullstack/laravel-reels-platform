<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reels Player</title>
    <link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            overflow: hidden;
            background-color: #000;
        }
        .video-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .controls {
            position: absolute;
            bottom: 20px;
            left: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .controls button {
            background: rgba(255, 255, 255, 0.7);
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="videos"></div>
    <button id="load-more">Load More</button>

    <script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentPage = 1;

        function loadVideos(page) {
            $.ajax({
                url: `/api/reels?page=${page}`,
                type: 'GET',
                success: function(response) {
                    const videos = response.data;
                    if (videos.length > 0) {
                        videos.forEach(video => {
                            const videoContainer = $(`
                                <div class="video-container">
                                    <video id="video-${video.id}" class="video-js vjs-default-skin" autoplay muted loop preload="auto" data-setup="{}">
                                        <source src="/${video.path}" type="video/mp4" />
                                        <p class="vjs-no-js">
                                            To view this video please enable JavaScript, and consider upgrading to a web browser that
                                            <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                        </p>
                                    </video>
                                    <div class="controls">
                                        <button onclick="likeVideo(${video.id})">Like</button>
                                        <button onclick="shareVideo(${video.id})">Share</button>
                                    </div>
                                </div>
                            `);
                            $('#videos').append(videoContainer);
                            videojs(`video-${video.id}`);
                        });
                    } else {
                        $('#load-more').hide(); // Hide load more button if no more videos
                    }
                },
                error: function() {
                    alert('Failed to load videos');
                }
            });
        }

        $(document).ready(function() {
            loadVideos(currentPage);

            $('#load-more').on('click', function() {
                currentPage++;
                loadVideos(currentPage);
            });

            // Optionally, use infinite scroll instead of button click
            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    currentPage++;
                    loadVideos(currentPage);
                }
            });
        });

        function likeVideo(videoId) {
            alert(`Liked video with ID: ${videoId}`);
            // Implement actual like functionality here
        }

        function shareVideo(videoId) {
            alert(`Shared video with ID: ${videoId}`);
            // Implement actual share functionality here
        }
    </script>
</body>
</html>
