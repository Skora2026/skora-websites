@extends('layouts.admin')
@section('title', 'Manage Camps')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('page', 'Manage Health Camps')

@section('content')
<div class="container pt-3 card">
    <div class="camps-section">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="search-container w-50">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search camps...">
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn cu" onclick="showAddModal()">
                    <i class="fas fa-plus"></i> Add Camp
                </button>
                <button class="btn btn-danger" id="deleteSelected" style="display: none;">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="campsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%"><input type="checkbox" id="selectAll"></th>
                        <th width="5%">ID</th>
                        <th width="25%">Title</th>
                        <th width="20%">Location</th>
                        <th width="12%">Date</th>
                        <th width="12%">Time</th>
                        <th width="8%">Status</th>
                        <th width="13%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div id="campsLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- Add/Edit Camp Modal -->
<div class="modal fade" id="campModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="campModalTitle">Add New Camp</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="campForm">
                <div class="modal-body">
                    <input type="hidden" id="campId">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Camp Title *</label>
                            <input type="text" class="form-control" id="campTitle" placeholder="e.g. Free Neuro Check-up Camp" required>
                            <div class="invalid-feedback">Please enter camp title</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="campDescription" rows="3" placeholder="Services offered, eligibility, what to bring..."></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" id="campLocation" placeholder="Venue / address">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Camp Date</label>
                            <input type="date" class="form-control" id="campDate">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Camp Time</label>
                            <input type="text" class="form-control" id="campTime" placeholder="e.g. 10:00 AM - 2:00 PM">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="campSort" value="0" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" id="campActive">
                                <option value="1">Active (Visible)</option>
                                <option value="0">Inactive (Hidden)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Camp</button>
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
        let campsTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('#campsTable')) {
                $('#campsTable').DataTable().destroy();
            }

            initializeDataTable();
            loadCamps();

            $('#searchInput').on('keyup', function () {
                if (campsTable) campsTable.search(this.value).draw();
            });

            $('#campForm').submit(saveCamp);

            $(document).on('click', '.delete-camp', function () {
                deleteCamp($(this).data('id'));
            });

            $('#selectAll').on('click', function () {
                $('tbody input.select-checkbox:visible').prop('checked', this.checked);
                toggleDeleteSelected();
            });

            $(document).on('change', '.select-checkbox', toggleDeleteSelected);
            $('#deleteSelected').on('click', deleteSelected);
        });

        function initializeDataTable() {
            campsTable = $('#campsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                pageLength: 10,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-6"i><"col-6 text-end"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ camps",
                    infoEmpty: "No camps available",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: "text-center select-checkbox",
                        render: function (data, type, row) {
                            return '<input type="checkbox" class="select-checkbox" value="' + row.id + '">';
                        }
                    },
                    { data: 'id' },
                    {
                        data: 'title',
                        render: function (data, type, row) {
                            return data + (row.description
                                ? '<div class="text-muted small">' + row.description.substring(0, 60) + (row.description.length > 60 ? '...' : '') + '</div>'
                                : '');
                        }
                    },
                    { data: 'location' },
                    { data: 'camp_date' },
                    { data: 'camp_time' },
                    {
                        data: 'is_active',
                        render: function (data) {
                            return data
                                ? '<span class="badge bg-success">Active</span>'
                                : '<span class="badge bg-secondary">Inactive</span>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-success" onclick="editCamp(${row.id})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-camp" data-id="${row.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });
        }

        function loadCamps() {
            $('#campsLoading').show();
            $.ajax({
                url: "{{ route('admin.camps.get') }}",
                type: "GET",
                success: function (response) {
                    $('#campsLoading').hide();
                    if (response.success && response.data.length > 0) {
                        campsTable.clear().rows.add(response.data).draw();
                    } else {
                        campsTable.clear().draw();
                    }
                },
                error: function () {
                    $('#campsLoading').hide();
                    showAlert('Error loading camps!', 'error');
                }
            });
        }

        function showAddModal() {
            $('#campForm')[0].reset();
            $('#campId').val('');
            $('#campSort').val($('#campsTable tbody tr').length);
            $('#campActive').val('1');
            $('#campModalTitle').text('Add New Camp');
            $('#campForm .is-invalid').removeClass('is-invalid');
            $('#campModal').modal('show');
        }

        function editCamp(id) {
            const data = campsTable.rows().data().toArray();
            const camp = data.find(c => c.id == id);
            if (!camp) { showAlert('Camp not found in current view!', 'error'); return; }

            $('#campId').val(camp.id);
            $('#campTitle').val(camp.title);
            $('#campDescription').val(camp.description);
            $('#campLocation').val(camp.location);
            $('#campDate').val(camp.camp_date);
            $('#campTime').val(camp.camp_time);
            $('#campSort').val(camp.sort_order);
            $('#campActive').val(camp.is_active ? '1' : '0');
            $('#campModalTitle').text('Edit Camp');
            $('#campForm .is-invalid').removeClass('is-invalid');
            $('#campModal').modal('show');
        }

        function saveCamp(e) {
            e.preventDefault();
            const id = $('#campId').val();
            const formData = new FormData(this);
            formData.append('title', $('#campTitle').val());
            formData.append('description', $('#campDescription').val());
            formData.append('location', $('#campLocation').val());
            formData.append('camp_date', $('#campDate').val());
            formData.append('camp_time', $('#campTime').val());
            formData.append('sort_order', $('#campSort').val());
            formData.append('is_active', $('#campActive').val() === '1' ? 1 : 0);

            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

            const url = id
                ? '{{ route("admin.camps.update", ":id") }}'.replace(':id', id)
                : "{{ route('admin.camps.store') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function (response) {
                    if (response.success) {
                        $('#campModal').modal('hide');
                        loadCamps();
                        showAlert(response.message || 'Camp saved successfully!', 'success');
                    } else {
                        showAlert(response.message || 'Error saving camp!', 'error');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#campForm .is-invalid').removeClass('is-invalid');
                        for (const field in errors) {
                            $(`#campForm #campTitle, #campForm #campDescription`).removeClass('is-invalid');
                            $(`#${field === 'title' ? 'campTitle' : 'campDescription'}`).addClass('is-invalid');
                        }
                    } else {
                        showAlert('Error saving camp!', 'error');
                    }
                },
                complete: function () {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function deleteCamp(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the camp permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.camps.destroy", ":id") }}'.replace(':id', id),
                        type: "DELETE",
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        success: function (response) {
                            if (response.success) {
                                loadCamps();
                                showAlert(response.message || 'Camp deleted successfully!', 'success');
                            } else {
                                showAlert(response.message || 'Error deleting camp!', 'error');
                            }
                        },
                        error: function () {
                            showAlert('Error deleting camp!', 'error');
                        }
                    });
                }
            });
        }

        function toggleDeleteSelected() {
            const checkedCount = $('tbody input.select-checkbox:checked').length;
            $('#deleteSelected').toggle(checkedCount > 0);
            $('#selectAll').prop('checked', checkedCount === $('tbody input.select-checkbox:visible').length);
        }

        function deleteSelected() {
            const selectedIds = $('tbody input.select-checkbox:checked').map(function () {
                return $(this).val();
            }).get();
            if (selectedIds.length === 0) return;

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${selectedIds.length} camps!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.camps.bulk-delete') }}",
                        type: "POST",
                        data: { ids: selectedIds, _token: csrfToken },
                        success: function (response) {
                            if (response.success) {
                                loadCamps();
                                showAlert(response.message || 'Camps deleted successfully!', 'success');
                            } else {
                                showAlert(response.message || 'Error deleting camps!', 'error');
                            }
                        },
                        error: function () {
                            showAlert('Error deleting selected camps!', 'error');
                        }
                    });
                }
            });
        }

        function showAlert(message, type = 'success') {
            Swal.fire({
                icon: type,
                title: type.charAt(0).toUpperCase() + type.slice(1),
                text: message,
                timer: 3000,
                showConfirmButton: false
            });
        }
    </script>
@endpush
