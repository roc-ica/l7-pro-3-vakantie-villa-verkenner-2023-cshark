@extends('layouts.admin')

@section('content')
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <div>
                <h1>Admin Dashboard</h1>
                <p>Welcome, {{ Auth::guard('admin')->user()->username }}!</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Total Houses</h3>
                <p>{{ \App\Models\House::count() }}</p>
            </div>
            
            <div class="stat-card">
                <h3>Available Properties</h3>
                {{-- <p>{{ \App\Models\House::where('beschikbaar', true)->count() ?? 0 }}</p> --}}
            </div>
            
            <div class="stat-card">
                <h3>Total Features</h3>
                {{-- <p>{{ \App\Models\Feature::count() }}</p> --}}
            </div>
            
            <div class="stat-card">
                <h3>Geo Options</h3>
                {{-- <p>{{ \App\Models\GeoOption::count() }}</p> --}}
            </div>
        </div>
        
        <div class="dashboard-actions">
            <a href="#" class="action-btn">
                <i class="fa-solid fa-plus"></i> Add New House
            </a>
            <a href="#" class="action-btn">
                <i class="fa-solid fa-database"></i> Manage Data
            </a>
        </div>
        
        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <div class="activity-details">
                        <h4>New House Added</h4>
                        <p>A new property was added to the database</p>
                    </div>
                    <div class="activity-time">Today</div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Admin Login</h4>
                        <p>Administrator logged in to the system</p>
                    </div>
                    <div class="activity-time">Yesterday</div>
                </div>
            </div>
        </div>
    </div>
@endsection