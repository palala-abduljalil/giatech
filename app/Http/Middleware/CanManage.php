<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SystemModule;
use Illuminate\Http\Request;

class CanManage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, String $module)
    {
        $modules = [
            'content' => SystemModule::CAN_MANAGE_CONTENT,
            'employees' => SystemModule::CAN_MANAGE_EMPLOYEES,
            'users' => SystemModule::CAN_MANAGE_USER,
            'clients' => SystemModule::CAN_MANAGE_CLIENTS,
            'projects' => SystemModule::CAN_MANAGE_PROJECTS,
            'finance' => SystemModule::CAN_MANAGE_FINANCE,
            'report' => SystemModule::CAN_GENERATE_REPORTS,
        ];

        if (!in_array($modules[$module], array_column(auth()->user()->modules->all(), 'id'))) {
            abort(403);
        }
        
        return $next($request);
    }
}
