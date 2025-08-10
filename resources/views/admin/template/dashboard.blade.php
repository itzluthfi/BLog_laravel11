@extends('layout.template') {{-- Pastikan layout utama bernama layouts.admin --}}

@section('title', 'Dashboard')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <!-- [ Breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Dashboard</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Statistik Utama -->
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-primary">
                                    <i class="fas fa-users f-20 text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Pengguna</h6>
                                <h3 class="mb-0">{{ $totalUsers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-success">
                                    <i class="fas fa-paper-plane f-20 text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Artikel</h6>
                                <h3 class="mb-0">{{ $totalBlogs }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-warning">
                                    <i class="fas fa-comments f-20 text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Komentar</h6>
                                <h3 class="mb-0">{{ $totalComments }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar bg-light-info">
                                    <i class="fas fa-tags f-20 text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Kategori</h6>
                                <h3 class="mb-0">{{ $totalCategories }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik & Artikel Terbaru -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Artikel per Kategori</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Artikel Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @if($latestBlogs->isEmpty())
                            <p class="text-muted">Belum ada artikel.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach($latestBlogs as $blog)
                                    <li class="list-group-item px-0 py-2">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="me-2">
                                                <a href="{{ route('profile.blog.edit', $blog->id) }}" class="text-primary fw-bold">{{ Str::limit($blog->title, 40) }}</a>
                                                <div class="text-muted small mt-1">
                                                    Oleh: {{ $blog->author->username ?? 'Unknown' }}<br>
                                                    {{ $blog->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <span class="badge">{{ $blog->category->name ?? 'Umum' }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
@endsection

{{-- @section('footer')
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">Go Blog^_^ &#9829; crafted by One Man Standing <a href="https://themeforest.net/user/phoenixcoded" target="_blank">Itzluthfi</a></p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-link mb-0">
                        <li class="list-inline-item"><a href="../index.html">Home</a></li>
                        <li class="list-inline-item"><a href="https://phoenixcoded.gitbook.io/able-pro/" target="_blank">Documentation</a></li>
                        <li class="list-inline-item"><a href="https://phoenixcoded.authordesk.app/" target="_blank">Support</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection --}}

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik: Artikel per Kategori
    const ctx = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($categoryNames),
            datasets: [{
                label: 'Jumlah Artikel',
                data: @json($articleCounts),
                backgroundColor: '#0d6efd',
                borderColor: '#0d6efd',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endsection