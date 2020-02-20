<?php

return [
  'ffmpeg.binaries' => env('FFMPEG_BINARIES', '/usr/local/bin/ffmpeg'),
  'ffmpeg.threads'  => env('FFMPEG_THREADS', 12),
  'ffprobe.binaries' => env('FFMPEG_FFPROBE_BINARIES', '/usr/local/bin/ffprobe'),
  'timeout' => env('FFMPEG_TIMEOUT', 3600),
];
