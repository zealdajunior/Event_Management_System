<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\AuditLogger;

class UpdateProfilePhoto extends Component
{
    use WithFileUploads;

    public $photo;
    public $currentPhotoPath;

    public function mount()
    {
        $this->currentPhotoPath = Auth::user()->profile_photo_path;
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048', // 2MB Max
        ]);
    }

    public function save()
    {
        $this->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Store new photo
        $path = $this->photo->store('profile-photos', 'public');

        // Update user
        $user->update([
            'profile_photo_path' => $path,
        ]);

        // Log the action
        AuditLogger::log('Updated profile photo', 'User updated their profile photo', 'info');

        $this->currentPhotoPath = $path;
        $this->photo = null;

        session()->flash('message', 'Profile photo updated successfully!');
        
        // Refresh the page to show new photo
        return redirect()->route('profile');
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            // Delete photo from storage
            Storage::disk('public')->delete($user->profile_photo_path);

            // Update user
            $user->update([
                'profile_photo_path' => null,
            ]);

            // Log the action
            AuditLogger::log('Deleted profile photo', 'User deleted their profile photo', 'info');

            $this->currentPhotoPath = null;

            session()->flash('message', 'Profile photo deleted successfully!');
            
            return redirect()->route('profile');
        }
    }

    public function render()
    {
        return view('livewire.profile.update-profile-photo');
    }
}
