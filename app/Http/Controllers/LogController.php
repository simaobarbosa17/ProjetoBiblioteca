<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Log::with('user')
            ->when($request->filled('user'), function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->user . '%');
                });
            })
            ->when($request->filled('module'), function ($query) use ($request) {
                $query->where('module', 'like', '%' . $request->module . '%');
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->where('date', $request->date);
            })
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.log', compact('logs'));
    }
}