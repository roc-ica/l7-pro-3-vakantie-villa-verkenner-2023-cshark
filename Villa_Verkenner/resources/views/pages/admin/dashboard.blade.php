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
                <p>{{ \App\Models\House::withTrashed()->count() }}</p>
            </div>
            <div class="stat-card">
                <h3>Active Houses</h3>
                <p>{{ \App\Models\House::count() }}</p>
            </div>
            <div class="stat-card">
                <h3>Popular Houses</h3>
                <p>{{ \App\Models\House::where('popular', true)->count() }}</p>
            </div>
        </div>
        <div class="dashboard-actions">
            <a href="{{ route('admin.houses.create') }}" class="action-btn">
                <i class="fa-solid fa-plus"></i> Add New House
            </a>
            <a href="{{ route('admin.features.index') }}" class="action-btn">
                <i class="fa-solid fa-list-check"></i> Manage Features
            </a>
            <a href="{{ route('admin.geo-options.index') }}" class="action-btn">
                <i class="fa-solid fa-location-dot"></i> Manage Locations
            </a>
        </div>

        <div class="data-table-container">
            <h2>House List</h2>

            <div class="table-toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search houses...">
                </div>
                
                <div class="table-actions">
                    <button id="toggleDeletedBtn">
                        <i class="fa-solid fa-trash"></i> Show Deleted Houses
                    </button>
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
                    <tbody id="houseTableBody">
                        @php
                            $currentPage = request()->get('page', 1);
                            $perPage = 10;
                            $houses = \App\Models\House::latest()->paginate($perPage);
                        @endphp

                        @foreach ($houses as $house)
                            <tr data-deleted="false">
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
                                        <a href="{{ route('admin.houses.edit', $house->id) }}" class="edit-btn" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="{{ route('detail', $house->id) }}" class="view-btn" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.houses.destroy', $house->id) }}" class="delete-form"
                                            onsubmit="return confirm('Are you sure you want to remove this house from listings?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn" title="Remove from Listings">
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
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('.data-table tbody tr');
            const toggleDeletedBtn = document.getElementById('toggleDeletedBtn');
            let showingDeleted = false;

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
            toggleDeletedBtn.addEventListener('click', function() {
                showingDeleted = !showingDeleted;
                
                if (showingDeleted) {

                    toggleDeletedBtn.innerHTML = '<i class="fa-solid fa-check"></i> Show Active Houses';
                    fetch('/admin/houses/deleted')
                        .then(response => response.json())
                        .then(data => {
                            const tableBody = document.getElementById('houseTableBody');
                            tableBody.innerHTML = '';
                            
                            data.houses.forEach(house => {
                                tableBody.innerHTML += `
                                <tr data-deleted="true">
                                    <td>${house.id}</td>
                                    <td>${house.name}</td>
                                    <td>${house.address}</td>
                                    <td>€${new Intl.NumberFormat('nl-NL').format(house.price)}</td>
                                    <td>${house.rooms}</td>
                                    <td>
                                        <span class="status-badge deleted">Deleted</span>
                                    </td>
                                    <td class="actions-cell">
                                        <div class="row-actions">
                                            <form method="POST" action="/admin/houses/${house.id}/restore" class="restore-form">
                                                @csrf
                                                <button type="submit" class="restore-btn" title="Restore">
                                                    <i class="fa-solid fa-trash-arrow-up"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                `;
                            });
                        });
                } else {
                    toggleDeletedBtn.innerHTML = '<i class="fa-solid fa-trash"></i> Show Deleted Houses';
                    window.location.reload();
                }
            });
        });
    </script>
@endsection
