@extends('layouts.admin')
@section('title', 'Medical Supplies Inventory')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('page', 'Medical Supplies Inventory')

@section('content')
<div class="container pt-3 card">
    <div class="supplies-section">
        <div class="row g-3 mb-3">
            <div class="col-6 col-lg-3">
                <div class="card stats-card h-100"><div class="card-body p-3 text-center">
                    <h6 class="mb-1 opacity-75">Total Items</h6><h3 class="mb-0" id="statTotal">0</h3>
                </div></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stats-card h-100"><div class="card-body p-3 text-center">
                    <h6 class="mb-1 opacity-75">Low Stock</h6><h3 class="mb-0 text-danger" id="statLow">0</h3>
                </div></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stats-card h-100"><div class="card-body p-3 text-center">
                    <h6 class="mb-1 opacity-75">In Maintenance</h6><h3 class="mb-0 text-warning" id="statMaint">0</h3>
                </div></div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stats-card h-100"><div class="card-body p-3 text-center">
                    <h6 class="mb-1 opacity-75">Oxygen Cylinders</h6><h3 class="mb-0 text-success" id="statOxy">0</h3>
                </div></div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="search-container w-50">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="form-control form-control-sm"
                       placeholder="Search supplies...">
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn cu" onclick="showAddModal()">
                    <i class="fas fa-plus"></i> Add Item
                </button>
                <button class="btn btn-danger" id="deleteSelected" style="display: none;">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="suppliesTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%"><input type="checkbox" id="selectAll"></th>
                        <th width="5%">ID</th>
                        <th width="26%">Item</th>
                        <th width="14%">Category</th>
                        <th width="10%">Qty</th>
                        <th width="9%">Min</th>
                        <th width="13%">Stock</th>
                        <th width="9%">Status</th>
                        <th width="9%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div id="suppliesLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- Add/Edit Supply Modal -->
