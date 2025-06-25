@extends('layout.app')
@section('content')

<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title">Collect Fees - {{ $student->name }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fees.index') }}">Fees Collection</a></li>
                        <li class="breadcrumb-item active">Collect Fees</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

    <!-- Add Payment Button -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Student: {{ $student->name }} ({{ $student->class->name ?? '-' }})</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFeesModal">
            <i class="fa fa-plus"></i> Add Payment
        </button>
    </div>

    <!-- Payment History Table -->
    <div class="card card-table comman-shadow">
        <div class="card-body">
            <h5 class="mb-3">Payment History</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Amount</th>
                            <th>Payment Type</th>
                            <th>Remark</th>
                            <th>Collected By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($feeLogs as $i => $fee)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>Rp {{ number_format($fee->paid_amount, 0, ',', '.') }}</td>
                                <td>{{ $fee->payment_type }}</td>
                                <td>{{ $fee->remark }}</td>
                                <td>{{ $fee->creator->name ?? 'System' }}</td>
                                <td>{{ $fee->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No payment history yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addFeesModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.fees.store') }}" method="POST" class="modal-content">
      @csrf
      <input type="hidden" name="student_id" value="{{ $student->id }}">
      <input type="hidden" name="class_id" value="{{ $student->class_id }}">
      <input type="hidden" name="total_amount" value="{{ $totalAmount }}">

      <div class="modal-header">
        <h5 class="modal-title">Add Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <table class="table table-sm table-bordered mb-3">
            <tr>
                <th>Class</th>
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
        </table>

        <div class="mb-3">
            <label class="form-label">Paid Amount</label>
            <input type="number" name="paid_amount" class="form-control" required min="1" max="{{ $remainingAmount }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Payment Type</label>
            <select name="payment_type" class="form-select" required>
                <option value="">-- Select --</option>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Remark</label>
            <textarea name="remark" class="form-control" rows="2"></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit Payment</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#addFeesModal form');
    const paidInput = form.querySelector('input[name="paid_amount"]');
    const maxPaid = {{ $remainingAmount }};

    form.addEventListener('submit', function (e) {
        const paidValue = parseFloat(paidInput.value);
        
        if (isNaN(paidValue) || paidValue <= 0) {
            alert('Paid amount must be greater than 0.');
            e.preventDefault();
            return;
        }

        if (paidValue > maxPaid) {
            alert('Paid amount cannot be more than remaining amount (Rp {{ number_format($remainingAmount, 0, ',', '.') }}).');
            e.preventDefault();
            return;
        }
    });
});
</script>
@endsection
