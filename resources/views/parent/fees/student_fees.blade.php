@extends('layout.app')
@section('content')

<div class="content container-fluid">
    <div class="page-header">
        <h3 class="page-title">Fees - {{ $student->name }} {{ $student->last_name }}</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Fees Summary</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Class</th>
                            <td>{{ $student->class->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Paid Amount</th>
                            <td>Rp {{ number_format($paidAmount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Remaining Amount</th>
                            <td>Rp {{ number_format($remainingAmount, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-table mt-4">
        <div class="card-body">
            <h5 class="card-title">Payment History</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Payment Type</th>
                            <th>Remark</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feeLogs as $i => $fee)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>Rp {{ number_format($fee->paid_amount, 0, ',', '.') }}</td>
                            <td>{{ $fee->payment_type }}</td>
                            <td>{{ $fee->remark }}</td>
                            <td>{{ \Carbon\Carbon::parse($fee->created_at)->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No payment yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
