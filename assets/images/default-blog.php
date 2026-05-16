<?php
/**
 * default-blog.jpg placeholder generator
 * This script generates a simple SVG-based placeholder image.
 * Access: /assets/images/default-blog.jpg
 * 
 * Since we can't ship a binary JPG, we use PHP to serve an SVG as fallback.
 * Rename this file to default-blog.php and update DEFAULT_IMAGE in config/db.php
 * OR simply drop a real default-blog.jpg into /assets/images/
 */
header('Content-Type: image/svg+xml');
echo '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="450" viewBox="0 0 800 450">
  <rect width="800" height="450" fill="#e9ecef"/>
  <rect x="340" y="175" width="120" height="100" rx="8" fill="#adb5bd"/>
  <circle cx="370" cy="200" r="15" fill="#6c757d"/>
  <polygon points="340,275 400,210 460,275" fill="#6c757d"/>
  <polygon points="390,275 430,235 460,275" fill="#adb5bd"/>
  <text x="400" y="320" font-family="Arial,sans-serif" font-size="18" fill="#6c757d" text-anchor="middle">No Image Available</text>
</svg>';
