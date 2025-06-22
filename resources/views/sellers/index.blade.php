<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- navbar -->
    <x-header.navbar/>
    <div class="container my-4">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Seller</h3>
                <a href="{{ route('sellers.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Tambah Seller Baru
                </a>
            </div>
            <div class="card-body">
                @if($sellers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Seller</th>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nama Toko</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>Jenis Bisnis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sellers as $seller)
                                    <tr>
                                        <td>{{ $seller->seller_id }}</td>
                                        <td>{{ $seller->username_seller }}</td>
                                        <td>{{ $seller->full_name }}</td>
                                        <td>{{ $seller->shop_name }}</td>
                                        <td>{{ $seller->email }}</td>
                                        <td>{{ $seller->seller_phone_number }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $seller->business_type }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('sellers.show', $seller->seller_id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('sellers.edit', $seller->seller_id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('sellers.destroy', $seller->seller_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seller ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $sellers->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-store fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada seller</h5>
                        <p class="text-muted">Klik tombol "Tambah Seller Baru" untuk mendaftarkan seller pertama.</p>
                        <a href="{{ route('sellers.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Seller Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- tambahin ini -->
    <x-footer.footer/> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>