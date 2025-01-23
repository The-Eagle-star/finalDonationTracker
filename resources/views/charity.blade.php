@extends('main.main')

@section('content')
@include('includes.navbar')

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Charities</h1>
    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            
            <!-- Button to open modal -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#addCharityModal">
                Add New Charity
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <!-- Charity Table -->
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Logo</th>
                            <th>Short Description</th>
                            <th>Donation Goal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($charities as $charity)
                            <tr>
                                <td>{{ $charity->title }}</td>
                                <td><img src="{{ asset('storage/' . $charity->logo) }}" alt="{{ $charity->title }}" width="50" height="50"></td>
                                <td>{{ Str::limit($charity->short_description, 50) }}</td>
                                <td>{{ number_format($charity->total_donations, 2) }}</td>
                                <td class="text-center">
                                    <!-- Edit button opens edit modal -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editCharityModal{{ $charity->id }}">
                                        Edit
                                    </button>

                                    <!-- Delete button -->
                                    <form action="{{ route('charities.destroy', $charity->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this charity?')">
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

<!-- Modal for Adding New Charity -->
<div class="modal fade" id="addCharityModal" tabindex="-1" role="dialog" aria-labelledby="addCharityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCharityModalLabel">Add New Charity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('charities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Title Input -->
                    <div class="form-group">
                        <label for="title">Charity Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <!-- Logo Input -->
                    <div class="form-group">
                        <label for="logo">Charity Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*" required>
                    </div>

                    <!-- Short Description Input -->
                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="3" required></textarea>
                    </div>

                    <!-- Total Donations Input -->
                    <div class="form-group">
                        <label for="total_donations">Donation Goal (EURO)</label>
                        <input type="number" class="form-control" id="total_donations" name="total_donations" value="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Charity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Editing Charity -->
@foreach ($charities as $charity)
<div class="modal fade" id="editCharityModal{{ $charity->id }}" tabindex="-1" role="dialog" aria-labelledby="editCharityModalLabel{{ $charity->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCharityModalLabel{{ $charity->id }}">Edit Charity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('charities.update', $charity->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Title Input -->
                    <div class="form-group">
                        <label for="title">Charity Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $charity->title) }}" required>
                    </div>

                    <!-- Logo Input -->
                    <div class="form-group">
                        <label for="logo">Charity Logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <img src="{{ asset('storage/' . $charity->logo) }}" alt="{{ $charity->title }}" width="50" height="50" class="mt-2">
                    </div>

                    <!-- Short Description Input -->
                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ old('short_description', $charity->short_description) }}</textarea>
                    </div>

                    <!-- Total Donations Input -->
                    <div class="form-group">
                        <label for="total_donations">Donation Goal (EURO)</label>
                        <input type="number" class="form-control" id="total_donations" name="total_donations" value="{{ old('total_donations', $charity->total_donations) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Charity</button>
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
