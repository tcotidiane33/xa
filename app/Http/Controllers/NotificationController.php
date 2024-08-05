<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;
use Notify\Laravel\Exception\NotifyException;
use Notify;

class NotificationController extends Controller
{
    public function create()
    {
        return view('notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        try {
            $content = $request->content;

            // Send notification
            Notify::send($content, [], 'slack'); // or use 'mail' for email notifications

            return redirect()->route('notifications.create')->with('success', 'Notification sent successfully.');
        } catch (Throwable $exception) {
            try {
                Notify::send($exception, [], 'mail'); // Fallback to email notification on failure

                return redirect()->route('notifications.create')->with('success', 'Notification sent successfully via email.');
            } catch (NotifyException $ne) {
                return redirect()->back()->with('error', 'Failed to send notification.');
            }
        }
    }
}
