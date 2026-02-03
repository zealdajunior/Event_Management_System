<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Services\NotificationService;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationManager extends Component
{
    use WithPagination;

    // Announcement Form
    public $title = '';
    public $message = '';
    public $notificationType = 'info';
    public $channel = 'app';
    public $targetRole = 'all';
    public $specificUsers = [];
    
    // Bulk Send
    public $showBulkForm = false;
    public $selectedUsers = [];
    
    // Search
    public $search = '';
    
    // States
    public $loading = false;
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'title' => 'required|min:3|max:100',
        'message' => 'required|min:10|max:500',
        'notificationType' => 'required|in:info,success,warning,error',
        'channel' => 'required|in:app,email,both',
        'targetRole' => 'required|in:all,user,admin'
    ];

    protected $messages = [
        'title.required' => 'Title is required',
        'title.min' => 'Title must be at least 3 characters',
        'title.max' => 'Title must not exceed 100 characters',
        'message.required' => 'Message is required',
        'message.min' => 'Message must be at least 10 characters',
        'message.max' => 'Message must not exceed 500 characters'
    ];

    public function sendAnnouncement()
    {
        $this->validate();
        
        $this->loading = true;
        $this->errorMessage = '';
        $this->successMessage = '';
        
        try {
            $notificationService = new NotificationService();
            
            if ($this->targetRole === 'all') {
                // For "all users", actually send to regular users only (not admins)
                // Admins manage notifications, users receive them
                $notificationService->sendToRole(
                    'user',
                    $this->title,
                    $this->message,
                    $this->notificationType,
                    [],
                    $this->channel
                );
                $this->successMessage = 'Announcement sent to all users successfully!';
            } else {
                $notificationService->sendToRole(
                    $this->targetRole,
                    $this->title,
                    $this->message,
                    $this->notificationType,
                    [],
                    $this->channel
                );
                $this->successMessage = "Announcement sent to all {$this->targetRole}s successfully!";
            }
            
            // Dispatch event to refresh notification centers
            $this->dispatch('refresh-notifications');
            
            // Reset form
            $this->resetForm();
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to send announcement: ' . $e->getMessage();
        }
        
        $this->loading = false;
    }

    public function sendToSelected()
    {
        $this->validate([
            'selectedUsers' => 'required|array|min:1',
            'title' => 'required|min:3|max:100',
            'message' => 'required|min:10|max:500'
        ]);
        
        $this->loading = true;
        
        try {
            $users = User::whereIn('id', $this->selectedUsers)->get();
            $notificationService = new NotificationService();
            
            $notificationService->send(
                $users->toArray(),
                $this->title,
                $this->message,
                $this->notificationType,
                [],
                $this->channel
            );
            
            $this->successMessage = 'Notifications sent to selected users successfully!';
            $this->dispatch('refresh-notifications');
            $this->resetForm();
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to send notifications: ' . $e->getMessage();
        }
        
        $this->loading = false;
    }

    public function resetForm()
    {
        $this->title = '';
        $this->message = '';
        $this->notificationType = 'info';
        $this->channel = 'app';
        $this->targetRole = 'all';
        $this->selectedUsers = [];
        $this->showBulkForm = false;
    }

    public function toggleUserSelection($userId)
    {
        if (in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
        } else {
            $this->selectedUsers[] = $userId;
        }
    }

    public function selectAllUsers()
    {
        $users = $this->getFilteredUsers();
        $this->selectedUsers = $users->pluck('id')->toArray();
    }

    public function deselectAllUsers()
    {
        $this->selectedUsers = [];
    }

    public function getFilteredUsers()
    {
        $query = User::query();
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        
        return $query->orderBy('name')->paginate(10);
    }

    public function clearMessages()
    {
        $this->successMessage = '';
        $this->errorMessage = '';
    }

    public function render()
    {
        $users = $this->getFilteredUsers();
        
        return view('livewire.admin.notification-manager', compact('users'));
    }
}
