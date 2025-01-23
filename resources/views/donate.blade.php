@extends('main.main')

@section('content')
@include('includes.navbar')

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Donations</h1>
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            
            <!-- Button to open modal -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#addDonationModal">
                Add New Donation
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <!-- Donations Table -->
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Charity</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($donations as $donation)
                            <tr>
                                <td>{{ $donation->charity ? $donation->charity->title : 'N/A' }}</td>
                                <td>{{ $donation->category ? $donation->category->name : 'N/A' }}</td>
                                <td>{{ number_format($donation->amount, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($donation->date)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($donation->notes, 50) }}</td>
                                <td class="text-center">
                                    <!-- Edit button -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDonationModal{{ $donation->id }}">
                                        Edit
                                    </button>
                    
                                    <!-- Delete button -->
                                    <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this donation?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding New Donation -->
<div class="modal fade" id="addDonationModal" tabindex="-1" role="dialog" aria-labelledby="addDonationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDonationModalLabel">Add New Donation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('donations.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Charity Selection -->
                    <div class="form-group">
                        <label for="charity_id">Charity</label>
                        <select class="form-control" id="charity_id" name="charity_id" required>
                            <option value="">Select Charity</option>
                            @foreach($charities as $charity)
                                <option value="{{ $charity->id }}">{{ $charity->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Selection -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount Input -->
                    <div class="form-group">
                        <label for="amount">Amount (Euro)</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>

                    <!-- Date Input -->
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <!-- Notes Input -->
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Donation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Editing Donation -->
@foreach ($donations as $donation)
<div class="modal fade" id="editDonationModal{{ $donation->id }}" tabindex="-1" role="dialog" aria-labelledby="editDonationModalLabel{{ $donation->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDonationModalLabel{{ $donation->id }}">Edit Donation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('donations.update', $donation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Charity Selection -->
                    <div class="form-group">
                        <label for="charity_id">Charity</label>
                        <select class="form-control" id="charity_id" name="charity_id" required>
                            <option value="">Select Charity</option>
                            @foreach($charities as $charity)
                                <option value="{{ $charity->id }}" {{ $donation->charity_id == $charity->id ? 'selected' : '' }}>
                                    {{ $charity->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Selection -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $donation->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount Input -->
                    <div class="form-group">
                        <label for="amount">Amount (Euro)</label>
                        <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', $donation->amount) }}" required>
                    </div>

                    <!-- Date Input -->
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $donation->date) }}" required>
                    </div>

                    <!-- Notes Input -->
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $donation->notes) }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Donation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush

@endsection