<div class="modal fade" id="supplyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplyModalTitle">Add Supply Item</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="supplyForm">
                <div class="modal-body">
                    <input type="hidden" id="supplyId">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Item Name *</label>
                            <input type="text" class="form-control" id="supplyName" placeholder="e.g. Oxygen Cylinder — 10L (B-type)" required>
                            <div class="invalid-feedback">Please enter the item name</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <select class="form-control" id="supplyCategory" required>
                                @foreach(\App\Http\Controllers\MedicalSupplyController::CATEGORIES as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" class="form-control" id="supplyUnit" placeholder="e.g. cylinders, pcs, packs" value="units">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity *</label>
                            <input type="number" class="form-control" id="supplyQty" value="0" min="0" required>
                            <div class="invalid-feedback">Quantity must be 0 or more</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Low-stock Threshold</label>
                            <input type="number" class="form-control" id="supplyMin" value="0" min="0">
                            <div class="form-text">Alert when quantity falls to this level or below.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-control" id="supplyStatus" required>
                                <option value="available">Available</option>
                                <option value="maintenance">In Maintenance</option>
                                <option value="retired">Retired</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" id="supplyNotes" rows="2" placeholder="Supplier, cylinder size, last refill date, serial numbers..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Item</button>
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
        let suppliesTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('#suppliesTable')) {
                $('#suppliesTable').DataTable().destroy();
            }

            initializeDataTable();
            loadSupplies();

            $('#searchInput').on('keyup', function () {
                if (suppliesTable) suppliesTable.search(this.value).draw();
            });

            $('#supplyForm').submit(saveSupply);

            $(document).on('click', '.delete-supply', function () {
                deleteSupply($(this).data('id'));
            });

            $('#selectAll').on('click', function () {
                $('tbody input.select-checkbox:visible').prop('checked', this.checked);
                toggleDeleteSelected();
            });

            $(document).on('change', '.select-checkbox', toggleDeleteSelected);
            $('#deleteSelected').on('click', deleteSelected);
        });

        function initializeDataTable() {
            suppliesTable = $('#suppliesTable').DataTable({
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
                    info: "Showing _START_ to _END_ of _TOTAL_ items",
                    infoEmpty: "No supply items yet",
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
                        data: 'name',
                        render: function (data, type, row) {
                            return data + (row.notes
                                ? '<div class="text-muted small">' + row.notes.substring(0, 60) + (row.notes.length > 60 ? '...' : '') + '</div>'
                                : '');
                        }
                    },
                    { data: 'category' },
                    { data: 'quantity' },
                    { data: 'min_quantity' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            if (parseInt(row.quantity) <= parseInt(row.min_quantity)) {
                                return '<span class="badge bg-danger">Low Stock</span>';
                            }
                            return '<span class="badge bg-success">OK</span>';
                        }
                    },
                    {
                        data: 'status',
                        render: function (data) {
                            const map = {
                                available:   '<span class="badge bg-success">Available</span>',
                                maintenance: '<span class="badge bg-warning text-dark">Maintenance</span>',
                                retired:     '<span class="badge bg-secondary">Retired</span>'
                            };
                            return map[data] || data;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-success" onclick="editSupply(${row.id})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-supply" data-id="${row.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>`;
                        }
                    }
                ]
            });
        }

        function loadSupplies() {
            $('#suppliesLoading').show();
            $.ajax({
                url: "{{ route('admin.medical-supplies.get') }}",
                type: "GET",
                success: function (response) {
                    $('#suppliesLoading').hide();
                    if (response.success && response.data.length > 0) {
                        suppliesTable.clear().rows.add(response.data).draw();
                    } else {
                        suppliesTable.clear().draw();
                    }
                    updateStats(response.data || []);
                },
                error: function () {
                    $('#suppliesLoading').hide();
                    showAlert('Error loading supplies!', 'error');
                }
            });
        }

        function updateStats(items) {
            let low = 0, maint = 0, oxy = 0;
            items.forEach(function (item) {
                if (parseInt(item.quantity) <= parseInt(item.min_quantity)) low++;
                if (item.status === 'maintenance') maint++;
                if (item.category === 'Oxygen Cylinder') oxy += parseInt(item.quantity);
            });
            $('#statTotal').text(items.length);
            $('#statLow').text(low);
            $('#statMaint').text(maint);
            $('#statOxy').text(oxy);
        }

        function showAddModal() {
            $('#supplyForm')[0].reset();
            $('#supplyId').val('');
            $('#supplyUnit').val('units');
            $('#supplyQty').val(0);
            $('#supplyMin').val(0);
            $('#supplyStatus').val('available');
            $('#supplyModalTitle').text('Add Supply Item');
            $('#supplyForm .is-invalid').removeClass('is-invalid');
            $('#supplyModal').modal('show');
        }

        function editSupply(id) {
            const data = suppliesTable.rows().data().toArray();
            const item = data.find(s => s.id == id);
            if (!item) { showAlert('Item not found in current view!', 'error'); return; }

            $('#supplyId').val(item.id);
            $('#supplyName').val(item.name);
            $('#supplyCategory').val(item.category);
            if ($('#supplyCategory').val() !== item.category) {
                $('#supplyCategory').append('<option value="' + item.category + '" selected>' + item.category + '</option>');
            }
            $('#supplyUnit').val(item.unit);
            $('#supplyQty').val(item.quantity);
            $('#supplyMin').val(item.min_quantity);
            $('#supplyStatus').val(item.status);
            $('#supplyNotes').val(item.notes);
            $('#supplyModalTitle').text('Edit Supply Item');
            $('#supplyForm .is-invalid').removeClass('is-invalid');
            $('#supplyModal').modal('show');
        }

        function saveSupply(e) {
            e.preventDefault();
            const id = $('#supplyId').val();
            const formData = new FormData();
            formData.append('name', $('#supplyName').val());
            formData.append('category', $('#supplyCategory').val());
            formData.append('unit', $('#supplyUnit').val());
            formData.append('quantity', $('#supplyQty').val());
            formData.append('min_quantity', $('#supplyMin').val());
            formData.append('status', $('#supplyStatus').val());
            formData.append('notes', $('#supplyNotes').val());

            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

            const url = id
                ? '{{ route("admin.medical-supplies.update", ":id") }}'.replace(':id', id)
                : "{{ route('admin.medical-supplies.store') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function (response) {
                    if (response.success) {
                        $('#supplyModal').modal('hide');
                        loadSupplies();
                        showAlert(response.message || 'Item saved successfully!', 'success');
                    } else {
                        showAlert(response.message || 'Error saving item!', 'error');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        showAlert('Please check the form — quantity must be a number ≥ 0.', 'error');
                    } else {
                        showAlert('Error saving item!', 'error');
                    }
                },
                complete: function () {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function deleteSupply(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the supply item permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.medical-supplies.destroy", ":id") }}'.replace(':id', id),
                        type: "DELETE",
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        success: function (response) {
                            if (response.success) {
                                loadSupplies();
                                showAlert(response.message || 'Item deleted successfully!', 'success');
                            } else {
                                showAlert(response.message || 'Error deleting item!', 'error');
                            }
                        },
                        error: function () {
                            showAlert('Error deleting item!', 'error');
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
                text: `You are about to delete ${selectedIds.length} items!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.medical-supplies.bulk-delete') }}",
                        type: "POST",
                        data: { ids: selectedIds, _token: csrfToken },
                        success: function (response) {
                            if (response.success) {
                                loadSupplies();
                                showAlert(response.message || 'Items deleted successfully!', 'success');
                            } else {
                                showAlert(response.message || 'Error deleting items!', 'error');
                            }
                        },
                        error: function () {
                            showAlert('Error deleting selected items!', 'error');
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
