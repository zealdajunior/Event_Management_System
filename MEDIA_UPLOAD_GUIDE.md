# Media Upload System - Quick Start Guide

## 🎉 What's New?

Your event management system now supports **images and videos** for both events and event requests!

---

## 📸 How to Upload Media

### For Event Organizers:

1. **Go to Create Event** (`/events/create`)
2. **Scroll to "Event Media" section**
3. **Upload Images:**
   - Click or drag-and-drop images
   - Supported formats: JPG, PNG, GIF, WEBP
   - Max size: 10MB per image
   - Multiple images allowed
4. **Upload Videos:**
   - Click or drag-and-drop videos
   - Supported formats: MP4, MOV, AVI, WMV, FLV
   - Max size: 100MB per video
   - Multiple videos allowed
5. **Submit** - Media uploads with your event!

### For Users Requesting Events:

1. **Go to Request Event** (`/event-requests/create`)
2. **Fill in event details**
3. **Scroll to "Event Media" section**
4. **Upload images and videos** (same process as above)
5. **Submit Request**
6. **When Admin Approves:** All media automatically transfers to the created event!

---

## 🖼️ Where Media Appears

### Event Show Page:
- Full photo gallery with lightbox zoom
- Video player for each video
- Featured image badge on first uploaded image
- Media count badges

### Event Listings:
- Thumbnail uses featured image (or first image)
- Shows count of images and videos on card

### Admin Dashboard:
- Preview event media when reviewing requests
- See media in event details

---

## 📂 File Organization

Media files are automatically organized:

```
storage/app/public/
├── events/
│   ├── 1/
│   │   ├── images/
│   │   │   ├── uuid-1.jpg
│   │   │   └── uuid-2.png
│   │   └── videos/
│   │       └── uuid-1.mp4
│   └── 2/
│       └── images/
│           └── uuid-1.jpg
└── event_requests/
    ├── 1/
    │   ├── images/
    │   └── videos/
    └── 2/
        └── images/
```

**File Naming:** UUIDs prevent conflicts and expose no sensitive info

---

## 🔧 Technical Details

### Database Schema

**event_media table:**
```sql
- id
- event_id (nullable, links to events)
- event_request_id (nullable, links to event_requests)
- file_name (original filename)
- file_path (storage path)
- file_type ('image' or 'video')
- mime_type (e.g., image/jpeg, video/mp4)
- file_size (in bytes)
- order (for sorting)
- caption (optional description)
- is_featured (boolean - first image defaults to true)
- created_at
- updated_at
```

### Models Updated

**Event Model:**
```php
$event->media         // All media
$event->images        // Only images
$event->videos        // Only videos
$event->featuredImage // Featured image
```

**EventRequest Model:**
```php
$request->media         // All media
$request->images        // Only images
$request->videos        // Only videos
$request->featuredImage // Featured image
```

**EventMedia Model:**
```php
$media->url            // Full URL to file
$media->isImage()      // Check if image
$media->isVideo()      // Check if video
$media->formattedSize  // Human-readable size (e.g., "2.5 MB")
```

### Controllers Enhanced

**EventController:**
- Validates image/video uploads
- Stores files in organized structure
- Creates EventMedia records
- First image auto-marked as featured

**EventRequestController:**
- Same upload handling as events
- **On approval:** Copies media from request to new event
- Preserves order and featured status

---

## 🎨 Blade Components

### Full Gallery Component
```blade
<x-event-media-gallery :event="$event" />
```

Shows:
- Grid of clickable images with lightbox
- Video players
- Caption support
- Featured badge
- No media message if empty

### Thumbnail Component
```blade
<x-event-thumbnail :event="$event" />
```

Shows:
- Featured or first image as background
- Gradient placeholder if no images
- Media count badges
- Responsive aspect ratio

---

## 🚀 How to Test

### Test Image Upload:

1. Create a test event
2. Upload 3-4 images (various sizes)
3. Upload 1 video
4. Click "Create Event"
5. **Verify:**
   - ✅ Event created successfully
   - ✅ Files appear in `storage/app/public/events/{event_id}/`
   - ✅ Database records in `event_media` table
   - ✅ Gallery displays on event show page
   - ✅ Lightbox works when clicking images
   - ✅ Videos play correctly

### Test Event Request Flow:

1. Submit event request with media
2. Login as admin
3. Approve the request
4. **Verify:**
   - ✅ New event created
   - ✅ Media copied to event
   - ✅ Original request media still intact
   - ✅ Featured status preserved

---

## 🔒 Security Features

✅ **File Type Validation** - Only allowed formats accepted
✅ **Size Limits** - 10MB images, 100MB videos
✅ **UUID Naming** - Prevents file name conflicts
✅ **MIME Type Check** - Server-side validation
✅ **Auto-Delete** - Media deleted when event/request deleted
✅ **Public Storage** - Files served via symbolic link

---

## 🐛 Troubleshooting

### Images Not Showing?

**Check symbolic link:**
```bash
php artisan storage:link
```

**Verify files exist:**
```bash
ls -la storage/app/public/events/
```

### Upload Fails?

**Check PHP limits:**
```ini
; php.ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
```

**Check folder permissions:**
```bash
chmod -R 775 storage/app/public
```

### Lightbox Not Working?

**Verify Alpine.js loaded** - Check browser console for errors

---

## 📊 Database Queries

### Get all events with media:
```php
Event::with(['media', 'images', 'videos', 'featuredImage'])->get();
```

### Count media files:
```php
$event->media->count();
$event->images->count();
$event->videos->count();
```

### Get total storage used:
```php
$totalBytes = EventMedia::sum('file_size');
$totalMB = round($totalBytes / 1024 / 1024, 2);
```

### Find events with videos:
```php
Event::whereHas('videos')->get();
```

---

## 🎯 Next Steps

Consider adding:

1. **Image Compression** - Reduce storage costs
   ```bash
   composer require intervention/image
   ```

2. **Video Thumbnails** - Generate preview images
   ```bash
   composer require pbmedia/laravel-ffmpeg
   ```

3. **Drag-to-Reorder** - Let users reorder media
4. **Caption Editing** - Add captions after upload
5. **Bulk Delete** - Remove multiple files at once
6. **Cloud Storage** - AWS S3, Cloudinary integration

---

## 📞 Need Help?

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify database migrations ran: `php artisan migrate:status`
4. Test with small files first (< 1MB)

---

## ✅ Checklist for Going Live

- [ ] Test file uploads with various formats
- [ ] Test large file uploads (near size limits)
- [ ] Verify storage symbolic link exists
- [ ] Configure proper backup strategy
- [ ] Set up CDN for media delivery (optional)
- [ ] Monitor storage usage
- [ ] Test on mobile devices
- [ ] Verify video playback on different browsers

---

**Enjoy your new media-rich event platform! 🎉📸🎥**
