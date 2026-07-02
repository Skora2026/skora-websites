@extends('layouts.admin')
@section('title', 'Admin || Manage Progress Counters')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Manage Progress Counters')

<div class="container pt-3 card">
    <div class="projects-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold">All Progress Counters</h6>
            <button class="btn cu" onclick="showAddModal()">
                <i class="fas fa-plus"></i> Add Counter
            </button>
        </div>

        <div class="table-responsive">
            <table id="countersTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Number</th>
                        <th>Title</th>
                        <th>Sort Order</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div id="countersLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addCounterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Counter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCounterForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Number (e.g. 19+)</label>
                        <input type="text" class="form-control" name="number" placeholder="Enter year in numbers" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Title(Name)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" placeholder="Order By"  value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editCounterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Counter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCounterForm">
                @csrf
                <input type="hidden" name="id" id="editCounterId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Number</label>
                        <input type="text" class="form-control" name="number" id="editNumber" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="editTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" id="editSort">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Active</label>
                        <select class="form-control" name="active" id="editActive">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    let countersTable = null;
    let csrfToken = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function() {
        initializeDataTable();
        loadCounters();
        $('#addCounterForm').submit(addCounter);
        $('#editCounterForm').submit(updateCounter);
    });

    function initializeDataTable() {
        countersTable = $('#countersTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: false,
            pageLength: 10,
            columns: [
                { data: 'id' },
                { data: 'number' },
                { data: 'title' },
                { data: 'sort_order' },
                { 
                    data: 'active',
                    render: data => data ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        return `
                            <button class="btn btn-sm btn-primary" onclick="editCounter(${data.id})"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="deleteCounter(${data.id})"><i class="bi bi-trash"></i></button>
                        `;
                    }
                }
            ]
        });
    }

    function loadCounters() {
        $('#countersLoading').show();
        $.ajax({
            url: "{{ route('admin.progress-counters.get') }}",
            type: "GET",
            success: function(res) {
                $('#countersLoading').hide();
                if (res.success && res.data.length > 0) {
                    countersTable.clear().rows.add(res.data).draw();
                } else {
                    countersTable.clear().draw();
                }
            },
            error: function() {
                $('#countersLoading').hide();
                showAlert('Failed to load counters', 'error');
            }
        });
    }

    function showAddModal() {
        $('#addCounterForm')[0].reset();
        $('#addCounterModal').modal('show');
    }

    function addCounter(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: "{{ route('admin.progress-counters.save') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res.success) {
                    $('#addCounterModal').modal('hide');
                    loadCounters();
                    showAlert(res.message, 'success');
                } else {
                    showAlert(res.message || 'Failed to add counter', 'error');
                }
            },
            error: function(xhr) {
                let message = xhr.responseJSON?.message || 'Failed to add counter';
                showAlert(message, 'error');
            },
            complete: function() {
                btn.prop('disabled', false).text('Save');
            }
        });
    }

    function editCounter(id) {
        $.ajax({
            url: "{{ route('admin.progress-counters.get') }}",
            success: function(res) {
                let counter = res.data.find(c => c.id == id);
                if (counter) {
                    $('#editCounterId').val(counter.id);
                    $('#editNumber').val(counter.number);
                    $('#editTitle').val(counter.title);
                    $('#editSort').val(counter.sort_order);
                    $('#editActive').val(counter.active ? 1 : 0);
                    $('#editCounterModal').modal('show');
                } else {
                    showAlert('Counter not found', 'error');
                }
            },
            error: function() {
                showAlert('Failed to load counter details', 'error');
            }
        });
    }

    function updateCounter(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = $('#editCounterId').val();
        let btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).text('Updating...');

        $.ajax({
            url: `/update-progress-counter/${id}`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res.success) {
                    $('#editCounterModal').modal('hide');
                    loadCounters();
                    showAlert(res.message, 'success');
                } else {
                    showAlert(res.message || 'Failed to update counter', 'error');
                }
            },
            error: function(xhr) {
                let message = xhr.responseJSON?.message || 'Failed to update counter';
                showAlert(message, 'error');
            },
            complete: function() {
                btn.prop('disabled', false).text('Update');
            }
        });
    }

    function deleteCounter(id) {
        // Create a custom confirmation dialog
        let confirmBox = document.createElement("div");
        confirmBox.className = "notification-sidebar show";
        confirmBox.innerHTML = `
            <div class="notify-box notify-warning">
                <i class="text-warning fas fa-exclamation-triangle notify-icon"></i>
                <span class="notify-text">Are you sure you want to delete this counter? This action cannot be undone.</span>
                <div class="mt-3">
                    <button class="btn btn-sm btn-danger me-2" id="confirmDelete">Delete</button>
                    <button class="btn btn-sm btn-secondary" id="cancelDelete">Cancel</button>
                </div>
                <div class="timer-bar"></div>
            </div>
        `;
        
        document.body.appendChild(confirmBox);
        
        // Timer bar for confirmation dialog (longer timeout)
        setTimeout(() => {
            confirmBox.querySelector(".timer-bar").style.width = "0%";
        }, 50);
        
        // Handle delete confirmation
        confirmBox.querySelector("#confirmDelete").onclick = function() {
            $.ajax({
                url: `/delete-progress-counter/${id}`,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(res) {
                    if (res.success) {
                        loadCounters();
                        showAlert(res.message, 'success');
                    } else {
                        showAlert(res.message || 'Failed to delete counter', 'error');
                    }
                },
                error: function() {
                    showAlert('Failed to delete counter', 'error');
                }
            });
            confirmBox.remove();
        };
        
        // Handle cancel
        confirmBox.querySelector("#cancelDelete").onclick = function() {
            confirmBox.remove();
        };
        
        // Auto remove after 10 seconds for confirmation dialog
        setTimeout(() => {
            if (document.body.contains(confirmBox)) {
                confirmBox.remove();
            }
        }, 10000);
    }


</script>



@endpush