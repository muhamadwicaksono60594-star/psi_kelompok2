<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <!-- Header Section -->
        <div class="card-header bg-white border-0 py-4 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="flex-grow-1">
                    <h4 class="mb-2 fw-bold text-dark">
                        <i class="bi bi-table me-2 text-primary"></i>
                        {{ $title }}
                    </h4>
                    <p class="mb-0 text-muted small">
                        Total {{ count($data) }} data peserta terdaftar
                    </p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-light text-dark border px-3 py-2">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ date('d M Y') }}
                    </span>
                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">NO</th>
                            <th>NAMA</th>
                            <th>ASAL INSTANSI</th>
                            <th>JURUSAN</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td class="text-center fw-semibold text-dark">
                                {{ $loop->iteration }}
                            </td>

                            <td class="fw-semibold text-dark">
                                {{ $item->nama ?? '-' }}
                            </td>

                            <td class="text-secondary">
                                {{ $item->asal_instansi ?? '-' }}
                            </td>

                            <td class="text-dark">
                                {{ $item->jurusan ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="card-footer bg-light border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center text-muted small">
                    <i class="bi bi-info-circle me-2"></i>
                    <span>Data terakhir diperbarui: {{ date('d M Y, H:i') }} WIB</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Base Styling */
:root {
    --primary-color: #4F46E5;
    --primary-hover: #4338CA;
    --text-dark: #1F2937;
    --text-secondary: #6B7280;
    --border-color: #E5E7EB;
    --bg-light: #F9FAFB;
    --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: var(--text-dark);
    background-color: #F3F4F6;
}

/* Card Styling */
.card {
    transition: box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
}

/* Header Styling */
.card-header {
    border-bottom: 1px solid var(--border-color);
}

.card-header h4 {
    font-size: 1.25rem;
    font-weight: 700;
}

.text-primary {
    color: var(--primary-color) !important;
}

/* Table Styling */
.table {
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.875rem;
}

.table thead {
    background-color: #2563EB;
    border-bottom: none;
}

.table thead th {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: white;
    padding: 1rem 0.75rem;
    border: none;
    white-space: nowrap;
}

.table tbody td {
    padding: 0.875rem 0.75rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
    font-size: 0.875rem;
}

.table tbody tr {
    transition: background-color 0.2s ease;
    background-color: white;
}

.table tbody tr:nth-child(even) {
    background-color: #F9FAFB;
}

.table tbody tr:hover {
    background-color: #EFF6FF;
}

.table tbody tr:last-child td {
    border-bottom: none;
}

/* Badge Styling */
.badge {
    font-weight: 500;
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem;
    display: inline-block;
    min-width: 80px;
}

.badge-jenis {
    background-color: #DBEAFE;
    color: #1E40AF;
}

.badge-warning {
    background-color: #FEF3C7;
    color: #92400E;
}

.badge-success {
    background-color: #D1FAE5;
    color: #065F46;
}

.badge-danger {
    background-color: #FEE2E2;
    color: #991B1B;
}

.badge-secondary {
    background-color: #E5E7EB;
    color: #374151;
}

/* Text Utilities */
.fw-semibold {
    font-weight: 600;
}

.text-dark {
    color: var(--text-dark) !important;
}

.text-secondary {
    color: var(--text-secondary) !important;
}

.text-muted {
    color: #9CA3AF !important;
}

/* Button Styling */
.btn-primary {
    background-color: var(--primary-color);
    border: none;
    padding: 0.625rem 1.5rem;
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.btn-primary:active {
    transform: translateY(0);
}

.bg-light {
    background-color: var(--bg-light) !important;
}

/* Footer Styling */
.card-footer {
    border-top: 1px solid var(--border-color);
}

/* Icons */
.bi {
    vertical-align: middle;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card-header h4 {
        font-size: 1.125rem;
    }

    .table thead th,
    .table tbody td {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }

    .avatar-circle {
        width: 36px;
        height: 36px;
        font-size: 1rem;
    }

    .badge-number {
        width: 28px;
        height: 28px;
        font-size: 0.8125rem;
    }

    .btn-primary {
        width: 100%;
        justify-content: center;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
    }
}

@media (max-width: 576px) {
    .table {
        font-size: 0.8125rem;
    }

    .card-header,
    .card-footer {
        padding: 1rem !important;
    }
}

/* Scrollbar Styling */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: var(--bg-light);
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #D1D5DB;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #9CA3AF;
}

/* Smooth Animations */
* {
    transition-property: background-color, border-color, color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

/* Print Styles */
@media print {
    .btn,
    .card-footer {
        display: none;
    }

    .card {
        box-shadow: none !important;
    }
}
</style>