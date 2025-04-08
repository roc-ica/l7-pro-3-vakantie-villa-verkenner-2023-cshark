@extends('layouts.admin')

@section('content')
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <div>
                <h1>Admin Dashboard</h1>
                <p>Welkom, {{ Auth::guard('admin')->user()->username }}!</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-sign-out-alt"></i> Uitloggen
                </button>
            </form>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Totale Woningen</h3>
                <p>{{ \App\Models\House::withTrashed()->count() }}</p>
            </div>
            <div class="stat-card">
                <h3>Actieve Woningen</h3>
                <p>{{ \App\Models\House::count() }}</p>
            </div>
            <div class="stat-card">
                <h3>Populaire Woningen</h3>
                <p>{{ \App\Models\House::where('popular', true)->count() }}</p>
            </div>
            <div class="stat-card">
                <h3>Informatieaanvragen</h3>
                <p>{{ \App\Models\HouseRequestLog::where('completed', false)->count() }}</p>
            </div>
        </div>
        <div class="dashboard-actions">
            <a href="{{ route('admin.houses.create') }}" class="action-btn">
                <i class="fa-solid fa-plus"></i> Nieuwe Woning Toevoegen
            </a>
            <a href="{{ route('admin.features.index') }}" class="action-btn">
                <i class="fa-solid fa-list-check"></i> Eigenschappen Beheren
            </a>
            <a href="{{ route('admin.geo-options.index') }}" class="action-btn">
                <i class="fa-solid fa-location-dot"></i> Locaties Beheren
            </a>
            <a href="{{ route('admin.requests.index') }}" class="action-btn">
                <i class="fa-solid fa-envelope"></i> Informatieaanvragen
            </a>
        </div>

        <div class="data-table-container">
            <h2>Woningenlijst</h2>

            <div class="table-toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Zoek woningen...">
                </div>
                
                <div class="table-actions">
                    <button id="toggleDeletedBtn">
                        <i class="fa-solid fa-trash"></i> Toon Verwijderde Woningen
                    </button>
                </div>
            </div>

            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Naam</th>
                            <th>Adres</th>
                            <th>Prijs</th>
                            <th>Kamers</th>
                            <th>Status</th>
                            <th class="actions-column">Acties</th>
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
                                        <a href="{{ route('admin.houses.edit', $house->id) }}" class="edit-btn" title="Bewerken">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="{{ route('detail', $house->id) }}" class="view-btn" title="Bekijken">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.houses.destroy', $house->id) }}" class="delete-form"
                                            onsubmit="return confirm('Weet u zeker dat u deze woning wilt verwijderen uit de lijsten?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn" title="Verwijderen uit Lijsten">
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
                    Pagina {{ $houses->currentPage() }} van {{ $houses->lastPage() }}
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

                    toggleDeletedBtn.innerHTML = '<i class="fa-solid fa-check"></i> Toon Actieve Woningen';
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
                                        <span class="status-badge deleted">Verwijderd</span>
                                    </td>
                                    <td class="actions-cell">
                                        <div class="row-actions">
                                            <form method="POST" action="/admin/houses/${house.id}/restore" class="restore-form">
                                                @csrf
                                                <button type="submit" class="restore-btn" title="Herstellen">
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
                    toggleDeletedBtn.innerHTML = '<i class="fa-solid fa-trash"></i> Toon Verwijderde Woningen';
                    window.location.reload();
                }
            });
        });
    </script>
@endsection
