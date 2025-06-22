<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .edit-card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .required-field {
            color: #dc3545;
        }
        .item-id-display {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.75rem;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-edit text-warning"></i> Edit Item Exchange</h2>
                    <a href="{{ route('exchange_items.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

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

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Edit Form Card -->
                <div class="card edit-card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Item Exchange</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('exchange_items.update', $exchangeItem->id_item) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="id_item_display" class="form-label">ID Item:</label>
                                        <div class="item-id-display">
                                            {{ $exchangeItem->id_item }}
                                        </div>
                                        <small class="text-muted">ID tidak dapat diubah</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="item_name" class="form-label">
                                            Nama Item <span class="required-field">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('item_name') is-invalid @enderror" 
                                               id="item_name" 
                                               name="item_name" 
                                               value="{{ old('item_name', $exchangeItem->item_name) }}" 
                                               required 
                                               placeholder="Masukkan nama item">
                                        @error('item_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="location" class="form-label">
                                            Lokasi <span class="required-field">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('location') is-invalid @enderror" 
                                               id="location" 
                                               name="location" 
                                               value="{{ old('location', $exchangeItem->location) }}" 
                                               required 
                                               placeholder="Masukkan lokasi item">
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="item_quantity" class="form-label">
                                            Jumlah Item <span class="required-field">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="number" 
                                                   class="form-control @error('item_quantity') is-invalid @enderror" 
                                                   id="item_quantity" 
                                                   name="item_quantity" 
                                                   value="{{ old('item_quantity', $exchangeItem->item_quantity) }}" 
                                                   min="1" 
                                                   required 
                                                   placeholder="0">
                                            <span class="input-group-text">unit</span>
                                            @error('item_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-text">Minimal 1 unit</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <hr>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save"></i> Update Item
                                        </button>
                                        <a href="{{ route('exchange_items.show', $exchangeItem->id_item) }}" 
                                           class="btn btn-info">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                        <a href="{{ route('exchange_items.index') }}" 
                                           class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>