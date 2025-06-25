@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">{{ $header_title }}</h4>

    <div class="card">
        <div class="card-header">
            Assigned Subjects
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-borderless table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Subject Name</th>
                            <th>Type</th> <!-- Ganti Status menjadi Type -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $item)
                        <tr>
                            <td>{{ $item->subject->name ?? '-' }}</td>
                            <td>{{ ucfirst($item->subject->type ?? '-') }}</td> <!-- Ambil type dari subject -->
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">No subjects assigned</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
