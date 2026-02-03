<?php

namespace App\Livewire;

use App\Models\AppNotification;
use App\Services\NotificationService;
use Livewire\Component;
use Livewire\Attributes\On;

class NotificationCenter extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $showDropdown = false;
    public $loading = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->loading = true;
        
        $notificationService = new NotificationService();
        $this->notifications = $notificationService->getRecentNotifications(auth()->id(), 15);
        $this->unreadCount = $notificationService->getUnreadCount(auth()->id());
        
        $this->loading = false;
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
        
        if ($this->showDropdown) {
            $this->loadNotifications();
        }
    }

    public function markAsRead($notificationId)
    {
        $notificationService = new NotificationService();
        $success = $notificationService->markAsRead($notificationId, auth()->id());
        
        if ($success) {
            $this->loadNotifications();
            $this->dispatch('notification-read', $notificationId);
        }
    }

    public function markAllAsRead()
    {
        $notificationService = new NotificationService();
        $count = $notificationService->markAllAsRead(auth()->id());
        
        if ($count > 0) {
            $this->loadNotifications();
            $this->dispatch('all-notifications-read');
        }
    }

    public function deleteNotification($notificationId)
    {
        AppNotification::where('id', $notificationId)
            ->where('user_id', auth()->id())
            ->delete();
            
        $this->loadNotifications();
    }

    #[On('notification-sent')]
    public function onNotificationSent()
    {
        $this->loadNotifications();
    }

    #[On('refresh-notifications')]
    public function refreshNotifications()
    {
        $this->loadNotifications();
    }

    public function getTypeIconAttribute($type)
    {
        return match($type) {
            'success' => 'check-circle',
            'warning' => 'exclamation-triangle',
            'error' => 'x-circle',
            default => 'information-circle'
        };
    }

    public function getTypeColorAttribute($type)
    {
        return match($type) {
            'success' => 'text-green-600',
            'warning' => 'text-yellow-600',
            'error' => 'text-red-600',
            default => 'text-blue-600'
        };
    }

    public function render()
    {
        return view('livewire.notification-center');
    }
}
