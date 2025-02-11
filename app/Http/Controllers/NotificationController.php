<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function manageNotification(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $notification = $request->id ? Notification::find($request->id) : new Notification;
        $notification->fill($request->all());
        $notification->save();

        return response()->json($notification, 201);
    }

    public function deleteNotification($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->delete();
            return response()->json(['message' => 'Notification deleted successfully']);
        }
        return response()->json(['message' => 'Notification not found'], 404);
    }

    public function getNotification($id)
    {
        $notification = Notification::find($id);
        return response()->json($notification);
    }

    public function getAllNotifications()
    {
        $notifications = Notification::all();
        return response()->json($notifications);
    }
}