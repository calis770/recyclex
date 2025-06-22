<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang Belanja</title>
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
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart"></i> Keranjang Belanja
                </h3>
                <div class="d-flex gap-2">
                    @if($carts->count() > 0)
                        <form action="{{ route('carts.clear') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('carts.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Item
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($carts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>ID Keranjang</th>
                                    <th>Produk</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalKeseluruhan = 0;
                                    $totalQuantity = 0;
                                @endphp
                                @foreach($carts as $index => $cart)
                                    @php
                                        $totalKeseluruhan += $cart->total_price;
                                        $totalQuantity += $cart->quantity;
                                    @endphp
                                    <tr>
                                        <td>{{ $carts->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $cart->id_cart }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $cart->product->product_name ?? 'Produk tidak ditemukan' }}</strong>
                                        </td>
                                        <td>
                                            @if($cart->product)
                                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="input-group" style="width: 120px;">
                                                <button class="btn btn-outline-secondary btn-sm quantity-btn" 
                                                        type="button" data-action="decrease" data-id="{{ $cart->id_cart }}">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" class="form-control form-control-sm text-center quantity-input" 
                                                       value="{{ $cart->quantity }}" min="1" data-id="{{ $cart->id_cart }}">
                                                <button class="btn btn-outline-secondary btn-sm quantity-btn" 
                                                        type="button" data-action="increase" data-id="{{ $cart->id_cart }}">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-primary total-price-{{ $cart->id_cart }}">
                                                Rp {{ number_format($cart->total_price, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('carts.show', $cart->id_cart) }}" 
                                                   class="btn btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('carts.edit', $cart->id_cart) }}" 
                                                   class="btn btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('carts.destroy', $cart->id_cart) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <td colspan="4"><strong>Total Keseluruhan</strong></td>
                                    <td><strong id="totalQuantityDisplay">{{ $totalQuantity }}</strong></td>
                                    <td colspan="2"><strong class="text-warning" id="totalPriceDisplay">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $carts->links() }}
                    </div>

                    <!-- Checkout Section -->
                    <div class="card mt-4 border-primary">
                        <div class="card-body text-center">
                            <h5 class="card-title">Siap untuk Checkout?</h5>
                            <p class="card-text">Total: <strong class="text-primary fs-4">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</strong></p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-shopping-bag"></i> Lanjut ke Pemesanan
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-calculator"></i> Hitung Estimasi
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Keranjang Anda Kosong</h4>
                        <p class="text-muted">Belum ada item yang ditambahkan ke keranjang.</p>
                        <a href="{{ route('carts.create') }}"
                        class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Item Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- tambahin ini -->
    <x-footer.footer/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Format number as Indonesian Rupiah
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        // Update quantity via AJAX
        function updateQuantity(cartId, newQuantity) {
            fetch(`/carts/${cartId}/update-quantity`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the total price display
                    document.querySelector(`.total-price-${cartId}`).textContent = data.formatted_price;
                    
                    // Recalculate overall total
                    updateOverallTotal();
                } else {
                    alert(data.message || 'Gagal memperbarui quantity');
                    // Reset the input value
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui quantity');
                location.reload();
            });
        }

        // Update overall total
        function updateOverallTotal() {
            let totalPrice = 0;
            let totalQuantity = 0;
            
            document.querySelectorAll('[class*="total-price-"]').forEach(element => {
                const priceText = element.textContent.replace(/[^\d]/g, '');
                totalPrice += parseInt(priceText) || 0;
            });
            
            document.querySelectorAll('.quantity-input').forEach(input => {
                totalQuantity += parseInt(input.value) || 0;
            });
            
            document.getElementById('totalPriceDisplay').textContent = 'Rp ' + formatRupiah(totalPrice);
            document.getElementById('totalQuantityDisplay').textContent = totalQuantity;
        }

        // Event listeners for quantity buttons
        document.querySelectorAll('.quantity-btn').forEach(button => {
            button.addEventListener('click', function() {
                const cartId = this.dataset.id;
                const action = this.dataset.action;
                const input = document.querySelector(`.quantity-input[data-id="${cartId}"]`);
                let currentValue = parseInt(input.value) || 1;
                
                if (action === 'increase') {
                    currentValue++;
                } else if (action === 'decrease' && currentValue > 1) {
                    currentValue--;
                }
                
                input.value = currentValue;
                updateQuantity(cartId, currentValue);
            });
        });

        // Event listeners for direct input
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const cartId = this.dataset.id;
                const newValue = parseInt(this.value) || 1;
                
                if (newValue < 1) {
                    this.value = 1;
                    return;
                }
                
                updateQuantity(cartId, newValue);
            });
        });
    </script>
</body>
</html>