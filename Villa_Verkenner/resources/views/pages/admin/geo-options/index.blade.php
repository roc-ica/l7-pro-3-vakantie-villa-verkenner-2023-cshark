@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Locatie Opties Beheren</h1>
            <p>Toevoegen, bewerken of verwijderen van locatie opties</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.geo-options.create') }}" class="action-btn">
                <i class="fa-solid fa-plus"></i> Nieuwe Locatie Optie Toevoegen
            </a>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i> Terug naar Dashboard
            </a>
        </div>
    </div>

    <div class="data-table-container">
        <h2>Locatie Opties Lijst</h2>

        <div class="table-toolbar">
            <div class="search-box">
                <i class="fa-solid fa-search"></i>
                <input type="text" id="searchInput" placeholder="Zoek locatie opties...">
            </div>
        </div>

        <div class="data-table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Aangemaakt Op</th>
                        <th class="actions-column">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($geoOptions as $option)
                        <tr>
                            <td>{{ $option->id }}</td>
                            <td>{{ $option->name }}</td>
                            <td>{{ $option->created_at->format('d M Y') }}</td>
                            <td class="actions-cell">
                                <div class="row-actions">
                                    <a href="{{ route('admin.geo-options.edit', $option->id) }}" class="edit-btn" title="Bewerken">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.geo-options.destroy', $option->id) }}" class="delete-form"
                                        onsubmit="return confirm('Weet u zeker dat u deze locatie optie wilt verwijderen? Dit kan niet ongedaan worden gemaakt als de optie niet door woningen wordt gebruikt.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" title="Verwijderen">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    
                    @if($geoOptions->count() == 0)
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem;">Geen locatie opties gevonden</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="pagination-controls">
            @if ($geoOptions->onFirstPage())
                <button class="pagination-btn" disabled>
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
            @else
                <a href="{{ $geoOptions->previousPageUrl() }}" class="pagination-btn">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            <span class="pagination-info">
                Pagina {{ $geoOptions->currentPage() }} van {{ $geoOptions->lastPage() }}
            </span>

            @if ($geoOptions->hasMorePages())
                <a href="{{ $geoOptions->nextPageUrl() }}" class="pagination-btn">
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
