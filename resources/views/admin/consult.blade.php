@extends('layouts.admin')
@section('title', 'Consult form Dynamically')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
 @section('page', 'Management Consult Form')

<div class="container  pt-3 card">
    <div class="interests-section ">
            <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold">  Management Interest</h6>
            <button class="btn cu" data-bs-toggle="modal" data-bs-target="#addInterestModal">
                <i class="fas fa-plus"></i> Add Interest
            </button>
        </div>

        <div class="table-responsive">
            <table id="interestsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th>Name</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated via JavaScript -->
                </tbody>
            </table>
        </div>
        <div id="interestsLoading" class="spinner-container" style="display: none;">
            <div class="spinner"></div>
        </div>
    </div>

</div>
<div class="container pt-3 card mt-5">
    <!-- Budgets Section -->
    <div class="budgets-section mt-2">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold"> Management Budget</h6>
            <button class="btn cu" data-bs-toggle="modal" data-bs-target="#addBudgetModal">
              <i class="fas fa-plus"></i> Add Budget
            </button>
        </div>

        <div class="table-responsive">
            <table id="budgetsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th>Budget Name</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated via JavaScript -->
                </tbody>
            </table>
        </div>
        <div id="budgetsLoading" class="spinner-container mt-3" style="display: none;">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Modals (same as before) -->
    <!-- Add Interest Modal -->
    <div class="modal fade" id="addInterestModal" tabindex="-1" aria-labelledby="addInterestLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content ">
                <div class="modal-header ">
                    <h6 class="modal-title" id="addInterestLabel"><i class="fas fa-plus-circle"></i> Add Interest</h6>
                   <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
                </div>
                <form id="addInterestForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="interestName" class="form-label">Interest Name *</label>
                            <input type="text" class="form-control" id="interestName" name="name" required 
                                   placeholder="Enter interest name">
                            <div class="invalid-feedback" id="interestNameError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn saveBtn">
                            <i class="fas fa-save"></i> Save Interest
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Interest Modal -->
    <div class="modal fade" id="editInterestModal" tabindex="-1" aria-labelledby="editInterestLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editInterestLabel"><i class="fas fa-edit"></i> Edit Interest</h6>
                    <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
                </div>
                <form id="editInterestForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editInterestId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editInterestName" class="form-label">Interest Name *</label>
                            <input type="text" class="form-control" id="editInterestName" name="name" required
                                   placeholder="Enter interest name">
                            <div class="invalid-feedback" id="editInterestNameError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn saveBtn">
                            <i class="fas fa-sync-alt"></i> Update Interest
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Budget Modal -->
    <div class="modal fade" id="addBudgetModal" tabindex="-1" aria-labelledby="addBudgetLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="addBudgetLabel"><i class="fas fa-plus-circle"></i> Add Budget</h6>
                    <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
                </div>
                <form id="addBudgetForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="budgetName" class="form-label">Budget Name *</label>
                            <input type="text" class="form-control" id="budgetName" name="budgetname" required
                                   placeholder="Enter budget name">
                            <div class="invalid-feedback" id="budgetNameError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn saveBtn">
                            <i class="fas fa-save"></i> Save Budget
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Budget Modal -->
    <div class="modal fade" id="editBudgetModal" tabindex="-1" aria-labelledby="editBudgetLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="editBudgetLabel"><i class="fas fa-edit"></i> Edit Budget</h6>
                    <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
                </div>
                <form id="editBudgetForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editBudgetId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editBudgetName" class="form-label">Budget Name *</label>
                            <input type="text" class="form-control" id="editBudgetName" name="budgetname" required
                                   placeholder="Enter budget name">
                            <div class="invalid-feedback" id="editBudgetNameError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn saveBtn">
                            <i class="fas fa-sync-alt"></i> Update Budget
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        $(document).ready(function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            let interestsTable = null;
            let budgetsTable = null;
            function initializeDataTables() {
                if ($.fn.DataTable.isDataTable('#interestsTable')) {
                    interestsTable.destroy();
                    $('#interestsTable').empty();
                }
                if ($.fn.DataTable.isDataTable('#budgetsTable')) {
                    budgetsTable.destroy();
                    $('#budgetsTable').empty();
                }
                interestsTable = $('#interestsTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    lengthChange: false,
                    pageLength: 10,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search interests..."
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
                                        <button class="btn btn-sm btn-success edit-interest" 
                                                data-id="${row.id}" 
                                                data-name="${row.name}"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-interest" 
                                                data-id="${row.id}"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ]
                });
                
                budgetsTable = $('#budgetsTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    lengthChange: false,
                    pageLength: 10,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search budgets..."
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'budgetname' },
                        { 
                            data: null,
                            orderable: false,
                            render: function(data, type, row) {
                                return `
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-success edit-budget" 
                                                data-id="${row.id}" 
                                                data-name="${row.budgetname}"
                                                title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-budget" 
                                                data-id="${row.id}"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ]
                });
            }
            
            initializeDataTables();
            // Load Interests Function
            function loadInterests() {
                $('#interestsLoading').show();
                $('#interestsTable').closest('.table-responsive').hide();
                
                $.ajax({
                    url: '{{ route("interests.index") }}',
                    type: 'GET',
                    success: function(response) {
                        $('#interestsLoading').hide();
                        $('#interestsTable').closest('.table-responsive').show();
                        
                        if (response && response.length > 0) {
                            interestsTable.clear();
                            interestsTable.rows.add(response);
                            interestsTable.draw();
                        } else {
                            interestsTable.clear();
                            interestsTable.draw();
                            // Show empty message in the table
                            interestsTable.row.add({
                                'id': '',
                                'name': '<div class="text-center text-muted">No interests found</div>',
                                'null': ''
                            }).draw();
                        }
                    },
                    error: function(xhr) {
                        $('#interestsLoading').hide();
                        $('#interestsTable').closest('.table-responsive').show();
                        console.error('Error loading interests:', xhr);
                        showAlert('Error loading interests!', 'danger');
                    }
                });
            }
            
            function loadBudgets() {
                $('#budgetsLoading').show();
                $('#budgetsTable').closest('.table-responsive').hide();
                
                $.ajax({
                    url: '{{ route("budgets.index") }}',
                    type: 'GET',
                    success: function(response) {
                        $('#budgetsLoading').hide();
                        $('#budgetsTable').closest('.table-responsive').show();
                        
                        if (response && response.length > 0) {
                            budgetsTable.clear();
                            budgetsTable.rows.add(response);
                            budgetsTable.draw();
                        } else {
                            budgetsTable.clear();
                            budgetsTable.draw();
                            budgetsTable.row.add({
                                'id': '',
                                'budgetname': '<div class="text-center text-muted">No budgets found</div>',
                                'null': ''
                            }).draw();
                        }
                    },
                    error: function(xhr) {
                        $('#budgetsLoading').hide();
                        $('#budgetsTable').closest('.table-responsive').show();
                        console.error('Error loading budgets:', xhr);
                        showAlert('Error loading budgets!', 'danger');
                    }
                });
            }
            
            
            $('#addInterestForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                const saveBtn = $(this).find('.saveBtn');
                const originalText = saveBtn.html();
                
                saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
                
                $.ajax({
                    url: '{{ route("interests.store") }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        saveBtn.prop('disabled', false).html(originalText);
                        $('#addInterestModal').modal('hide');
                        $('#addInterestForm')[0].reset();
                        loadInterests();
                        showAlert(response.message);
                    },
                    error: function(xhr) {
                        saveBtn.prop('disabled', false).html(originalText);
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('#interestName').addClass('is-invalid');
                                $('#interestNameError').text(errors.name[0]);
                            }
                        } else {
                            showAlert('Error adding interest!', 'danger');
                        }
                    }
                });
            });
            
            // Edit Interest Form Submission
            $('#editInterestForm').on('submit', function(e) {
                e.preventDefault();
                
                const interestId = $('#editInterestId').val();
                const formData = $(this).serialize();
                const updateBtn = $(this).find('.saveBtn');
                const originalText = updateBtn.html();
                
                updateBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
                
                $.ajax({
                    url: `/interests-update/${interestId}`,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        updateBtn.prop('disabled', false).html(originalText);
                        $('#editInterestModal').modal('hide');
                        loadInterests();
                        showAlert(response.message);
                    },
                    error: function(xhr) {
                        updateBtn.prop('disabled', false).html(originalText);
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('#editInterestName').addClass('is-invalid');
                                $('#editInterestNameError').text(errors.name[0]);
                            }
                        } else {
                            showAlert('Error updating interest!', 'danger');
                        }
                    }
                });
            });
            
            // Add Budget Form Submission
            $('#addBudgetForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                const saveBtn = $(this).find('.saveBtn');
                const originalText = saveBtn.html();
                
                saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
                
                $.ajax({
                    url: '{{ route("budgets.store") }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        saveBtn.prop('disabled', false).html(originalText);
                        $('#addBudgetModal').modal('hide');
                        $('#addBudgetForm')[0].reset();
                        loadBudgets();
                        showAlert(response.message);
                    },
                    error: function(xhr) {
                        saveBtn.prop('disabled', false).html(originalText);
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.budgetname) {
                                $('#budgetName').addClass('is-invalid');
                                $('#budgetNameError').text(errors.budgetname[0]);
                            }
                        } else {
                            showAlert('Error adding budget!', 'danger');
                        }
                    }
                });
            });
            
            // Edit Budget Form Submission
            $('#editBudgetForm').on('submit', function(e) {
                e.preventDefault();
                
                const budgetId = $('#editBudgetId').val();
                const formData = $(this).serialize();
                const updateBtn = $(this).find('.saveBtn');
                const originalText = updateBtn.html();
                
                updateBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
                
                $.ajax({
                    url: `/budgets-update/${budgetId}`,
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        updateBtn.prop('disabled', false).html(originalText);
                        $('#editBudgetModal').modal('hide');
                        loadBudgets();
                        showAlert(response.message);
                    },
                    error: function(xhr) {
                        updateBtn.prop('disabled', false).html(originalText);
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.budgetname) {
                                $('#editBudgetName').addClass('is-invalid');
                                $('#editBudgetNameError').text(errors.budgetname[0]);
                            }
                        } else {
                            showAlert('Error updating budget!', 'danger');
                        }
                    }
                });
            });
            
            // Event Delegation for Edit/Delete Buttons
            $(document).on('click', '.edit-interest', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                
                $('#editInterestId').val(id);
                $('#editInterestName').val(name);
                $('#editInterestName').removeClass('is-invalid');
                $('#editInterestNameError').text('');
                $('#editInterestModal').modal('show');
            });
            
            $(document).on('click', '.delete-interest', function() {
                if (confirm('Are you sure you want to delete this interest? This action cannot be undone.')) {
                    const id = $(this).data('id');
                    
                    $.ajax({
                        url: `/interests-delete/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function() {
                            showAlert('Deleting interest...', 'info');
                        },
                        success: function(response) {
                            loadInterests();
                            showAlert(response.message);
                        },
                        error: function(xhr) {
                            showAlert('Error deleting interest!', 'danger');
                        }
                    });
                }
            });
            
            $(document).on('click', '.edit-budget', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                
                $('#editBudgetId').val(id);
                $('#editBudgetName').val(name);
                $('#editBudgetName').removeClass('is-invalid');
                $('#editBudgetNameError').text('');
                $('#editBudgetModal').modal('show');
            });
            
            $(document).on('click', '.delete-budget', function() {
                if (confirm('Are you sure you want to delete this budget? This action cannot be undone.')) {
                    const id = $(this).data('id');
                    
                    $.ajax({
                        url: `/budgets-delete/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function() {
                            showAlert('Deleting budget...', 'info');
                        },
                        success: function(response) {
                            loadBudgets();
                            showAlert(response.message);
                        },
                        error: function(xhr) {
                            showAlert('Error deleting budget!', 'danger');
                        }
                    });
                }
            });
            
            // Clear validation on modal hide
            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').text('');
                $(this).find('form')[0].reset();
            });
            
            // Initial Load
            loadInterests();
            loadBudgets();
        });
    </script>
@endpush