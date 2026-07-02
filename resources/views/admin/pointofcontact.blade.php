@extends('layouts.admin')
@section('title', 'Admin || Management Point of Contact')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Point of Contact')

<div class="container pt-3 card">
    <div class="pointofcontact-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold">Management Point of Contact</h6>
            <button class="btn cu" onclick="showAddModal()">
                <i class="fas fa-plus"></i> Add Point of Contact
            </button>
        </div>

        <div class="table-responsive">
            <table id="pointofcontactTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Name</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div id="pointofcontactLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- Add Point of Contact Modal -->
<div class="modal fade" id="addPointModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Point of Contact</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="addPointForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Point of Contact Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Point of Contact Name" required>
                        <div class="invalid-feedback">Please enter name</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Point of Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Point of Contact Modal -->
<div class="modal fade" id="editPointModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Point of Contact</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="editPointForm">
                <input type="hidden" name="id" id="editPointId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" id="editPointName" required>
                        <div class="invalid-feedback">Please enter name</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Point of Contact</button>
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
        let pointofcontactTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(document).ready(function() {
            initializeDataTable();
            loadPointOfContacts();
            $('#addPointForm').submit(addPointOfContact);
            $('#editPointForm').submit(updatePointOfContact);
        });

        function initializeDataTable() {
            pointofcontactTable = $('#pointofcontactTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: false,
                pageLength: 100,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search point of contact..."
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
                                    <button class="btn btn-sm btn-success" onclick="editPointOfContact(${row.id})" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-point" data-id="${row.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        function loadPointOfContacts() {
            $('#pointofcontactLoading').show();
            
            $.ajax({
                url: "{{ route('admin.pointofcontact.get') }}",
                type: "GET",
                success: function(response) {
                    $('#pointofcontactLoading').hide();
                    
                    if (response.success && response.data.length > 0) {
                        pointofcontactTable.clear();
                        pointofcontactTable.rows.add(response.data);
                        pointofcontactTable.draw();
                    } else {
                        pointofcontactTable.clear().draw();
                        pointofcontactTable.row.add({
                            id: '',
                            name: '<div class="text-center text-muted">No point of contact found</div>',
                            null: ''
                        }).draw();
                    }
                },
                error: function() {
                    $('#pointofcontactLoading').hide();
                    showAlert('Error loading point of contacts!', 'error');
                }
            });
        }

        function showAddModal() {
            $('#addPointForm')[0].reset();
            $('#addPointForm .invalid-feedback').hide();
            $('#addPointModal').modal('show');
        }

        function addPointOfContact(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            
            $.ajax({
                url: "{{ route('admin.pointofcontact.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(response) {
                    if (response.success) {
                        $('#addPointModal').modal('hide');
                        loadPointOfContacts();
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#addPointForm .invalid-feedback').hide();
                        for (const field in errors) {
                            $(`#addPointForm [name="${field}"]`).addClass('is-invalid')
                                .next('.invalid-feedback').text(errors[field][0]).show();
                        }
                    } else {
                        showAlert('Error saving point of contact!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function editPointOfContact(id) {
            $.ajax({
                url: "{{ route('admin.pointofcontact.get') }}",
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const poc = response.data.find(p => p.id == id);
                        if (poc) {
                            $('#editPointId').val(poc.id);
                            $('#editPointName').val(poc.name);
                            $('#editPointForm .invalid-feedback').hide();
                            $('#editPointModal').modal('show');
                        }
                    }
                }
            });
        }

        function updatePointOfContact(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $('#editPointId').val();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
            
            $.ajax({
                url: `/update-pointofcontact/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(response) {
                    if (response.success) {
                        $('#editPointModal').modal('hide');
                        loadPointOfContacts();
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#editPointForm .invalid-feedback').hide();
                        for (const field in errors) {
                            $(`#editPointForm [name="${field}"]`).addClass('is-invalid')
                                .next('.invalid-feedback').text(errors[field][0]).show();
                        }
                    } else {
                        showAlert('Error updating point of contact!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        $(document).on('click', '.delete-point', function() {
            if (confirm('Are you sure you want to delete this point of contact?')) {
                const id = $(this).data('id');
                $.ajax({
                    url: "/delete-pointofcontact/" + id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function(response) {
                        loadPointOfContacts();
                        showAlert(response.message || 'Point of contact deleted successfully.', 'success');
                    },
                    error: function() {
                        showAlert('Error deleting point of contact!', 'error');
                    }
                });
            }
        });


    </script>
@endpush