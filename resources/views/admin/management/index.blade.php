<x-app-layout>
    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="bg-white border-b border-blue-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 py-4 sm:py-8">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-gradient-to-br from-purple-500 to-blue-600">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg sm:text-2xl font-bold text-black">Super Admin Management</h1>
                            <p class="text-xs sm:text-sm text-gray-900">{{ $totalAdmins }} admins • {{ $totalUsers }} total users</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 border-2 border-blue-500 text-xs sm:text-sm font-bold rounded-xl text-black bg-white hover:bg-blue-50 transition-all duration-300 shadow-[0_4px_12px_rgba(59,130,246,0.3)] hover:shadow-[0_8px_20px_rgba(59,130,246,0.4)] w-full sm:w-auto">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span class="hidden sm:inline">Back to Dashboard</span>
                            <span class="sm:hidden">Back</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ================= PAGE CONTAINER ================= --}}
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ================= ALERTS ================= --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg" role="alert">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <ul class="list-disc list-inside text-sm text-red-800">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- ================= ADMIN MANAGEMENT ================= --}}
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                <div class="p-4 sm:p-6 bg-gradient-to-r from-white to-blue-50 border-b border-blue-50">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-0">
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-black flex items-center gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Admin Management
                                <span class="ml-2 text-xs sm:text-sm font-normal text-gray-900 bg-blue-100 px-2 sm:px-3 py-0.5 sm:py-1 rounded-full">{{ $admins->count() }} admins</span>
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-900 mt-1">Manage administrator accounts and privileges</p>
                        </div>
                        <button onclick="document.getElementById('create-admin-form').classList.toggle('hidden')" 
                                class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-xs sm:text-sm font-bold rounded-lg sm:rounded-xl transition-all duration-300 w-full sm:w-auto">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Admin
                        </button>
                    </div>
                </div>
                
                {{-- Collapsible Create Form --}}
                <div id="create-admin-form" class="hidden p-4 sm:p-6 bg-blue-50 border-b border-blue-100">
                    <form method="POST" action="{{ route('admin.admins.create') }}" class="space-y-3 sm:space-y-0 sm:grid sm:grid-cols-1 md:grid-cols-4 sm:gap-4">
                        @csrf
                        <input type="text" name="name" placeholder="Admin Name" required 
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <input type="email" name="email" placeholder="Email Address" required 
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <input type="password" name="password" placeholder="Password" required 
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            Create Admin
                        </button>
                    </form>
                </div>
                
                <div class="p-4 sm:p-6">
                    <div class="space-y-3 sm:space-y-4">
                        @forelse($admins as $admin)
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 sm:p-4 rounded-lg sm:rounded-xl hover:bg-blue-50 transition-colors border border-gray-100 gap-3 sm:gap-0">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="w-10 h-10 sm:w-10 sm:h-10 rounded-full {{ $admin->is_super_admin ? 'bg-gradient-to-br from-purple-500 to-blue-600' : 'bg-blue-500' }} flex items-center justify-center text-white font-bold text-sm sm:text-base flex-shrink-0">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-xs sm:text-sm font-bold text-black truncate">{{ $admin->name }}</span>
                                            @if($admin->is_super_admin)
                                                <span class="px-2 py-0.5 sm:py-1 bg-purple-100 text-purple-700 text-[10px] sm:text-xs font-bold rounded-lg flex-shrink-0">SUPER</span>
                                            @endif
                                        </div>
                                        <p class="text-[10px] sm:text-xs text-gray-600 truncate">{{ $admin->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                                    @if(!$admin->is_super_admin && $admin->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.toggle-super', $admin) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2 sm:px-3 py-1 bg-purple-100 text-purple-700 text-[10px] sm:text-xs font-bold rounded-lg hover:bg-purple-200 transition-colors whitespace-nowrap">
                                                Make Super
                                            </button>
                                        </form>
                                    @endif
                                    @if($admin->is_super_admin && $admin->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.toggle-super', $admin) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2 sm:px-3 py-1 bg-orange-100 text-orange-700 text-[10px] sm:text-xs font-bold rounded-lg hover:bg-orange-200 transition-colors whitespace-nowrap">
                                                Revoke Super
                                            </button>
                                        </form>
                                    @endif
                                    @if($admin->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.demote', $admin) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2 sm:px-3 py-1 bg-gray-100 text-gray-700 text-[10px] sm:text-xs font-bold rounded-lg hover:bg-gray-200 transition-colors whitespace-nowrap">
                                                Demote
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-600 py-8 text-sm">No admins found</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ================= USER MANAGEMENT ================= --}}
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
                <div class="p-4 sm:p-6 bg-gradient-to-r from-white to-blue-50 border-b border-blue-50">
                    <h3 class="text-base sm:text-lg font-bold text-black flex items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        User Management
                        <span class="ml-2 text-xs sm:text-sm font-normal text-gray-900 bg-blue-100 px-2 sm:px-3 py-0.5 sm:py-1 rounded-full">{{ $users->total() }} users</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-900 mt-1">Promote users to admin or remove accounts</p>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="space-y-2 sm:space-y-3">
                        @forelse($users as $user)
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 rounded-lg hover:bg-blue-50 transition-colors gap-3 sm:gap-0 border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 sm:w-8 sm:h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs sm:text-sm font-bold flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs sm:text-sm font-medium text-black truncate">{{ $user->name }}</p>
                                        <p class="text-[10px] sm:text-xs text-gray-600 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('admin.users.promote', $user) }}" class="inline flex-1 sm:flex-initial">
                                        @csrf
                                        <button type="submit" class="w-full sm:w-auto px-3 py-1 bg-blue-100 text-blue-700 text-[10px] sm:text-xs font-bold rounded hover:bg-blue-200 whitespace-nowrap">
                                            Promote
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline flex-1 sm:flex-initial" 
                                        onsubmit="return confirm('Delete {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full sm:w-auto px-3 py-1 bg-red-100 text-red-700 text-[10px] sm:text-xs font-bold rounded hover:bg-red-200 whitespace-nowrap">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-600 py-8 text-sm">No users found</p>
                        @endforelse
                    </div>
                    
                    {{-- Pagination --}}
                    @if($users->hasPages())
                        <div class="mt-4 sm:mt-6 border-t border-gray-200 pt-4">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
