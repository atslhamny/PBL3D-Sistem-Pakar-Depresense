<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.audit-logs.index', compact('logs'));
    }
}
