@extends('layouts.master')

@section('title', 'Kelola Keuangan - CM SPORT')

@section('content')
<style>
/* Finance KPI Cards */
.finance-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.kpi-card {
    background: linear-gradient(135deg, #E8001D 0%, #C20015 100%);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: 0 10px 30px rgba(232, 0, 29, 0.2);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.kpi-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    transition: all 0.5s ease;
}

.kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(232, 0, 29, 0.35);
}

.kpi-card:hover::before {
    top: -30%;
    right: -30%;
}

.kpi-sales {
    background: linear-gradient(135deg, #E8001D 0%, #C20015 100%);
}

.kpi-expense {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.kpi-profit {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.kpi-icon {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
    position: relative;
    z-index: 1;
}

.kpi-icon svg {
    color: white;
    width: 28px;
    height: 28px;
}

.kpi-content {
    flex: 1;
    position: relative;
    z-index: 1;
}

.kpi-label {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.kpi-value {
    color: white;
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1.2;
}

/* Finance Form Card */
.finance-form-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
}

.form-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 1.5rem 0;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0f0f0;
}

.form-title svg {
    color: #E8001D;
}

.finance-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-label svg {
    color: #E8001D;
}

.form-input {
    padding: 0.875rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f8fafc;
    font-family: inherit;
    width: 100%;
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: #E8001D;
    background: white;
    box-shadow: 0 0 0 3px rgba(232, 0, 29, 0.1);
}

.form-input::placeholder {
    color: #a0aec0;
}

.btn-submit {
    background: linear-gradient(135deg, #E8001D 0%, #C20015 100%);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(232, 0, 29, 0.3);
    margin-top: 0.5rem;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(232, 0, 29, 0.4);
}

.btn-submit:active {
    transform: translateY(0);
}

/* Finance Table Card */
.finance-table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid #f0f0f0;
}

.table-header {
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-bottom: 2px solid #e2e8f0;
}

.table-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.table-title svg {
    color: #E8001D;
}

.table-responsive {
    overflow-x: auto;
}

.finance-table {
    width: 100%;
    border-collapse: collapse;
}

.finance-table thead {
    background: #f8fafc;
}

.finance-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.8rem;
    font-weight: 700;
    color: #4a5568;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
}

.finance-table th.text-right {
    text-align: right;
}

.finance-table tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f0f0f0;
}

.finance-table tbody tr:hover {
    background: #f8fafc;
}

.finance-table td {
    padding: 1.25rem 1.5rem;
    font-size: 0.95rem;
    color: #2d3748;
}

.finance-table td.text-right {
    text-align: right;
}

.date-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    background: #edf2f7;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
}

.category-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.category-badge.penjualan {
    background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
    color: #166534;
}

.category-badge.pengeluaran {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #7c2d12;
}

.amount {
    font-weight: 700;
    font-size: 1rem;
}

.amount.penjualan {
    color: #16a34a;
}

.amount.pengeluaran {
    color: #dc2626;
}

/* Page Header */
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.admin-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
}

.admin-subtitle {
    font-size: 0.9rem;
    color: #666;
    margin-top: 0.3rem;
}

.btn-export {
    background: white;
    border: 2px solid #e2e8f0;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    color: #4a5568;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-export:hover {
    border-color: #E8001D;
    color: #E8001D;
    background: #f7fafc;
}

/* Responsive Design */
@media (max-width: 768px) {
    .finance-kpi-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .finance-form-card,
    .finance-table-card {
        border-radius: 12px;
        padding: 1.5rem;
    }
    
    .table-header {
        padding: 1rem 1.5rem;
    }
    
    .finance-table th,
    .finance-table td {
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
    }
    
    .kpi-value {
        font-size: 1.5rem;
    }
    
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .admin-title {
        font-size: 1.5rem;
    }
}
</style>

<div class="admin-layout">
    @include('admin.partials.sidebar')
    
    <div class="admin-content">
        <div class="admin-header">
            <div>
                <div class="admin-title">Kelola Keuangan</div>
                <p class="admin-subtitle">Pantau pendapatan, pengeluaran, dan laba bisnis Anda</p>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="finance-kpi-grid">
            <div class="kpi-card kpi-sales">
                <div class="kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <div class="kpi-content">
                    <div class="kpi-label">Penjualan Bulan Ini</div>
                    <div class="kpi-value">Rp {{ number_format($ringkasan['penjualan_bulan_ini'] ?? 1731789, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="kpi-card kpi-expense">
                <div class="kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        <polyline points="17 6 23 6 23 12"></polyline>
                    </svg>
                </div>
                <div class="kpi-content">
                    <div class="kpi-label">Pengeluaran Bulan Ini</div>
                    <div class="kpi-value">Rp {{ number_format($ringkasan['pengeluaran_bulan_ini'] ?? 71000, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="kpi-card kpi-profit">
                <div class="kpi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                </div>
                <div class="kpi-content">
                    <div class="kpi-label">Laba Bulan Ini</div>
                    <div class="kpi-value">Rp {{ number_format($ringkasan['laba_bulan_ini'] ?? 1660789, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Form Tambah Pengeluaran -->
        <div class="finance-form-card">
            <h3 class="form-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                Tambah Pengeluaran Baru
            </h3>
            <form action="{{ route('admin.expenses.store') }}" method="POST" class="finance-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Tanggal
                        </label>
                        <input type="date" name="date" value="{{ now()->toDateString() }}" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            Jumlah (Rp)
                        </label>
                        <input type="number" name="amount" min="0" step="1" class="form-input" placeholder="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Keterangan
                    </label>
                    <input type="text" name="description" class="form-input" placeholder="Masukkan keterangan pengeluaran" required>
                </div>
                <button type="submit" class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Simpan Pengeluaran
                </button>
            </form>
        </div>

        <!-- Tabel Riwayat Transaksi -->
        <div class="finance-table-card">
            <div class="table-header">
                <h3 class="table-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                    Riwayat Transaksi
                </h3>
            </div>
            <div class="table-responsive">
                <table class="finance-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items ?? [] as $item)
                        <tr>
                            <td><span class="date-badge">{{ $item['tanggal'] }}</span></td>
                            <td><span class="category-badge {{ strtolower($item['kategori']) }}">{{ $item['kategori'] }}</span></td>
                            <td>{{ $item['keterangan'] }}</td>
                            <td class="text-right">
                                <span class="amount {{ strtolower($item['kategori']) }}">
                                    {{ $item['kategori'] == 'Pengeluaran' ? '-' : '+' }} Rp {{ number_format($item['jumlah'], 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: #a0aec0;">
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection