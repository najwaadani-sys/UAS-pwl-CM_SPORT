@extends('layouts.master')

@section('title', 'Kelola Kategori - CM SPORT')
@push('styles')
<style>
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);display:none;align-items:center;justify-content:center;z-index:1000;backdrop-filter:blur(4px)}
.modal-overlay:target{display:flex}
.modal-card{background:#fff;border-radius:16px;padding:2rem;box-shadow:0 20px 60px rgba(0,0,0,.3);width:min(92vw,480px);animation:modalSlideUp 0.3s ease}
@keyframes modalSlideUp{from{transform:translateY(30px);opacity:0}to{transform:translateY(0);opacity:1}}
.modal-title{font-weight:900;font-size:1.3rem;margin-bottom:.5rem;color:#000}
.modal-sub{color:#666;margin-bottom:1.5rem;line-height:1.6}
.modal-actions{display:flex;gap:.8rem;justify-content:flex-end}
.btn-admin.equal{min-width:120px;text-align:center}

/* Enhanced Form Card */
.form-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border: 2px solid #e0e0e0;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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
    margin-bottom: 1.5rem;
}

.form-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, rgba(232, 0, 29, 0.1) 0%, rgba(232, 0, 29, 0.05) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #E8001D;
}

.form-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #000;
}

.form-subtitle {
    font-size: 0.85rem;
    color: #666;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-input {
    width: 100%;
    padding: 0.9rem 1.2rem;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #fff;
}

.form-input:focus {
    outline: none;
    border-color: #E8001D;
    box-shadow: 0 0 0 3px rgba(232, 0, 29, 0.1);
}

.form-actions {
    display: flex;
    gap: 0.8rem;
    margin-top: 1.5rem;
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

.category-name {
    font-weight: 600;
    color: #000;
}

.category-slug {
    font-family: 'Courier New', monospace;
    background: #f8f9fa;
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-size: 0.85rem;
    color: #666;
}

.product-count {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #E8001D 0%, #C20015 100%);
    color: #fff;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.product-count svg {
    width: 16px;
    height: 16px;
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
    display: inline-block;
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
@media (max-width: 768px) {
    .form-card {
        padding: 1.5rem;
    }
    
    .table-card {
        padding: 1rem;
        overflow-x: auto;
    }
    
    .admin-table {
        min-width: 600px;
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

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')
    <div class="admin-content">
        <div class="admin-header">
            <div>
                <div class="admin-title">Kelola Kategori</div>
                <p class="admin-subtitle">Atur dan organisir kategori produk Anda</p>
            </div>
        </div>
        
        <div class="admin-card form-card" style="position: relative;">
            <div class="form-header">
                <div class="form-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </div>
                <div>
                    <div class="form-title">{{ isset($editing) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</div>
                    <div class="form-subtitle">{{ isset($editing) ? 'Perbarui informasi kategori' : 'Buat kategori produk baru' }}</div>
                </div>
            </div>
            
            <form id="categoryForm" action="{{ isset($editing) ? route('admin.categories.update', $editing->kategori_id) : route('admin.categories.store') }}" method="POST">
                @csrf
                @if(isset($editing))
                @method('PUT')
                @endif
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ isset($editing) ? $editing->nama_kategori : old('nama_kategori') }}" class="form-input" placeholder="Contoh: Sepatu Olahraga" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi" value="{{ isset($editing) ? $editing->deskripsi : old('deskripsi') }}" class="form-input" placeholder="Deskripsi singkat kategori">
                    </div>
                </div>
                
                <div class="form-actions">
                    @if(isset($editing))
                        <a href="#confirm-edit" class="btn-admin primary equal">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:0.3rem">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Simpan Perubahan
                        </a>
                        <a href="{{ route('admin.categories') }}" class="btn-admin equal">Batal</a>
                    @else
                        <button type="submit" class="btn-admin primary equal">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:0.3rem">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Tambah Kategori
                        </button>
                    @endif
                </div>
            </form>
        </div>
        
        @if(isset($editing))
        <div id="confirm-edit" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-title">Simpan Perubahan?</div>
                <div class="modal-sub">Perubahan kategori akan diterapkan dan mempengaruhi semua produk terkait.</div>
                <div class="modal-actions">
                    <button type="submit" form="categoryForm" class="btn-admin primary equal">Ya, Simpan</button>
                    <a href="#" class="btn-admin equal">Tidak</a>
                </div>
            </div>
        </div>
        @endif
        
        <div class="admin-card table-card">
            <div class="table-header">
                <div>
                    <div class="table-title">Daftar Kategori</div>
                    <div class="table-subtitle">Total {{ count($items) }} kategori</div>
                </div>
            </div>
            
            @if(count($items) > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Produk Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i)
                    <tr>
                        <td>
                            <span class="category-name">{{ $i->nama_kategori }}</span>
                            @if($i->deskripsi)
                                <div style="font-size:0.8rem;color:#999;margin-top:0.2rem">{{ $i->deskripsi }}</div>
                            @endif
                        </td>
                        <td><span class="category-slug">{{ $i->slug }}</span></td>
                        <td>
                            <span class="product-count">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 7h-9"></path>
                                    <path d="M14 17H5"></path>
                                    <circle cx="17" cy="17" r="3"></circle>
                                    <circle cx="7" cy="7" r="3"></circle>
                                </svg>
                                {{ $i->aktif_count }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.categories.edit', $i->kategori_id) }}" class="btn-admin btn-edit equal">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:0.3rem">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <a href="#confirm-delete-{{ $i->kategori_id }}" class="btn-admin btn-delete equal">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;margin-right:0.3rem">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Hapus
                                </a>
                            </div>
                            <div id="confirm-delete-{{ $i->kategori_id }}" class="modal-overlay">
                                <div class="modal-card">
                                    <div class="modal-title">Hapus Kategori?</div>
                                    <div class="modal-sub">Kategori "{{ $i->nama_kategori }}" akan dihapus. Tindakan ini tidak dapat dibatalkan.</div>
                                    <div class="modal-actions">
                                        <form id="deleteForm_{{ $i->kategori_id }}" action="{{ route('admin.categories.destroy', $i->kategori_id) }}" method="POST" style="display:inline">
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
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <p style="font-size:1.1rem;font-weight:600;margin-bottom:0.5rem">Belum Ada Kategori</p>
                <p style="font-size:0.9rem">Tambahkan kategori pertama Anda menggunakan form di atas</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection