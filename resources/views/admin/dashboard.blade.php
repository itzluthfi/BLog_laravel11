@extends('layout.dashboardAdmin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-gray-100 p-6 rounded-lg shadow">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h2>

    <!-- Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @php
            $stats = [
                ['icon' => 'ri-user-line', 'title' => 'Total Pengguna', 'count' => $totalUsers, 'color' => 'bg-indigo-500'],
                ['icon' => 'ri-article-line', 'title' => 'Total Artikel', 'count' => $totalBlogs, 'color' => 'bg-green-500'],
                ['icon' => 'ri-chat-3-line', 'title' => 'Total Komentar', 'count' => $totalComments, 'color' => 'bg-yellow-500'],
                ['icon' => 'ri-folder-line', 'title' => 'Total Kategori', 'count' => $totalCategories, 'color' => 'bg-red-500'],
            ];
        @endphp

        @foreach ($stats as $stat)
        <div class="{{ $stat['color'] }} p-5 rounded-lg shadow-lg text-white flex items-center">
            <i class="{{ $stat['icon'] }} text-4xl md:text-5xl mr-4"></i>
            <div>
                <h3 class="text-md font-semibold">{{ $stat['title'] }}</h3>
                <p class="text-2xl md:text-3xl font-bold">{{ $stat['count'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Grafik Artikel per Kategori -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Artikel per Kategori</h3>
        <div class="w-full h-[300px]">
            <canvas id="articleChart"></canvas>
        </div>
    </div>

    <!-- Artikel Terbaru -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Artikel Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-indigo-200 text-gray-800">
                        <th class="py-3 px-4 text-left">Judul</th>
                        <th class="py-3 px-4 text-left">Kategori</th>
                        <th class="py-3 px-4 text-left">Penulis</th>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-left">Terakhir Diperbarui</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestBlogs as $blog)
                    <tr class="border-t border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $blog->title }}</td>
                        <td class="py-3 px-4">{{ $blog->category->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $blog->author->username }}</td>
                        <td class="py-3 px-4">{{ $blog->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4 italic">{{ $blog->updated_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('articleChart').getContext('2d');
    const articleChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoryNames) !!},
            datasets: [{
                label: 'Jumlah Artikel',
                data: {!! json_encode($articleCounts) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection
