@extends('layouts.admin')
@section('title', 'Admin || Management Managers')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Management Managers')

<div class="container pt-3 card">
    <div class="managers-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold">Management Managers</h6>
            <button class="btn cu" onclick="showAddModal()">
                <i class="fas fa-plus"></i> Add Managers
            </button>
        </div>

        <div class="table-responsive">
            <table id="managersTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Name</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="managersLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- Add Managers Modal -->
<div class="modal fade" id="addAmenityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Managers</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="addAmenityForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Managers Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Managers Name" required>
                        <div class="invalid-feedback">Please enter amenity name</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Managers</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Managers Modal -->
<div class="modal fade" id="editAmenityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Managers</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="editAmenityForm">
                <input type="hidden" name="id" id="editAmenityId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" id="editAmenityName" required>
                        <div class="invalid-feedback">Please enter amenity name</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Managers</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let managersTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(document).ready(function() {
            initializeDataTable();
            loadmanagers();
            $('#addAmenityForm').submit(addAmenity);
            $('#editAmenityForm').submit(updateAmenity);
        });

        function initializeDataTable() {
            managersTable = $('#managersTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: false,
                pageLength: 100,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search managers..."
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { 
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-success" onclick="editAmenity(${row.id})" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-manager" data-id="${row.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        // Load Managers
        function loadmanagers() {
            $('#managersLoading').show();
            
            $.ajax({
                url: "{{ route('admin.managers.get') }}",
                type: "GET",
                success: function(response) {
                    $('#managersLoading').hide();
                    
                    if (response.success && response.data.length > 0) {
                        managersTable.clear();
                        managersTable.rows.add(response.data);
                        managersTable.draw();
                    } else {
                        managersTable.clear();
                        managersTable.draw();
                        managersTable.row.add({
                            'id': '',
                            'name': '<div class="text-center text-muted">No managers found</div>',
                            'null': ''
                        }).draw();
                    }
                },
                error: function() {
                    $('#managersLoading').hide();
                    showAlert('Error loading managers!', 'error');
                }
            });
        }

        function showAddModal() {
            $('#addAmenityForm')[0].reset();
            $('#addAmenityForm .invalid-feedback').hide();
            $('#addAmenityModal').modal('show');
        }

        function addAmenity(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            
            $.ajax({
                url: "{{ route('admin.managers.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        $('#addAmenityModal').modal('hide');
                        loadmanagers();
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#addAmenityForm .invalid-feedback').hide();
                        for (const field in errors) {
                            $(`#addAmenityForm [name="${field}"]`).addClass('is-invalid')
                                .next('.invalid-feedback').text(errors[field][0]).show();
                        }
                    } else {
                        showAlert('Error saving amenity!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function editAmenity(id) {
            $.ajax({
                url: "{{ route('admin.managers.get') }}",
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const amenity = response.data.find(p => p.id == id);
                        if (amenity) {
                            $('#editAmenityId').val(amenity.id);
                            $('#editAmenityName').val(amenity.name);
                            $('#editAmenityForm .invalid-feedback').hide();
                            $('#editAmenityModal').modal('show');
                        }
                    }
                }
            });
        }

        // Update Managers
        function updateAmenity(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $('#editAmenityId').val();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
            
            $.ajax({
                url: `/update-managers/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        $('#editAmenityModal').modal('hide');
                        loadmanagers();
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#editAmenityForm .invalid-feedback').hide();
                        for (const field in errors) {
                            $(`#editAmenityForm [name="${field}"]`).addClass('is-invalid')
                                .next('.invalid-feedback').text(errors[field][0]).show();
                        }
                    } else {
                        showAlert('Error updating amenity!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }
        $(document).on('click', '.delete-manager', function() {
                if (confirm('Are you sure you want to delete this manager?')) {
                    const id = $(this).data('id');
                    $.ajax({
                       url: "/delete-managers/" + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function() {
                            showAlert('Deleting project...', 'info');
                        },
                        success: function(response) {
                            loadmanagers();
                            showAlert(response.message);
                        },
                        error: function(xhr) {
                            showAlert('Error deleting project!', 'danger');
                        }
                    });
                }
            });

    </script>
@endpush