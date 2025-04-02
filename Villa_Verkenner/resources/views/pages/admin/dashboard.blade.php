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
                <h3>Available Houses</h3>
                <p>{{ \App\Models\House::where('status', 'Beschikbaar')->count() }}</p>
            </div>

            <div class="stat-card">
                <h3>Popular Houses</h3>
                <p>{{ \App\Models\House::where('popular', 'Yes')->count() ?? 0 }}</p>
            </div>
        </div>
        <div class="dashboard-actions">
            <a href="{{ route('admin.houses.create') }}" class="action-btn">
                <i class="fa-solid fa-plus"></i> Add New House
            </a>
        </div>

        <div class="data-table-container">
            <h2>House List</h2>

            <div class="table-toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search houses...">
                </div>
            </div>

            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Rooms</th>
                            <th>Status</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $currentPage = request()->get('page', 1);
                            $perPage = 10;
                            $houses = \App\Models\House::latest()->paginate($perPage);
                        @endphp

                        @foreach ($houses as $house)
                            <tr>
                                <td>{{ $house->id }}</td>
                                <td>{{ $house->name }}</td>
                                <td>{{ $house->address }}</td>
                                <td>€{{ number_format($house->price, 0, ',', '.') }}</td>
                                <td>{{ $house->rooms }}</td>
                                <td>
                                    <span
                                        class="status-badge {{ $house->status == 'Beschikbaar' ? 'available' : 'unavailable' }}">
                                        {{ $house->status }}
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <div class="row-actions">
                                        <a href="#" class="edit-btn" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="{{ route('detail', $house->id) }}" class="view-btn" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <form method="POST" action="#" class="delete-form"
                                            onsubmit="return confirm('Are you sure you want to delete this house?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-controls">
                @if ($houses->onFirstPage())
                    <button class="pagination-btn" disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                @else
                    <a href="{{ $houses->previousPageUrl() }}" class="pagination-btn">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                <span class="pagination-info">
                    Page {{ $houses->currentPage() }} of {{ $houses->lastPage() }}
                </span>

                @if ($houses->hasMorePages())
                    <a href="{{ $houses->nextPageUrl() }}" class="pagination-btn">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <button class="pagination-btn" disabled>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Simple client-side search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('.data-table tbody tr');

            searchInput.addEventListener('keyup', function() {
                const searchTerm = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
