@extends('layouts.admin')
@section('title', 'Admin || Manage Consultations')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Manage Consultations')

<div class="container pt-3 card">
    <div class="consults-section">
        <div class="table-responsive">
            <table id="consultsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Name</th>
                        <th>Phone</th>
                        <th>Interests</th>
                        <th>Budget</th>
                        <th width="10%">Created At</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="consultsLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- View Consult Modal -->
<div class="modal fade" id="viewConsultModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consult Details</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body" id="consultDetailsBody">
                <!-- Dynamic content loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let consultsTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $(document).ready(function() {
            initializeDataTable();
            loadConsults();
        });

        function initializeDataTable() {
            consultsTable = $('#consultsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: false,
                pageLength: 50,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search consultations..."
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'phone' },
                    { data: 'interests' },
                    { data: 'budget' },
                    
                    { 
                        data: 'created_at',
                        render: function(data) {
                            return new Date(data).toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' });
                        }
                    },
                    { 
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info" onclick="viewConsult(${row.id})" title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-consult" data-id="${row.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        // Load Consults
        function loadConsults() {
            $('#consultsLoading').show();
            
            $.ajax({
                url: "{{ route('admin.consults.get') }}",
                type: "GET",
                success: function(response) {
                    $('#consultsLoading').hide();
                    
                    if (response.success && response.data.length > 0) {
                        consultsTable.clear();
                        consultsTable.rows.add(response.data);
                        consultsTable.draw();
                    } else {
                        consultsTable.clear();
                        consultsTable.draw();
                    }
                },
                error: function() {
                    $('#consultsLoading').hide();
                    showAlert('Error loading consultations!', 'error');
                }
            });
        }

        function viewConsult(id) {
            $.ajax({
                url: `/admin/consults/${id}`, // Hits show route
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const consult = response.data;
                        let interestsHtml = consult.interests && consult.interests.length > 0 
                            ? `<ul class="list-unstyled">${consult.interests.map(i => `<li>${i}</li>`).join('')}</ul>`
                            : '<p class="text-muted">No interests specified</p>';
                        let detailsHtml = `
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> ${consult.name}</p>
                                    <p><strong>Phone:</strong> ${consult.phone}</p>
                                    <p><strong>Budget:</strong> ${consult.budget}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Created:</strong> ${new Date(consult.created_at).toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}</p>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <strong>Interests:</strong>
                                ${interestsHtml}
                            </div>
                        `;
                        $('#consultDetailsBody').html(detailsHtml);
                        $('#viewConsultModal').modal('show');
                    }
                },
                error: function() {
                    showAlert('Error loading consult details!', 'error');
                }
            });
        }

        // Delete Consult
        $(document).on('click', '.delete-consult', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the consultation permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/consults/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (response.success) {
                                loadConsults();
                                showAlert(response.message, 'success');
                            } else {
                                showAlert(response.message || 'Delete failed!', 'error');
                            }
                        },
                        error: function() {
                            showAlert('Error deleting consultation!', 'error');
                        }
                    });
                }
            });
        });
    </script>
   
@endpush