<x-layout title="Home">
  <main class="home-main">
    <div class="text-section">
      <h1 class="title">Villa Verkenner</h1>
      <p class="subtitle">Ontdek je droom vakanite villa</p>
    </div>
    <form action="{{ route('aanbod') }}" method="GET" class="search" id="searchForm">
      <input type="text" name="search" placeholder="Zoek in Oostenrijk..." onkeypress="submitOnEnter(event)">
      <button type="submit" title="Search"><i class="fa-solid fa-location-dot"></i></button>
    </form>
  </main>

  <script>
    function submitOnEnter(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        document.getElementById('searchForm').submit();
      }
    }
  </script>
</x-layout>