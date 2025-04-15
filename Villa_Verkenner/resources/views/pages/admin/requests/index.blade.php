@extends('layouts.admin')

@section('content')
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <div>
                <h1>Woningaanvragen</h1>
                <p>Bekijk en beheer aanvragen voor woninginformatie</p>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="back-btn">
                    <i class="fa-solid fa-arrow-left"></i> Terug naar Dashboard
                </a>
            </div>
        </div>

        <div class="data-table-container">
            <h2>Informatie Aanvragen</h2>

            <div class="table-toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Zoek aanvragen...">
                </div>
                
                <div class="table-actions">
                    <button id="toggleCompletedBtn">
                        <i class="fa-solid fa-filter"></i> Toon Inbehandeling
                    </button>
                </div>
            </div>

            <div class="data-table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Woning</th>
                            <th>Email</th>
                            <th>Bericht</th>
                            <th>Datum</th>
                            <th>Status</th>
                            <th class="actions-column">Acties</th>
                        </tr>
                    </thead>
                    <tbody id="requestsTableBody">
                        @forelse($requests as $request)
                            <tr data-completed="{{ $request->completed ? 'true' : 'false' }}">
                                <td>{{ $request->id }}</td>
                                <td>
                                    <a href="{{ route('detail', $request->house_object_id) }}" class="house-link" target="_blank">
                                        {{ $request->house->name ?? 'Onbekend' }}
                                    </a>
                                </td>
                                <td>{{ $request->email }}</td>
                                <td>
                                    <div class="message-preview">
                                        {{ Str::limit($request->message, 50) }}
                                        @if(strlen($request->message) > 50)
                                            <button class="view-more-btn" data-message="{{ $request->message }}">meer...</button>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $request->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <span class="status-badge {{ $request->completed ? 'completed' : 'pending' }}">
                                        {{ $request->completed ? 'Afgehandeld' : 'In behandeling' }}
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <div class="row-actions">
                                        @if($request->completed)
                                            <form method="POST" action="{{ route('admin.requests.pending', $request->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="pending-btn" title="Markeer als in behandeling">
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.requests.complete', $request->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="complete-btn" title="Markeer als afgehandeld">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.requests.destroy', $request->id) }}" class="delete-form"
                                            onsubmit="return confirm('Weet u zeker dat u deze aanvraag wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn" title="Verwijderen">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Geen aanvragen gevonden</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div class="message-modal" id="messageModal">
        <div class="message-modal-content">
            <span class="close-modal">&times;</span>
            <h3>Bericht</h3>
            <div id="fullMessage"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
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
            
            // Toggle completed requests
            const toggleCompletedBtn = document.getElementById('toggleCompletedBtn');
            let showingCompleted = true;
            
            toggleCompletedBtn.addEventListener('click', function() {
                showingCompleted = !showingCompleted;
                
                if (showingCompleted) {
                    toggleCompletedBtn.innerHTML = '<i class="fa-solid fa-filter"></i> Toon Afgehandelde';
                    document.querySelectorAll('tr[data-completed="true"]').forEach(row => {
                        row.style.display = '';
                    });
                } else {
                    toggleCompletedBtn.innerHTML = '<i class="fa-solid fa-filter"></i> Toon Alle';
                    document.querySelectorAll('tr[data-completed="true"]').forEach(row => {
                        row.style.display = 'none';
                    });
                }
            });
            
            // Message modal functionality
            const messageModal = document.getElementById('messageModal');
            const fullMessage = document.getElementById('fullMessage');
            const closeModal = document.querySelector('.close-modal');
            
            document.querySelectorAll('.view-more-btn').forEach(button => {
                button.addEventListener('click', function() {
                    fullMessage.textContent = this.getAttribute('data-message');
                    messageModal.style.display = 'flex';
                });
            });
            
            closeModal.addEventListener('click', function() {
                messageModal.style.display = 'none';
            });
            
            window.addEventListener('click', function(event) {
                if (event.target === messageModal) {
                    messageModal.style.display = 'none';
                }
            });
        });
    </script>
@endsection
