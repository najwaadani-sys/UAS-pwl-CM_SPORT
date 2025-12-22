@extends('layouts.master')

@section('title', 'Kelola Produk - CM SPORT')

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')
    <div class="admin-content">
        <div class="admin-header">
            <div>
                <div class="admin-title">Kelola Produk</div>
                <p class="admin-subtitle">Atur inventori dan informasi produk Anda</p>
            </div>
        </div>
        
        @push('styles')
        <style>
        /* Modal Overlay - Fixed Position */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, .6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(4px);
        }
        
        .modal-overlay:target {
            display: flex !important;
        }
        
        .modal-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
            width: min(92vw, 500px);
            animation: modalSlideUp 0.3s ease;
            position: relative;
            z-index: 10000;
        }
        
        @keyframes modalSlideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .modal-title {
            font-weight: 900;
            font-size: 1.3rem;
            margin-bottom: .5rem;
            color: #000;
        }
        
        .modal-sub {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .modal-actions {
            display: flex;
            gap: .8rem;
            justify-content: flex-end;
        }
        
        .btn-admin.equal {
            min-width: 120px;
            text-align: center;
        }
        
        /* Enhanced Form Card */
        .form-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border: 2px solid #e0e0e0;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: relative;
        }
        
        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #E8001D 0%, #C20015 100%);
            border-radius: 16px 16px 0 0;
        }
        
        .form-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .form-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, rgba(232, 0, 29, 0.1) 0%, rgba(232, 0, 29, 0.05) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #E8001D;
        }
        
        .form-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #000;
        }
        
        .form-subtitle {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.2rem;
        }
        
        .form-section {
            margin-bottom: 1.5rem;
        }
        
        .section-label {
            font-weight: 700;
            color: #E8001D;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.2rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .required-mark {
            color: #E8001D;
            font-weight: 700;
        }
        
        .form-input, .form-select {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #E8001D;
            box-shadow: 0 0 0 3px rgba(232, 0, 29, 0.1);
        }
        
        .form-input:disabled, .form-select:disabled {
            background: #f5f5f5;
            color: #999;
            cursor: not-allowed;
        }
        
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.9rem 0;
        }
        
        .checkbox-input {
            width: 22px;
            height: 22px;
            cursor: pointer;
            accent-color: #E8001D;
        }
        
        .checkbox-label {
            font-weight: 600;
            color: #333;
            cursor: pointer;
        }
        
        .file-upload-wrapper {
            position: relative;
        }
        
        .file-upload-input {
            display: none;
        }
        
        .file-upload-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.9rem 1.2rem;
            border: 2px dashed #e0e0e0;
            border-radius: 10px;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #666;
            font-weight: 600;
        }
        
        .file-upload-button:hover {
            border-color: #E8001D;
            background: rgba(232, 0, 29, 0.05);
            color: #E8001D;
        }
        
        .image-preview {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .preview-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #e0e0e0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .form-actions {
            display: flex;
            gap: 0.8rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f0f0f0;
        }
        
        /* Enhanced Table */
        .table-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .table-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #000;
        }
        
        .table-subtitle {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.3rem;
        }
        
        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .admin-table thead {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .admin-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #E8001D;
        }
        
        .admin-table th:first-child {
            border-radius: 12px 0 0 0;
        }
        
        .admin-table th:last-child {
            border-radius: 0 12px 0 0;
        }
        
        .admin-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .admin-table tbody tr:hover {
            background: linear-gradient(135deg, rgba(232, 0, 29, 0.03) 0%, rgba(232, 0, 29, 0.01) 100%);
            transform: scale(1.01);
        }
        
        .admin-table td {
            padding: 1.2rem 1.5rem;
            color: #333;
            font-size: 0.95rem;
        }
        
        .product-name {
            font-weight: 600;
            color: #000;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .product-image-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }
        
        .category-badge {
            display: inline-block;
            background: linear-gradient(135deg, rgba(232, 0, 29, 0.1) 0%, rgba(232, 0, 29, 0.05) 100%);
            color: #E8001D;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid rgba(232, 0, 29, 0.2);
        }
        
        .price-display {
            font-weight: 700;
            color: #00b894;
            font-size: 1rem;
        }
        
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .stock-badge.high {
            background: rgba(0, 184, 148, 0.1);
            color: #00b894;
            border: 1px solid rgba(0, 184, 148, 0.3);
        }
        
        .stock-badge.medium {
            background: rgba(253, 203, 110, 0.1);
            color: #fdcb6e;
            border: 1px solid rgba(253, 203, 110, 0.3);
        }
        
        .stock-badge.low {
            background: rgba(214, 48, 49, 0.1);
            color: #d63031;
            border: 1px solid rgba(214, 48, 49, 0.3);
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-admin {
            padding: 0.7rem 1.3rem;
            border: 2px solid #e0e0e0;
            background: #fff;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.9rem;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .btn-admin.primary {
            background: linear-gradient(135deg, #E8001D 0%, #C20015 100%);
            color: #fff;
            border-color: #E8001D;
        }
        
        .btn-admin.primary:hover {
            box-shadow: 0 6px 20px rgba(232, 0, 29, 0.4);
        }
        
        .btn-edit {
            border-color: rgba(0, 184, 148, 0.3);
            color: #00b894;
        }
        
        .btn-edit:hover {
            background: #00b894;
            color: #fff;
            border-color: #00b894;
        }
        
        .btn-delete {
            border-color: rgba(214, 48, 49, 0.3);
            color: #d63031;
        }
        
        .btn-delete:hover {
            background: #d63031;
            color: #fff;
            border-color: #d63031;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .form-card {
                padding: 1.5rem;
            }
            
            .table-card {
                padding: 1rem;
                overflow-x: auto;
            }
            
            .admin-table {
                min-width: 800px;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn-admin.equal {
                width: 100%;
            }
        }
        </style>
        @endpush
        
        <div class="admin-card form-card">
            <div class="form-header">
                <div class="form-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 7h-9"></path>
                        <path d="M14 17H5"></path>
                        <circle cx="17" cy="17" r="3"></circle>
                        <circle cx="7" cy="7" r="3"></circle>
                    </svg>
                </div>
                <div>
                    <div class="form-title">{{ isset($editing) ? 'Edit Produk' : 'Tambah Produk Baru' }}</div>
                    <div class="form-subtitle">{{ isset($editing) ? 'Perbarui informasi produk' : 'Lengkapi data produk yang akan ditambahkan' }}</div>
                </div>
            </div>
            
            <form id="productForm" action="{{ isset($editing) ? route('admin.products.update', $editing->produk_id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($editing))
                @method('PUT')
                @endif
                
                <!-- Kategori Section -->
                <div class="form-section">
                    <div class="section-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        Kategori Produk
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">
                            Pilih Kategori <span class="required-mark">*</span>
                        </label>
                        <select name="kategori_id" id="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori Produk --</option>
                            @foreach($kategoriList as $k)
                            <option value="{{ $k->kategori_id }}" {{ isset($editing) && $editing->kategori_id == $k->kategori_id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Informasi Produk Section -->
                <div class="form-section">
                    <div class="section-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Informasi Produk
                    </div>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">
                                Nama Produk <span class="required-mark">*</span>
                            </label>
                            <input type="text" name="nama_produk" id="nama_produk" value="{{ isset($editing) ? $editing->nama_produk : old('nama_produk') }}" class="form-input" placeholder="Contoh: Jersey Home Real Madrid 2024" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                Harga (Rp) <span class="required-mark">*</span>
                            </label>
                            <input type="number" name="harga" id="harga" value="{{ isset($editing) ? $editing->harga : old('harga') }}" class="form-input" placeholder="150000" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                Stok <span class="required-mark">*</span>
                            </label>
                            <input type="number" name="stok" id="stok" value="{{ isset($editing) ? $editing->stok : old('stok') }}" class="form-input" placeholder="50" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Status Produk</label>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="checkbox-input" {{ isset($editing) ? ($editing->is_active ? 'checked' : '') : 'checked' }}>
                                <label for="is_active" class="checkbox-label">Aktif / Tampilkan</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Gambar & Deskripsi Section -->
                <div class="form-section">
                    <div class="section-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        Gambar & Deskripsi
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Gambar Produk</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="file-upload-input">
                                <label for="gambar" class="file-upload-button">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="17 8 12 3 7 8"></polyline>
                                        <line x1="12" y1="3" x2="12" y2="15"></line>
                                    </svg>
                                    Pilih Gambar
                                </label>
                            </div>
                            @if(isset($editing) && $editing->gambar)
                            <div class="image-preview">
                                <img src="{{ $editing->image_url }}" alt="Preview" class="preview-image">
                            </div>
                            @endif
                        </div>
                        
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-input" rows="3" placeholder="Deskripsi detail produk...">{{ isset($editing) ? $editing->deskripsi : old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    @if(isset($editing))
                        <a href="#confirm-edit" class="btn-admin primary equal">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Simpan Perubahan
                        </a>
                        <a href="{{ route('admin.products') }}" class="btn-admin equal">Batal</a>
                    @else
                        <button type="submit" class="btn-admin primary equal">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Tambah Produk
                        </button>
                    @endif
                </div>
            </form>
        </div>
        
        @if(isset($editing))
        <div id="confirm-edit" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-title">Simpan Perubahan?</div>
                <div class="modal-sub">Perubahan produk akan diterapkan dan langsung terlihat di halaman toko.</div>
                <div class="modal-actions">
                    <button type="submit" form="productForm" class="btn-admin primary equal">Ya, Simpan</button>
                    <a href="#" class="btn-admin equal">Tidak</a>
                </div>
            </div>
        </div>
        @endif
        
        <div class="admin-card table-card">
            <div class="table-header">
                <div>
                    <div class="table-title">Daftar Produk</div>
                    <div class="table-subtitle">Total {{ count($items) }} produk</div>
                </div>
            </div>
            
            @if(count($items) > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i)
                    <tr>
                        <td>
                            <div class="product-name">
                                @if($i->gambar)
                                <img src="{{ $i->image_url }}" alt="{{ $i->nama_produk }}" class="product-image-thumb">
                                @else
                                <div class="product-image-thumb" style="background:#f0f0f0;display:flex;align-items:center;justify-content:center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <div style="font-weight:600">{{ $i->nama_produk }}</div>
                                    @if(!$i->is_active)
                                    <span style="font-size:0.75rem;color:#999;font-style:italic">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="category-badge">{{ $i->kategori->nama_kategori ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="price-display">Rp {{ number_format($i->harga,0,',','.') }}</span>
                        </td>
                        <td>
                            <span class="stock-badge {{ $i->stok > 20 ? 'high' : ($i->stok > 5 ? 'medium' : 'low') }}">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                                {{ $i->stok }} unit
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.products.edit', $i->produk_id) }}" class="btn-admin btn-edit equal">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <a href="#confirm-delete-{{ $i->produk_id }}" class="btn-admin btn-delete equal">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Hapus
                                </a>
                            </div>
                            <div id="confirm-delete-{{ $i->produk_id }}" class="modal-overlay">
                                <div class="modal-card">
                                    <div class="modal-title">Hapus Produk?</div>
                                    <div class="modal-sub">Produk "{{ $i->nama_produk }}" akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</div>
                                    <div class="modal-actions">
                                        <form action="{{ route('admin.products.destroy', $i->produk_id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-admin btn-delete equal">Ya, Hapus</button>
                                        </form>
                                        <a href="#" class="btn-admin equal">Tidak</a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7h-9"></path>
                    <path d="M14 17H5"></path>
                    <circle cx="17" cy="17" r="3"></circle>
                    <circle cx="7" cy="7" r="3"></circle>
                </svg>
                <p style="font-size:1.1rem;font-weight:600;margin-bottom:0.5rem">Belum Ada Produk</p>
                <p style="font-size:0.9rem">Tambahkan produk pertama Anda menggunakan form di atas</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var kategori = document.getElementById('kategori_id');
    var fields = ['nama_produk', 'harga', 'stok', 'is_active', 'gambar', 'deskripsi'];
    
    function setDisabled() {
        var disabled = !kategori.value;
        fields.forEach(function(id) {
            var el = document.getElementById(id);
            if (el) {
                el.disabled = disabled;
                if (disabled) {
                    el.style.opacity = '0.5';
                } else {
                    el.style.opacity = '1';
                }
            }
        });
    }
    
    setDisabled();
    kategori.addEventListener('change', setDisabled);
    
    // File upload preview
    var fileInput = document.getElementById('gambar');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || 'Pilih Gambar';
            var label = document.querySelector('label[for="gambar"]');
            if (e.target.files[0]) {
                label.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>' + fileName;
                label.style.color = '#00b894';
                label.style.borderColor = '#00b894';
            }
        });
    }
});
</script>
@endsection