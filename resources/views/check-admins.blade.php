<!DOCTYPE html>
<html>
<head>
    <title>Admin Check</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f3f4f6; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #1f2937; border-bottom: 3px solid #3b82f6; padding-bottom: 10px; }
        .admin-card { background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 8px; padding: 15px; margin: 15px 0; }
        .super-admin { border-color: #9333ea; background: linear-gradient(to right, #faf5ff, #f3e8ff); }
        .label { font-weight: bold; color: #374151; }
        .value { color: #1f2937; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-super { background: #9333ea; color: white; }
        .badge-admin { background: #3b82f6; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Current Admins in System</h1>
        
        @php
            $admins = \App\Models\User::where('role', 'admin')->get();
            $totalAdmins = $admins->count();
            $superAdmins = $admins->where('is_super_admin', true)->count();
        @endphp
        
        <p><strong>Total Admins:</strong> {{ $totalAdmins }} | <strong>Super Admins:</strong> {{ $superAdmins }}</p>
        
        @forelse($admins as $admin)
            <div class="admin-card {{ $admin->is_super_admin ? 'super-admin' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="margin-bottom: 8px;">
                            <span class="label">Name:</span> 
                            <span class="value">{{ $admin->name }}</span>
                            @if($admin->is_super_admin)
                                <span class="badge badge-super">⭐ SUPER ADMIN</span>
                            @else
                                <span class="badge badge-admin">ADMIN</span>
                            @endif
                        </div>
                        <div style="margin-bottom: 8px;">
                            <span class="label">Email:</span> 
                            <span class="value">{{ $admin->email }}</span>
                        </div>
                        <div>
                            <span class="label">Created:</span> 
                            <span class="value">{{ $admin->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="admin-card">
                <p style="color: #6b7280; text-align: center;">No admin users found.</p>
            </div>
        @endforelse
        
        <div style="margin-top: 30px; padding: 15px; background: #eff6ff; border-radius: 8px; border-left: 4px solid #3b82f6;">
            <strong>To promote an admin to Super Admin, run:</strong>
            <code style="display: block; margin-top: 10px; padding: 10px; background: white; border-radius: 4px;">
                php artisan admin:promote-super [email]
            </code>
        </div>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="/" style="color: #3b82f6; text-decoration: none; font-weight: bold;">← Back to Home</a>
        </div>
    </div>
</body>
</html>
