<?php $__env->startSection('title', 'Admin || Management Appointments'); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
   
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('page', 'Management Appointments '); ?>
<div class="container pt-3 card">
    <div class="appointments-section">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="search-container w-50">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" class="form-control form-control-sm" 
                           placeholder="Search appointments...">
                </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn cu" onclick="showAddModal()">
                    <i class="fas fa-plus"></i> Add Appointment
                </button>
                <button class="btn btn-danger" id="deleteSelected" style="display: none;">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="appointmentsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%"><input type="checkbox" id="selectAll"></th>
                        <th width="5%">ID</th>
                        <th width="15%">Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Service</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="appointmentsLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>
<!-- Add Appointment Modal -->
<div class="modal fade" id="addAppointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Appointment</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="addAppointmentForm">
                <div class="modal-body">

                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                        <div class="invalid-feedback">Please enter name</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                        <div class="invalid-feedback">Please enter valid email</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" class="form-control" name="phone" minlength="10" maxlength="10" placeholder="Enter Phone" required>
                        <div class="invalid-feedback">Please enter 10-digit phone number</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Service *</label>
                        <select class="form-control" name="service" required>
                            <option value="">Select Service</option>
                            <option value="Manual Therapy">Manual Therapy</option>
                            <option value="Orthopedic Rehabilitation">Orthopedic Rehabilitation</option>
                            <option value="Pediatric Physiotherapy">Pediatric Physiotherapy</option>
                        </select>
                        <div class="invalid-feedback">Please select service</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" placeholder="Enter Message"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-control" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="read">Read</option>
                            <option value="replied">Replied</option>
                        </select>
                        <div class="invalid-feedback">Please select status</div>
                    </div>
                </div>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Appointment</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="editAppointmentForm">
                <input type="hidden" name="id" id="editAppointmentId">
                <div class="modal-body">

                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" id="editAppointmentName" required>
                        <div class="invalid-feedback">Please enter name</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" id="editAppointmentEmail" required>
                        <div class="invalid-feedback">Please enter valid email</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" class="form-control" name="phone" id="editAppointmentPhone" minlength="10" maxlength="10" required>
                        <div class="invalid-feedback">Please enter 10-digit phone number</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Service *</label>
                        <select class="form-control" name="service" id="editAppointmentService" required>
                            <option value="">Select Service</option>
                            <option value="Manual Therapy">Manual Therapy</option>
                            <option value="Orthopedic Rehabilitation">Orthopedic Rehabilitation</option>
                            <option value="Pediatric Physiotherapy">Pediatric Physiotherapy</option>
                        </select>
                        <div class="invalid-feedback">Please select service</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" id="editAppointmentMessage"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select class="form-control" name="status" id="editAppointmentStatus" required>
                            <option value="pending">Pending</option>
                            <option value="read">Read</option>
                            <option value="replied">Replied</option>
                        </select>
                        <div class="invalid-feedback">Please select status</div>
                    </div>
                 </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
        let appointmentsTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(document).ready(function() {
            // Important: Ensure no duplicate initialization
            if ($.fn.DataTable.isDataTable('#appointmentsTable')) {
                $('#appointmentsTable').DataTable().destroy();
            }

            initializeDataTable();
            loadAppointments();

            // Search functionality
            $('#searchInput').on('keyup', function() {
                if (appointmentsTable) {
                    appointmentsTable.search(this.value).draw();
                }
            });

            $('#addAppointmentForm').submit(addAppointment);
            $('#editAppointmentForm').submit(updateAppointment);

            $(document).on('click', '.delete-appointment', function() {
                const id = $(this).data('id');
                deleteAppointment(id);
            });

            // Select all checkbox
            $('#selectAll').on('click', function() {
                $('tbody input.select-checkbox:visible').prop('checked', this.checked);
                toggleDeleteSelected();
            });

            // Individual checkboxes
            $(document).on('change', '.select-checkbox', function() {
                toggleDeleteSelected();
            });

            // Delete selected
            $('#deleteSelected').on('click', deleteSelected);
        });

        function initializeDataTable() {
            appointmentsTable = $('#appointmentsTable').DataTable({
                // DataTable configuration
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                lengthMenu: [ [10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"] ],
                pageLength: 10,

                // Hide default search box (hum apna custom use kar rahe hain)
              dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-6"i><"col-6 text-end"p>>',

                language: {
                    search: "", // Default search text hide kiya
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ appointments",
                    infoEmpty: "No appointments available",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                },

                // Make sure columns match your thead
                columns: [
                    { 
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: "text-center select-checkbox",
                        render: function(data, type, row) {
                            return '<input type="checkbox" class="select-checkbox" value="' + row.id + '">';
                        }
                    },
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: 'service' },
                    { 
                        data: 'message',
                        render: function(data) {
                            return data ? data.substring(0, 50) + (data.length > 50 ? '...' : '') : '';
                        }
                    },
                    { 
                        data: 'status',
                        render: function(data) {
                            let badgeClass = data === 'pending' ? 'badge bg-warning' :
                                            data === 'read' ? 'badge bg-info' :
                                            data === 'replied' ? 'badge bg-success' : 'badge bg-secondary';
                            let text = data.charAt(0).toUpperCase() + data.slice(1);
                            return `<span class="${badgeClass}">${text}</span>`;
                        }
                    },
                    { 
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-success" onclick="editAppointment(${row.id})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-appointment" data-id="${row.id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                
                // Custom search function for better filtering
                search: {
                    regex: false,
                    smart: true
                }
            });
        }

        function loadAppointments() {
            $('#appointmentsLoading').show();
            $.ajax({
                url: "<?php echo e(route('admin.appointments.get')); ?>",
                type: "GET",
                success: function(response) {
                    $('#appointmentsLoading').hide();
                    if (response.success && response.data.length > 0) {
                        appointmentsTable.clear().rows.add(response.data).draw();
                    } else {
                        appointmentsTable.clear().draw();
                        // Empty state message
                        appointmentsTable.row.add({
                            id: '',
                            name: '<div class="text-center text-muted">No appointments found</div>',
                            email: '',
                            phone: '',
                            service: '',
                            message: '',
                            status: ''
                        }).draw();
                    }
                },
                error: function() {
                    $('#appointmentsLoading').hide();
                    showAlert('Error loading appointments!', 'error');
                }
            });
        }

        // Rest of the functions same as before
        function showAddModal() {
            $('#addAppointmentForm')[0].reset();
            $('#addAppointmentForm .is-invalid').removeClass('is-invalid');
            $('#addAppointmentModal').modal('show');
        }

        function addAppointment(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            $.ajax({
                url: "<?php echo e(route('admin.appointments.store')); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(response) {
                    if (response.success) {
                        $('#addAppointmentModal').modal('hide');
                        loadAppointments();
                        showAlert(response.message || 'Appointment submitted successfully!', 'success');
                    } else {
                        showAlert(response.message || 'Error saving appointment!', 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#addAppointmentForm .is-invalid').removeClass('is-invalid');
                        for (const field in errors) {
                            $(`#addAppointmentForm [name="${field}"]`).addClass('is-invalid');
                        }
                    } else {
                        showAlert('Error saving appointment!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function editAppointment(id) {
            const data = appointmentsTable.rows().data().toArray();
            const appointment = data.find(a => a.id == id);
            
            if (appointment) {
                $('#editAppointmentId').val(appointment.id);
                $('#editAppointmentName').val(appointment.name);
                $('#editAppointmentEmail').val(appointment.email);
                $('#editAppointmentPhone').val(appointment.phone);
                $('#editAppointmentService').val(appointment.service);
                $('#editAppointmentMessage').val(appointment.message);
                $('#editAppointmentStatus').val(appointment.status);
                $('#editAppointmentForm .is-invalid').removeClass('is-invalid');
                $('#editAppointmentModal').modal('show');
            } else {
                showAlert('Appointment not found in current view!', 'error');
            }
        }

        function updateAppointment(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $('#editAppointmentId').val();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
            $.ajax({
                url: '<?php echo e(route("admin.appointments.update", ":id")); ?>'.replace(':id', id),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(response) {
                    if (response.success) {
                        $('#editAppointmentModal').modal('hide');
                        loadAppointments();
                        showAlert(response.message || 'Appointment updated successfully!', 'success');
                    } else {
                        showAlert(response.message || 'Error updating appointment!', 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#editAppointmentForm .is-invalid').removeClass('is-invalid');
                        for (const field in errors) {
                            $(`#editAppointmentForm [name="${field}"]`).addClass('is-invalid');
                        }
                    } else {
                        showAlert('Error updating appointment!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function deleteAppointment(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the appointment permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo e(route("admin.appointments.delete", ":id")); ?>'.replace(':id', id),
                        type: "DELETE",
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        success: function(response) {
                            if (response.success) {
                                loadAppointments();
                                showAlert(response.message || 'Appointment deleted successfully!', 'success');
                            } else {
                                showAlert(response.message || 'Error deleting appointment!', 'error');
                            }
                        },
                        error: function() {
                            showAlert('Error deleting appointment!', 'error');
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
            const selectedIds = $('tbody input.select-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length === 0) return;

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${selectedIds.length} appointments!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo e(route('admin.appointments.bulk-delete')); ?>",
                        type: "POST",
                        data: { ids: selectedIds, _token: csrfToken },
                        success: function(response) {
                            if (response.success) {
                                loadAppointments();
                                showAlert(response.message || 'Appointments deleted successfully!', 'success');
                            } else {
                                showAlert(response.message || 'Error deleting appointments!', 'error');
                            }
                        },
                        error: function() {
                            showAlert('Error deleting selected appointments!', 'error');
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\p2gh-main\resources\views/admin/manage-appointment.blade.php ENDPATH**/ ?>