@extends('layouts.admin')

@section('content')
    <div class="admin-dashboard">
        <h1>Admin Dashboard</h1>
        <p>Welcome, {{ Auth::guard('admin')->user()->username }}!</p>
        
        <div class="dashboard-stats">
            <!-- Add your dashboard content here -->
            <div class="stat-card">
                <h3>Total Houses</h3>
                <p>{{ \App\Models\House::count() }}</p>
            </div>
            
            <!-- Add more stat cards as needed -->
        </div>
    </div>
@endsection