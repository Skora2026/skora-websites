@extends('layouts.admin')
@section('title', 'Admin || Bookings Management')
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endpush

@section('content')
@section('page', 'Bookings Management')

<div class="container pt-3 card">
    <div class="amenities-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fw-semi-bold">All Bookings</h6>
        </div>

        <div class="table-responsive">
            <table id="bookingsTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th>Project</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Aadhar</th>
                        <th>PAN</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Point of Contact</th>
                        <th>Manager</th>
                        <th>Documents</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="bookingsLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<!-- View Booking Modal -->
<div class="modal fade" id="viewBookingModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Booking Details</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body" id="viewBookingBody">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Edit Booking Modal -->
<div class="modal fade" id="editBookingModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Booking</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="editBookingForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editBookingId">

                <div class="modal-body">
                    <ul class="nav nav-tabs" id="editTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button">Basic Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button">Address</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button">Documents</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Project</label>
                                    <select name="project_id" id="editProjectId" class="form-control" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Manager</label>
                                    <select name="manager" id="editManager" class="form-control" required>
                                        <option value="">Select Manager...</option>
                                        @forelse($managers as $id => $name)
                                        <option value="{{ $id }}" {{ old('point_of_contact') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                        @empty
                                            <option>No Manager Found</option>
                                        @endforelse
                                    </select>
                                    @error('manager') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Salutation</label>
                                    <select name="salutation" id="editSalutation" class="form-control" required>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Ms.">Ms.</option>
                                        <option value="Mrs.">Mrs.</option>
                                    </select>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" id="editName" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="phone" id="editPhone" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" id="editEmail" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Aadhar Number</label>
                                    <input type="text" name="aadhar_number" id="editAadhar" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>PAN Number</label>
                                    <input type="text" name="pan_number" id="editPan" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Point of Contact</label>
                                <select name="point_of_contact" id="editPointOfContact" class="form-control" required>
                                         <option value="">Select Point Of Contact....</option>
                                        @forelse($pointofcontact as $id => $name)
                                            <option value="{{ $id }}" {{ old('point_of_contact') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @empty
                                            <option>No Point Of Contact Found</option>
                                        @endforelse
                                    </select>
                                    @error('point_of_contact') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="tab-pane fade" id="address" role="tabpanel">
                            <div class="mb-3">
                                <label>Address</label>
                                <textarea name="address" id="editAddress" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label>Country</label>
                                    <input type="text" name="country" id="editCountry" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>City</label>
                                    <input type="text" name="city" id="editCity" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>State</label>
                                    <input type="text" name="state" id="editState" class="form-control" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Pincode</label>
                                    <input type="text" name="pincode" id="editPincode" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="documents" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Aadhar Front</label>
                                    <input type="file" name="aadhar_front" id="editAadharFront" class="form-control" accept="image/*,application/pdf">
                                    <small id="currentAadharFront" class="form-text text-muted"></small>
                                    <div id="previewAadharFront" class="mt-2"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Aadhar Back</label>
                                    <input type="file" name="aadhar_back" id="editAadharBack" class="form-control" accept="image/*,application/pdf">
                                    <small id="currentAadharBack" class="form-text text-muted"></small>
                                    <div id="previewAadharBack" class="mt-2"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>PAN Card</label>
                                    <input type="file" name="pan_card" id="editPanCard" class="form-control" accept="image/*,application/pdf">
                                    <small id="currentPanCard" class="form-text text-muted"></small>
                                    <div id="previewPanCard" class="mt-2"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Application Form (PDF only)</label>
                                    <input type="file" name="application_form" id="editApplicationForm" class="form-control" accept=".pdf">
                                    <small id="currentApplicationForm" class="form-text text-muted"></small>
                                    <div id="previewApplicationForm" class="mt-2"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Cheque Copy (Optional)</label>
                                    <input type="file" name="cheque_copy" id="editChequeCopy" class="form-control" accept="image/*,application/pdf">
                                    <small id="currentChequeCopy" class="form-text text-muted"></small>
                                    <div id="previewChequeCopy" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Booking</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let bookingsTable = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $(document).ready(function() {
            initializeDataTable();
            loadBookings();
            $('#editBookingForm').on('submit', function(e) {
                e.preventDefault();
                updateBooking();
            });
            // Delete handler
            $(document).on('click', '.delete-booking', function() {
                const id = $(this).data('id');
                deleteBooking(id);
            });
            // View handler
            $(document).on('click', '.view-booking', function() {
                const id = $(this).data('id');
                viewBooking(id);
            });

            // File preview handlers
            $('#editAadharFront, #editAadharBack, #editPanCard, #editApplicationForm, #editChequeCopy').on('change', function() {
                const id = this.id;
                const previewId = id.replace('edit', 'preview');
                previewFile(this.files[0], previewId);
            });
        });

        function previewFile(file, previewId) {
            if (!file) return;
            const previewDiv = $('#' + previewId);
            previewDiv.empty();

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = $('<img>').attr('src', e.target.result).css({ maxWidth: '100%', maxHeight: '200px' });
                    previewDiv.append(img);
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                const objectUrl = URL.createObjectURL(file);
                const iframe = $('<iframe>').attr('src', objectUrl).css({ width: '100%', height: '200px', border: '1px solid #ddd' });
                previewDiv.append(iframe);
            }
        }

        function initializeDataTable() {
            bookingsTable = $('#bookingsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: false,
                pageLength: 50,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search bookings..."
                },
                columns: [
                    { data: 'id', width: "5%" },
                    { 
                        data: 'project', 
                        render: function(data, type, row) {
                            return data ? data.title || 'No Project' : 'No Project';
                        }
                    },
                    { data: 'name' },
                    { data: 'phone' },
                    { data: 'email' },
                    { data: 'aadhar_number' },
                    { data: 'pan_number' },
                    { 
                        data: 'address',
                        render: function(data) {
                            return data ? (data.length > 30 ? data.substring(0, 30) + '...' : data) : '';
                        }
                    },
                    { data: 'city' },
                    { data: 'point_of_contact' },
                    { data: 'manager' },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            let html = '<div class="d-flex gap-1 flex-wrap">';
                            if (row.aadhar_front_url) {
                                html += `<a href="${row.aadhar_front_url}" class="btn btn-sm btn-outline-primary" download title="Download Aadhar Front"><i class="bi bi-file-earmark-pdf"></i></a>`;
                            }
                            if (row.aadhar_back_url) {
                                html += `<a href="${row.aadhar_back_url}" class="btn btn-sm btn-outline-primary" download title="Download Aadhar Back"><i class="bi bi-file-earmark-pdf"></i></a>`;
                            }
                            if (row.pan_card_url) {
                                html += `<a href="${row.pan_card_url}" class="btn btn-sm btn-outline-secondary" download title="Download PAN Card"><i class="bi bi-file-earmark-person"></i></a>`;
                            }
                            if (row.application_form_url) {
                                html += `<a href="${row.application_form_url}" class="btn btn-sm btn-outline-primary" download title="Download Application Form"><i class="bi bi-file-earmark-text"></i></a>`;
                            }
                            if (row.cheque_copy_url) {
                                html += `<a href="${row.cheque_copy_url}" class="btn btn-sm btn-outline-info" download title="Download Cheque Copy"><i class="bi bi-file-earmark-check"></i></a>`;
                            }
                            html += '</div>';
                            return html || 'No Documents';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        width: "10%",
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons d-flex gap-1">
                                    <button class="btn btn-sm btn-info view-booking" data-id="${row.id}" title="View">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" onclick="editBooking(${row.id})" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-booking" data-id="${row.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        function loadBookings() {
            $('#bookingsLoading').show();
            $.ajax({
                url: '/admin/bookings/data', 
                type: "GET",
                success: function(response) {
                    $('#bookingsLoading').hide();

                    if (response.success && response.data && response.data.length > 0) {
                        bookingsTable.clear();
                        bookingsTable.rows.add(response.data);
                        bookingsTable.draw();
                    } else {
                        bookingsTable.clear().draw();
                    }
                },
                error: function() {
                    $('#bookingsLoading').hide();
                    Swal.fire('Error!', 'Failed to load bookings.', 'error');
                }
            });
        }

        function viewBooking(id) {
            $.ajax({
                url: '/admin/bookings/edit/' + id,
                type: "GET",
                success: function(response) {
                    if (response.success && response.booking) {
                        const b = response.booking;
                        let html = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Project: ${b.project ? b.project.title : 'N/A'}</h6>
                                    <p><strong>Salutation:</strong> ${b.salutation}</p>
                                    <p><strong>Name:</strong> ${b.name}</p>
                                    <p><strong>Phone:</strong> ${b.phone}</p>
                                    <p><strong>Email:</strong> ${b.email}</p>
                                    <p><strong>Aadhar Number:</strong> ${b.aadhar_number}</p>
                                    <p><strong>PAN Number:</strong> ${b.pan_number}</p>
                                    <p><strong>Point of Contact:</strong> ${b.point_of_contact}</p>
                                    <p><strong>Manager:</strong> ${b.manager}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Address Details</h6>
                                    <p><strong>Address:</strong> ${b.address}</p>
                                    <p><strong>City:</strong> ${b.city}</p>
                                    <p><strong>State:</strong> ${b.state}</p>
                                    <p><strong>Country:</strong> ${b.country}</p>
                                    <p><strong>Pincode:</strong> ${b.pincode}</p>
                                </div>
                            </div>
                            <hr>
                            <h6>Documents</h6>
                            <div class="row">`;
                        if (b.aadhar_front_url) {
                            html += `<div class="col-md-3 mb-2"><a href="${b.aadhar_front_url}" class="btn btn-outline-primary btn-sm" target="_blank">Preview Aadhar Front <i class="bi bi-eye"></i></a></div>`;
                        }
                        if (b.aadhar_back_url) {
                            html += `<div class="col-md-3 mb-2"><a href="${b.aadhar_back_url}" class="btn btn-outline-primary btn-sm" target="_blank">Preview Aadhar Back <i class="bi bi-eye"></i></a></div>`;
                        }
                        if (b.pan_card_url) {
                            html += `<div class="col-md-3 mb-2"><a href="${b.pan_card_url}" class="btn btn-outline-secondary btn-sm" target="_blank">Preview PAN Card <i class="bi bi-eye"></i></a></div>`;
                        }
                        if (b.application_form_url) {
                            html += `<div class="col-md-3 mb-2"><a href="${b.application_form_url}" class="btn btn-outline-primary btn-sm" target="_blank">Preview Application Form <i class="bi bi-eye"></i></a></div>`;
                        }
                        if (b.cheque_copy_url) {
                            html += `<div class="col-md-3 mb-2"><a href="${b.cheque_copy_url}" class="btn btn-outline-info btn-sm" target="_blank">Preview Cheque Copy <i class="bi bi-eye"></i></a></div>`;
                        }
                        html += `</div>`;
                        $('#viewBookingBody').html(html);
                        $('#viewBookingModal').modal('show');
                    } else {
                        Swal.fire('Error', 'Booking data not found.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to fetch booking details.', 'error');
                }
            });
        }

        function editBooking(id) {
            $.ajax({
                url: '/admin/bookings/edit/' + id,
                type: "GET",
                success: function(response) {
                    if (response.success && response.booking) {
                        const b = response.booking;

                        $('#editBookingId').val(b.id);
                        $('#editProjectId').val(b.project_id);
                        $('#editSalutation').val(b.salutation);
                        $('#editName').val(b.name);
                        $('#editPhone').val(b.phone);
                        $('#editEmail').val(b.email);
                        $('#editAadhar').val(b.aadhar_number);
                        $('#editPan').val(b.pan_number);
                        $('#editAddress').val(b.address);
                        $('#editCity').val(b.city);
                        $('#editState').val(b.state);
                        $('#editPincode').val(b.pincode);
                        $('#editPointOfContact').val(b.point_of_contact);
                        $('#editManager').val(b.manager);
                        $('#editCountry').val(b.country || '');

                        // Set current file info and previews
                        setFileInfoAndPreview('AadharFront', b.aadhar_front, b.aadhar_front_url);
                        setFileInfoAndPreview('AadharBack', b.aadhar_back, b.aadhar_back_url);
                        setFileInfoAndPreview('PanCard', b.pan_card, b.pan_card_url);
                        setFileInfoAndPreview('ApplicationForm', b.application_form, b.application_form_url);
                        setFileInfoAndPreview('ChequeCopy', b.cheque_copy, b.cheque_copy_url);

                        // Clear file inputs
                        $('#editAadharFront, #editAadharBack, #editPanCard, #editApplicationForm, #editChequeCopy').val('');

                        // Activate first tab
                        $('#editTabs .nav-link').removeClass('active');
                        $('#basic-tab').addClass('active');
                        $('.tab-pane').removeClass('show active');
                        $('#basic').addClass('show active');

                        $('#editBookingModal').modal('show');
                    } else {
                        Swal.fire('Error', 'Booking data not found.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to fetch booking details.', 'error');
                }
            });
        }

        function setFileInfoAndPreview(type, filePath, fileUrl) {
            const currentId = 'current' + type;
            const previewId = 'preview' + type;
            const previewDiv = $('#' + previewId);
            previewDiv.empty();

            if (filePath) {
                const fileName = filePath.split('/').pop();
                $('#' + currentId).text('Current: ' + fileName);

                // Add preview for current file
                if (fileUrl) {
                    const isPdf = filePath.endsWith('.pdf');
                    if (isPdf) {
                        const iframe = $('<iframe>').attr('src', fileUrl).css({ width: '100%', height: '200px', border: '1px solid #ddd' });
                        previewDiv.append($('<p>').text('Current Preview:')).append(iframe);
                    } else {
                        // For images
                        const img = $('<img>').attr('src', fileUrl).css({ maxWidth: '100%', maxHeight: '200px' });
                        previewDiv.append($('<p>').text('Current Preview:')).append(img);
                    }
                }
            } else {
                $('#' + currentId).text('No file');
            }
        }

        function updateBooking() {
            const id = $('#editBookingId').val();
            const submitBtn = $('#editBookingForm button[type="submit"]');
            const originalText = submitBtn.html();

            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

            $.ajax({
                url: '/admin/bookings/update/' + id,
                type: "POST",
                data: new FormData($('#editBookingForm')[0]),
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                     showAlert(response.message, 'success');
                },
                error: function(xhr) {
                    let msg = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', msg, 'error');
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function deleteBooking(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This booking will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/bookings/delete/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                             showAlert(response.message, 'success');
                            loadBookings();
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to delete booking.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush