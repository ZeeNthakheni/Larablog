@extends('layouts.admin')

@section('content')
    <!-- Section - Bootstrap Brain Component -->
    <!-- Breadcrumb -->
    <section class="py-3 py-md-4 py-xl-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="h4">eCommerce Dashboard</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 fs-7">
                            <li class="breadcrumb-item"><a class="link-primary text-decoration-none" href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Section - Bootstrap Brain Component -->
    <!-- Card 1 - Bootstrap Brain Component -->
    <section class="pb-3 pb-md-4 pb-xl-5 bg-light">
        <div class="container">
            <div class="row gy-3 gy-md-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card widget-card border-light shadow-sm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title widget-card-title mb-3">Sales</h5>
                                    <h4 class="card-subtitle text-body-secondary m-0">${{ number_format($sales, 2) }}</h4>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div class="lh-1 text-white bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-truck fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card widget-card border-light shadow-sm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title widget-card-title mb-3">Earnings</h5>
                                    <h4 class="card-subtitle text-body-secondary m-0">${{ number_format($earnings, 2) }}</h4>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div class="lh-1 text-white bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card widget-card border-light shadow-sm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title widget-card-title mb-3">Visitors</h5>
                                    <h4 class="card-subtitle text-body-secondary m-0">{{ $visitors }}</h4>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div class="lh-1 text-white bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card widget-card border-light shadow-sm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title widget-card-title mb-3">Orders</h5>
                                    <h4 class="card-subtitle text-body-secondary m-0">{{ $orders }}</h4>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div class="lh-1 text-white bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section - Bootstrap Brain Component -->
    <section class="pb-3 pb-md-4 pb-xl-5 bg-light">
        <div class="container">
            <div class="row gy-3 gy-md-4">
                <div class="col-12 col-lg-6 col-xl-5">
                    <!-- Timeline 8 - Bootstrap Brain Component -->
                    <div class="card widget-card bsb-timeline-8 border-light shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title widget-card-title mb-3">Recent Transactions</h5>
                            <ul class="timeline">
                                @foreach($recent_transactions as $transaction)
                                <li class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="timeline-meta">
                                            <span>{{ $transaction->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="timeline-content timeline-indicator">
                                            <h6 class="mb-1">New order from {{ $transaction->customer->name }}</h6>
                                            <span class="text-secondary fs-7">Order #{{ $transaction->id }}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-7">
                    <!-- Table 1 - Bootstrap Brain Component -->
                    <div class="card widget-card border-light shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title widget-card-title mb-4">Monthly Transactions</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
                                    <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($monthly_transactions as $transaction)
                                        <tr>
                                            <td>
                                                <h6 class="mb-1">#{{ $transaction->id }}</h6>
                                            </td>
                                            <td>
                                                <h6 class="mb-1">{{ $transaction->customer->name }}</h6>
                                            </td>
                                            <td>${{ number_format($transaction->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge rounded-pill
                                                    @if($transaction->status == 'pending') bg-warning
                                                    @elseif($transaction->status == 'processing') bg-info
                                                    @elseif($transaction->status == 'completed') bg-success
                                                    @elseif($transaction->status == 'shipped') bg-primary
                                                    @elseif($transaction->status == 'cancelled') bg-danger
                                                    @endif">{{ $transaction->status }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
