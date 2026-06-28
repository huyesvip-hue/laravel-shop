@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    {{-- STATS --}}
    <div class="row g-4">

        @php
            $stats = [
                [
                    'title' => 'Đơn hàng',
                    'value' => $totalOrders ?? 0,
                    'icon' => 'bi-cart',
                    'color' => '#3b82f6'
                ],
                [
                    'title' => 'Doanh thu',
                    'value' => number_format($revenue ?? 0) . 'đ',
                    'icon' => 'bi-cash-stack',
                    'color' => '#10b981'
                ],
                [
                    'title' => 'Khách hàng',
                    'value' => $totalUsers ?? 0,
                    'icon' => 'bi-people',
                    'color' => '#f59e0b'
                ],
                [
                    'title' => 'Sản phẩm',
                    'value' => $totalProducts ?? 0,
                    'icon' => 'bi-box',
                    'color' => '#ef4444'
                ],
            ];
        @endphp

        @foreach($stats as $item)

            <div class="col-lg-3 col-md-6">

                <div class="dashboard-card">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="dashboard-title">
                                {{ $item['title'] }}
                            </p>

                            <h2 class="dashboard-value">
                                {{ $item['value'] }}
                            </h2>

                        </div>

                        <div class="dashboard-icon"
                            style="background: {{ $item['color'] }}20;
                                    color: {{ $item['color'] }};">

                            <i class="bi {{ $item['icon'] }}"></i>

                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

    {{-- CHART --}}
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    Thống kê doanh thu
                </h5>
            </div>

            <canvas id="chart" height="100"></canvas>

        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div class="card bg-white text-dark shadow-sm border-0 rounded-4 mt-4">

        <div class="card-body">

            <h5 class="fw-bold mb-4">
                Đơn hàng gần đây
            </h5>

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle">

                    <thead class="text-info">
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($orders as $order)

                            <tr>

                                <td>{{ $order->id }}</td>

                                <td>{{ $order->user->name ?? 'N/A' }}</td>

                                <td>
                                    {{ number_format($order->total) }}đ
                                </td>

                                <td>
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2">Chờ xác nhận</span>
                                    @elseif($order->status == 'processing')
                                        <span class="badge bg-info text-white px-3 py-2">Đang chuẩn bị</span>
                                    @elseif($order->status == 'shipping')
                                        <span class="badge bg-primary px-3 py-2">Đang giao</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success px-3 py-2">Hoàn thành</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge bg-danger px-3 py-2">Đã hủy</span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center">
                                    Không có dữ liệu
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

{{-- CHART --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chart');

new Chart(ctx, {
    type: 'bar',

    data: {
        labels: @json($chartLabels),

        datasets: [{
            label: 'Doanh thu',
            data: @json($chartData),
            backgroundColor: '#0d6efd',
            borderRadius: 10
        }]
    },

    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

</script>
<style>

/* ===== STATS CARD ===== */

.dashboard-card{

    background: linear-gradient(
        145deg,
        #0f172a,
        #111827
    );

    border: 1px solid rgba(59,130,246,0.18);

    border-radius: 22px;

    padding: 25px;

    transition: all 0.3s ease;

    box-shadow:
        0 6px 25px rgba(0,0,0,0.35),
        inset 0 1px 1px rgba(255,255,255,0.03);
}

.dashboard-card:hover{

    transform: translateY(-6px);

    border-color: rgba(56,189,248,0.55);

    box-shadow:
        0 0 25px rgba(56,189,248,0.12),
        0 15px 35px rgba(0,0,0,0.45);
}

/* ===== TITLE ===== */

.dashboard-title{

    color: #94a3b8;

    font-size: 14px;

    font-weight: 500;

    letter-spacing: 0.5px;

    margin-bottom: 10px;
}

/* ===== VALUE ===== */

.dashboard-value{

    color: #ffffff;

    font-size: 34px;

    font-weight: 700;

    margin: 0;

    text-shadow:
        0 0 10px rgba(255,255,255,0.08);
}

/* ===== ICON ===== */

.dashboard-icon{

    width: 68px;

    height: 68px;

    border-radius: 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

    border: 1px solid rgba(255,255,255,0.05);

    backdrop-filter: blur(10px);

    box-shadow:
        inset 0 1px 1px rgba(255,255,255,0.05);
}

/* ===== MAIN CARD ===== */

.card{

    background: linear-gradient(
        145deg,
        #0f172a,
        #111827
    ) !important;

    border: 1px solid rgba(59,130,246,0.12) !important;

    border-radius: 22px !important;

    box-shadow:
        0 6px 25px rgba(0,0,0,0.35);
}

/* ===== TEXT ===== */

.card h5,
.card th,
.card td{

    color: #f8fafc;
}

/* ===== TABLE ===== */

.table{

    color: #f8fafc;
}

.table thead{

    background: rgba(59,130,246,0.08);
}

.table tbody tr{

    border-color: rgba(255,255,255,0.05);
}

.table tbody tr:hover{

    background: rgba(59,130,246,0.06);
}

/* ===== BADGE ===== */

.badge{

    padding: 7px 12px;

    border-radius: 10px;
}

</style>
@endsection