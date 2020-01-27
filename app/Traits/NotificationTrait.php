<?php

namespace App\Traits;


trait NotificationTrait {

    public function hasUnreadNotifications()
    {
        return $this->unreadNotifications->count();
    }

    public function getTopBarNotifications()
    {
        return $this->unreadNotifications()->take(3)->get();
    }

    public function deleteNotification($id)
    {
        return $this->notifications()->find($id)->delete();
    }

    public function readNotification($id)
    {
        return $this->notifications()->find($id)->markAsRead();
    }

}
