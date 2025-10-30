@extends('layout')

@section('content')
    <h2 class="fw-bold text-dark mb-4">DASHBOARD</h2>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card total p-4">
                <h5>Total Topping</h5>
                <h1>{{ $totalTopping }}</h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card in p-4">
                <h5>Topping In</h5>
                <h1>{{ $totalIn }}</h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card out p-4">
                <h5>Topping Out</h5>
                <h1>{{ $totalOut }}</h1>
            </div>
        </div>
    </div>

    <h4 class="fw-bold mt-5">GRAFIK</h4>
    <div class="chart-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Grafik Barang Masuk & Barang Keluar</h6>
            <form method="GET" action="{{ route('dashboard') }}">
                <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </form>
        </div>
        <canvas id="chart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [
                    {
                        label: 'Topping In',
                        data: @json($inData),
                        borderColor: '#a91818',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Topping Out',
                        data: @json($outData),
                        borderColor: '#4b0b0b',
                        borderWidth: 2,
                        fill: false
                    }
                ]
            }
        });
    </script>
@endsection
