<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminNotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $query = DB::table('notifications');

        // Filter by type
        if ($request->has('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        // Filter by read status
        if ($request->has('read') && $request->read !== '') {
            if ($request->read === 'read') {
                $query->whereNotNull('read_at');
            } else {
                $query->whereNull('read_at');
            }
        }

        $notifications = $query->latest('created_at')->paginate(20);
        
        // Decode JSON data
        $notifications->getCollection()->transform(function ($notification) {
            $notification->data = json_decode($notification->data, true);
            return $notification;
        });

        return view('admin.notifications.index', compact('notifications'));
    }
}
