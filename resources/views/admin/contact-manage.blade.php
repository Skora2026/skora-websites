@extends('layouts.admin')
@section('title', 'Admin || Manage Contacts')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Manage Contacts')

<div class="container pt-3 card">
    <div class="contacts-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="form-control form-control-sm" 
                       placeholder="Search contacts...">
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-danger" id="deleteSelected" style="display: none;">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="contactsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%"><input type="checkbox" id="selectAll"></th>
                        <th width="5%">ID</th>
                        <th width="15%">Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Message (Preview)</th>
                        <th>Status</th>
                        <th width="10%">Created At</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="contactsLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>



<!-- Edit Contact Modal -->
{{-- <div class="modal fade" id="editContactModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Contact</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="editContactForm">
                <input type="hidden" name="id" id="editContactId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control" name="name" id="editContactName" required>
                            <div class="invalid-feedback">Please enter name</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" id="editContactEmail" required>
                            <div class="invalid-feedback">Please enter valid email</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone *</label>
                            <input type="text" class="form-control" name="phone" id="editContactPhone" minlength="10" maxlength="10" required>
                            <div class="invalid-feedback">Please enter 10-digit phone number</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Subject *</label>
                            <input type="text" class="form-control" name="subject" id="editContactSubject" required>
                            <div class="invalid-feedback">Please enter subject</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" id="editContactMessage"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status *</label>
                            <select class="form-control" name="status" id="editContactStatus" required>
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
                    <button type="submit" class="btn btn-primary">Update Contact</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<!-- View Contact Modal -->
<div class="modal fade" id="viewContactModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contact Details</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body" id="contactDetailsBody">
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
        let contactsTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $(document).ready(function() {
            // Important: Ensure no duplicate initialization
            if ($.fn.DataTable.isDataTable('#contactsTable')) {
                $('#contactsTable').DataTable().destroy();
            }

            initializeDataTable();
            loadContacts();

            // Search functionality
            $('#searchInput').on('keyup', function() {
                if (contactsTable) {
                    contactsTable.search(this.value).draw();
                }
            });

            $('#addContactForm').submit(addContact);
            $('#editContactForm').submit(updateContact);

            $(document).on('click', '.delete-contact', function() {
                const id = $(this).data('id');
                deleteContact(id);
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
            contactsTable = $('#contactsTable').DataTable({
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
                    info: "Showing _START_ to _END_ of _TOTAL_ contacts",
                    infoEmpty: "No contacts available",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                },

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
                    { data: 'subject' },
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
                        data: 'created_at',
                        render: function(data) {
                            return new Date(data).toLocaleDateString();
                        }
                    },
                    { 
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info" onclick="viewContact(${row.id})" title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-contact" data-id="${row.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                
                search: {
                    regex: false,
                    smart: true
                }
            });
        }

        function loadContacts() {
            $('#contactsLoading').show();
            $.ajax({
                url: "{{ route('admin.contacts.get') }}",
                type: "GET",
                success: function(response) {
                    $('#contactsLoading').hide();
                    if (response.success && response.data.length > 0) {
                        contactsTable.clear().rows.add(response.data).draw();
                    } else {
                        contactsTable.clear().draw();
                        // Empty state message
                        contactsTable.row.add({
                            id: '',
                            name: '<div class="text-center text-muted">No contacts found</div>',
                            email: '',
                            phone: '',
                            subject: '',
                            message: '',
                            status: '',
                            created_at: ''
                        }).draw();
                    }
                },
                error: function() {
                    $('#contactsLoading').hide();
                    showAlert('Error loading contacts!', 'error');
                }
            });
        }

        function showAddModal() {
            $('#addContactForm')[0].reset();
            $('#addContactForm .is-invalid').removeClass('is-invalid');
            $('#addContactModal').modal('show');
        }

        function addContact(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
            $.ajax({
                url: "",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(response) {
                    if (response.success) {
                        $('#addContactModal').modal('hide');
                        loadContacts();
                        showAlert(response.message || 'Contact added successfully!', 'success');
                    } else {
                        showAlert(response.message || 'Error adding contact!', 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#addContactForm .is-invalid').removeClass('is-invalid');
                        for (const field in errors) {
                            $(`#addContactForm [name="${field}"]`).addClass('is-invalid');
                        }
                    } else {
                        showAlert('Error adding contact!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function editContact(id) {
            const data = contactsTable.rows().data().toArray();
            const contact = data.find(c => c.id == id);
            
            if (contact) {
                $('#editContactId').val(contact.id);
                $('#editContactName').val(contact.name);
                $('#editContactEmail').val(contact.email);
                $('#editContactPhone').val(contact.phone);
                $('#editContactSubject').val(contact.subject);
                $('#editContactMessage').val(contact.message);
                $('#editContactStatus').val(contact.status);
                $('#editContactForm .is-invalid').removeClass('is-invalid');
                $('#editContactModal').modal('show');
            } else {
                showAlert('Contact not found in current view!', 'error');
            }
        }

        function updateContact(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const id = $('#editContactId').val();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
            $.ajax({
                url: '',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(response) {
                    if (response.success) {
                        $('#editContactModal').modal('hide');
                        loadContacts();
                        showAlert(response.message || 'Contact updated successfully!', 'success');
                    } else {
                        showAlert(response.message || 'Error updating contact!', 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $('#editContactForm .is-invalid').removeClass('is-invalid');
                        for (const field in errors) {
                            $(`#editContactForm [name="${field}"]`).addClass('is-invalid');
                        }
                    } else {
                        showAlert('Error updating contact!', 'error');
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function viewContact(id) {
            $.ajax({
                url: `/contacts/${id}`, 
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const contact = response.data;
                        let detailsHtml = `
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> ${contact.name}</p>
                                    <p><strong>Email:</strong> ${contact.email}</p>
                                    <p><strong>Phone:</strong> ${contact.phone || 'N/A'}</p>
                                    <p><strong>Subject:</strong> ${contact.subject || 'N/A'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Status:</strong> <span class="badge ${contact.status === 'pending' ? 'bg-warning' : contact.status === 'read' ? 'bg-info' : 'bg-success'}">${contact.status.charAt(0).toUpperCase() + contact.status.slice(1)}</span></p>
                                    <p><strong>Created:</strong> ${new Date(contact.created_at).toLocaleString()}</p>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <strong>Message:</strong>
                                <p class="mt-2">${contact.message}</p>
                            </div>
                        `;
                        $('#contactDetailsBody').html(detailsHtml);
                        $('#viewContactModal').modal('show');
                    }
                },
                error: function() {
                    showAlert('Error loading contact details!', 'error');
                }
            });
        }

        function deleteContact(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the contact permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/contacts/' + id,
                        type: "DELETE",
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        success: function(response) {
                            if (response.success) {
                                loadContacts();
                                showAlert(response.message || 'Contact deleted successfully!', 'success');
                            } else {
                                showAlert(response.message || 'Error deleting contact!', 'error');
                            }
                        },
                        error: function() {
                            showAlert('Error deleting contact!', 'error');
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
                text: `You are about to delete ${selectedIds.length} contacts!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.contacts.bulk-delete') }}",
                        type: "POST",
                        data: { ids: selectedIds, _token: csrfToken },
                        success: function(response) {
                            if (response.success) {
                                loadContacts();
                                showAlert(response.message || 'Contacts deleted successfully!', 'success');
                            } else {
                                showAlert(response.message || 'Error deleting contacts!', 'error');
                            }
                        },
                        error: function() {
                            showAlert('Error deleting selected contacts!', 'error');
                        }
                    });
                }
            });
        }
      
    </script>
@endpush