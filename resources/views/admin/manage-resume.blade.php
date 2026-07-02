@extends('layouts.admin')
@section('title', 'Admin || Manage Resumes')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Manage Resumes')

<div class="container pt-3 card">
    <div class="projects-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold">All Submitted Resumes</h6>
        </div>

        <div class="table-responsive">
            <table id="resumesTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Position</th>
                        <th>Resume</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="12%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div id="resumesLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="editResumeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Resume Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editResumeForm">
                <input type="hidden" name="id" id="editResumeId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-control" name="status" id="editResumeStatus" required>
                            <option value="pending">Pending</option>
                            <option value="reviewed">Reviewed</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
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
    let resumesTable = null;
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $(document).ready(function() {
        initializeDataTable();
        loadResumes();
        $('#editResumeForm').submit(updateResumeStatus);
    });

    function initializeDataTable() {
        resumesTable = $('#resumesTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: false,
            pageLength: 15,
            language: { searchPlaceholder: "Search resumes..." },
            columns: [
                { data: 'id' },
                { data: 'full_name' },
                { data: 'email' },
                { data: 'phone' },
                { data: 'position' },
                {
                    data: 'resume_path',
                    render: function(data) {
                        if (data) {
                            return `<a href="/storage/${data}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-text"></i> View
                                    </a>`;
                        }
                        return '<span class="text-muted">No file</span>';
                    }
                },
                {
                    data: 'status',
                    render: function(data) {
                        let badge = 'bg-warning';
                        if (data === 'reviewed') badge = 'bg-success';
                        if (data === 'rejected') badge = 'bg-danger';
                        return `<span class="badge ${badge} text-capitalize">${data}</span>`;
                    }
                },
                { data: 'created_at', render: data => new Date(data).toLocaleDateString() },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary" onclick="editResume(${row.id}, '${row.status}')" title="Update Status">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteResume(${row.id})" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        `;
                    }
                }
            ]
        });
    }

    function loadResumes() {
        $('#resumesLoading').show();
        $.ajax({
            url: "{{ route('admin.resumes.get') }}",
            type: "GET",
            success: function(response) {
                $('#resumesLoading').hide();
                if (response.success && response.data.length > 0) {
                    resumesTable.clear().rows.add(response.data).draw();
                } else {
                    resumesTable.clear().draw();
                    resumesTable.row.add({
                        id: '', full_name: '<div class="text-center text-muted">No resumes submitted yet</div>',
                        email: '', phone: '', position: '', resume_path: '', status: '', created_at: ''
                    }).draw();
                }
            },
            error: function() {
                $('#resumesLoading').hide();
                Swal.fire('Error', 'Failed to load resumes', 'error');
            }
        });
    }

    function editResume(id, currentStatus) {
        $('#editResumeId').val(id);
        $('#editResumeStatus').val(currentStatus);
        $('#editResumeModal').modal('show');
    }

    function updateResumeStatus(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = $('#editResumeId').val();
        const btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).html('Updating...');

        $.ajax({
            url: `/update-resume/${id}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res.success) {
                    $('#editResumeModal').modal('hide');
                    loadResumes();
                    Swal.fire('Success', res.message, 'success');
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to update status', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html('Update Status');
            }
        });
    }

    function deleteResume(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This resume will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/delete-resume/${id}`,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function(res) {
                        if (res.success) {
                            loadResumes();
                            Swal.fire('Deleted!', res.message, 'success');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to delete resume', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush