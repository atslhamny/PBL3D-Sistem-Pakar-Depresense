<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('admin')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('entity_type', 'like', "%{$search}%")
                  ->orWhere('entity_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('method')) {
            $query->where('action', $request->method);
        }

        $logs = $query->paginate(15)->withQueryString();
            
        return view('admin.audit-logs.index', compact('logs'));
    }
}
