@extends('layouts.admin')
@section('title', 'Admin || Manage Company Setting')

@section('content')
@section('page', 'Manage Company Setting')

<div class="card mb-6">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Company Settings</h5>
    </div>
    <div class="card-body">
        <form id="company-settings-form" enctype="multipart/form-data">
            <div class="row">
                {{-- Company Info --}}
                <h6 class="fw-bold mb-3">Company Info :</h6>

                <div class="col-md-6 mb-4">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="company_name" id="company-name" class="form-control" placeholder="Full Name" required value="{{ $settings?->company_name ?? '' }}" />
                            <label for="company-name">Full Name</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="company_short_name" id="company_short_name" class="form-control" placeholder="Short Name" required value="{{ $settings?->company_short_name ?? '' }}" />
                            <label for="company_short_name">Short Name</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="company_tagline" id="company-tagline" class="form-control" placeholder="Tagline" value="{{ $settings?->company_tagline ?? '' }}" />
                            <label for="company-tagline">Website Title</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="input-group input-group-merge">
                        <span class=""><i class="ri-edit-line ri-20px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea name="company_description" id="company-description" class="form-control" placeholder="Description" rows="4">{{ $settings?->company_description ?? '' }}</textarea>
                            <label for="company-description">Short Description</label>
                        </div>
                    </div>
                </div>

                {{-- Logos --}}
                <h6 class="fw-bold mb-3 mt-4">Logos, Favicon & Other page Banner :</h6>

                <div class="col-md-4 mb-4">
                    <label for="light-logo" class="form-label">Full Logo</label>
                    <input type="file" name="light_logo" id="light-logo" class="form-control" />
                    @if($settings?->light_logo)
                        <img id="show-lightlogo" class="mt-2 col-6 w-25 preview-img" src="{{ asset('storage/' . $settings->light_logo) }}" alt="Light Logo" />
                    @else
                        <img id="show-lightlogo" class="mt-2 col-6 d-none w-25 preview-img" src="" alt="Light Logo" />
                    @endif
                    <input type="hidden" name="oldlight_logo" id="oldlight_logo" value="{{ $settings?->light_logo ?? '' }}">
                </div>

                <div class="col-md-4 mb-4">
                    <label for="favicon" class="form-label">Favicon</label>
                    <input type="file" name="favicon" id="favicon" class="form-control" />
                    @if($settings?->favicon)
                        <img id="show-favicon" class="mt-2 col-6 w-25 preview-img" src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon" />
                    @else
                        <img id="show-favicon" class="mt-2 col-6 d-none w-25 preview-img" src="" alt="Favicon" />
                    @endif
                    <input type="hidden" name="oldfavicon" id="oldfavicon" value="{{ $settings?->favicon ?? '' }}">
                </div>

                <div class="col-md-4 mb-4">
                    <label for="dark-logo" class="form-label">Other page Banner Image</label>
                    <input type="file" name="footer_images" id="dark-logo" class="form-control" />
                    @if($settings?->footer_images)
                        <img id="show-darklogo" class="mt-2 col-6 w-25 preview-img" src="{{ asset('storage/' . $settings->footer_images) }}" alt="Footer Image" />
                    @else
                        <img id="show-darklogo" class="mt-2 col-6 d-none w-25 preview-img" src="" alt="Footer Image" />
                    @endif
                    <input type="hidden" name="oldfooter_images" id="oldfooter_images" value="{{ $settings?->footer_images ?? '' }}">
                </div>

                {{-- Emails --}}
                <h6 class="fw-bold mb-3">Company Email :</h6>
                <div class="col-md-6 mb-4">
                    <div class="input-group input-group-merge">
                        <span class=""><i class="ri-mail-line ri-20px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="email" name="company_email1" id="company_email1" class="form-control" placeholder="Email 1" value="{{ $settings?->company_email1 ?? '' }}" />
                            <label for="company_email1">Email 1</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="input-group input-group-merge">
                        <span class=""><i class="ri-mail-send-line ri-20px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="email" name="company_email2" id="company_email2" class="form-control" placeholder="Email 2" value="{{ $settings?->company_email2 ?? '' }}" />
                            <label for="company_email2">Email 2</label>
                        </div>
                    </div>
                </div>

                {{-- Mobile Numbers --}}
                <h6 class="fw-bold mb-3">Company Mobile No. :</h6>
                <div class="col-md-3 mb-4">
                    <div class="input-group input-group-merge">
                        <span class=""><i class="ri-phone-line ri-20px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="company_mobile1" id="company_mobile1" class="form-control" minlength="10" maxlength="10" placeholder="Mobile No. 1" value="{{ $settings?->company_mobile1 ?? '' }}" />
                            <label for="company_mobile1">Mobile No. 1</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="input-group input-group-merge">
                        <span class=""><i class="ri-smartphone-line ri-20px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="company_mobile2" id="company_mobile2" class="form-control" minlength="10" maxlength="10" placeholder="Mobile No. 2" value="{{ $settings?->company_mobile2 ?? '' }}" />
                            <label for="company_mobile2">Mobile No. 2</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="input-group input-group-merge">
                        <span class=""><i class="ri-whatsapp-line ri-20px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="company_whatsapp1" id="company_whatsapp1" class="form-control" minlength="10" maxlength="10" placeholder="Whatsapp No. 1" value="{{ $settings?->company_whatsapp1 ?? '' }}" />
                            <label for="company_whatsapp1">Whatsapp No. 1</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="input-group input-group-merge">
                        <span class=""><i class="ri-whatsapp-line ri-20px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="company_whatsapp2" id="company_whatsapp2" class="form-control" minlength="10" maxlength="10" placeholder="Whatsapp No. 2" value="{{ $settings?->company_whatsapp2 ?? '' }}" />
                            <label for="company_whatsapp2">Whatsapp No. 2</label>
                        </div>
                    </div>
                </div>

                {{-- Social Media --}}
                <h6 class="fw-bold mb-3">Company Social Media Links :</h6>
                <div class="col-md-4 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input type="url" name="facebook" id="facebook" class="form-control" placeholder="Facebook" value="{{ $settings?->facebook ?? '' }}" />
                        <label for="facebook">Facebook</label>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input type="url" name="twitter" id="twitter" class="form-control" placeholder="Twitter" value="{{ $settings?->twitter ?? '' }}" />
                        <label for="twitter">Twitter</label>
                    </div>
                </div>
                {{-- <div class="col-md-4 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input type="url" name="youtube" id="youtube" class="form-control" placeholder="YouTube" value="{{ $settings?->youtube ?? '' }}" />
                        <label for="youtube"></label>
                    </div>
                </div> --}}
                <div class="col-md-4 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input type="url" name="instagram" id="instagram" class="form-control" placeholder="Instagram" value="{{ $settings?->instagram ?? '' }}" />
                        <label for="instagram">Instagram</label>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input type="url" name="pintrest" id="pintrest" class="form-control" placeholder="Pinterest" value="{{ $settings?->pintrest ?? '' }}" />
                        <label for="YouTube">YouTube</label>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input type="url" name="map" id="map" class="form-control" placeholder="Google Map Link" value="{{ $settings?->map ?? '' }}" />
                        <label for="map">Google Map</label>
                    </div>
                </div>

                {{-- Address --}}
                <h6 class="fw-bold mb-3">Company Addresses :</h6>
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <textarea name="company_address1" id="company_address1" class="form-control" placeholder="Address 1" style="height: 80px">{{ $settings?->company_address1 ?? '' }}</textarea>
                        <label for="company_address1">Address 1</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <textarea name="company_address2" id="company_address2" class="form-control" placeholder="Address 2" style="height: 80px">{{ $settings?->company_address2 ?? '' }}</textarea>
                        <label for="company_address2">Address 2</label>
                    </div>
                </div>

                {{-- Office Timings --}}
                <h6 class="fw-bold mb-3 mt-4">Office Timings :</h6>
                <div id="office-timings-wrap" class="col-md-12">
    @php $timings = $settings?->office_timings ?? []; @endphp
    @foreach($timings ?: [['title' => '', 'time' => '']] as $i => $t)
                    <div class="row office-timing-row align-items-center mb-3">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="office_timings[{{ $i }}][title]" class="form-control" placeholder="e.g. Mon - Sat" value="{{ $t['title'] ?? '' }}">
                                <label>Day / Title</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="office_timings[{{ $i }}][time]" class="form-control" placeholder="e.g. 9:00 AM - 8:00 PM" value="{{ $t['time'] ?? '' }}">
                                <label>Time</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-timing-row"><i class="ri-delete-bin-line"></i> Remove</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-12 mb-4">
                    <button type="button" id="add-timing-row" class="btn btn-outline-primary btn-sm"><i class="ri-add-line"></i> Add More Timing</button>
                </div>

                {{-- <h6 class="fw-bold mb-3">Company Currency :</h6>
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="currency_name" id="currency_name" class="form-control" placeholder="Currency Name" value="{{ $settings?->currency_name ?? '' }}" />
                        <label for="currency_name">Currency Name</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="currency_symbol" id="currency_symbol" class="form-control" placeholder="Currency Symbol" value="{{ $settings?->currency_symbol ?? '' }}" />
                        <label for="currency_symbol">Currency Symbol</label>
                    </div>
                </div> --}}

                <div class="text-start">
                    <button type="submit" class="btn btn-primary btn-md mt-3">Setting Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let timingIndex = $('#office-timings-wrap .office-timing-row').length;

    function timingRowHtml(idx, title = '', time = '') {
        return `
        <div class="row office-timing-row align-items-center mb-3">
            <div class="col-md-5">
                <div class="form-floating form-floating-outline">
                    <input type="text" name="office_timings[${idx}][title]" class="form-control" placeholder="e.g. Mon - Sat" value="${title}">
                    <label>Day / Title</label>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-floating form-floating-outline">
                    <input type="text" name="office_timings[${idx}][time]" class="form-control" placeholder="e.g. 9:00 AM - 8:00 PM" value="${time}">
                    <label>Time</label>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger btn-sm remove-timing-row"><i class="ri-delete-bin-line"></i> Remove</button>
            </div>
        </div>`;
    }

    $(document).ready(function() {
        $('#company-settings-form').submit(updateSettings);

        $('#add-timing-row').click(function() {
            $('#office-timings-wrap').append(timingRowHtml(timingIndex));
            timingIndex++;
        });

        $(document).on('click', '.remove-timing-row', function() {
            $(this).closest('.office-timing-row').remove();
        });
        $('input[type="file"]').change(function() {
            let id = $(this).attr('id');
            let previewId = 'show-' + id;
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result).removeClass('d-none');
                };
                reader.readAsDataURL(this.files[0]);
            } else {
                // Agar file clear ki gayi ho to preview hide kar do
                $('#' + previewId).addClass('d-none').attr('src', '');
            }
        });
    });

    function loadSettings() {
        $.ajax({
            url: "{{ route('admin.company-settings.get') }}",
            type: "GET",
            success: function(res) {
                if (res.success && res.data) {
                    let s = res.data;
                    // Fill all text fields
                    Object.keys(s).forEach(key => {
                        if ($(`input[name="${key}"], textarea[name="${key}"]`).length) {
                            $(`[name="${key}"]`).val(s[key]);
                        }
                    });

                    // Update hidden old file paths
                    $('#oldlight_logo').val(s.light_logo || '');
                    $('#oldfooter_images').val(s.footer_images || '');
                    $('#oldfavicon').val(s.favicon || '');

                    // Update image previews
                    if (s.light_logo) $('#show-lightlogo').attr('src', '/storage/' + s.light_logo).removeClass('d-none');
                    if (s.footer_images) $('#show-darklogo').attr('src', '/storage/' + s.footer_images).removeClass('d-none');
                    if (s.favicon) $('#show-favicon').attr('src', '/storage/' + s.favicon).removeClass('d-none');

                    // Office timings rows rebuild karo
                    let timings = s.office_timings;
                    if (typeof timings === 'string') {
                        try { timings = JSON.parse(timings); } catch (e) { timings = []; }
                    }
                    $('#office-timings-wrap').empty();
                    timingIndex = 0;
                    if (timings && timings.length) {
                        timings.forEach(function(t) {
                            $('#office-timings-wrap').append(timingRowHtml(timingIndex, t.title || '', t.time || ''));
                            timingIndex++;
                        });
                    } else {
                        $('#office-timings-wrap').append(timingRowHtml(0));
                        timingIndex = 1;
                    }
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to load settings!', 'error');
            }
        });
    }

    function updateSettings(e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);
        if (!form.light_logo.files.length) {
            formData.delete('light_logo');
        }
        if (!form.footer_images.files.length) {
            formData.delete('footer_images');
        }
        if (!form.favicon.files.length) {
            formData.delete('favicon');
        }

        let btn = $(this).find('button[type="submit"]');
        let original = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: "{{ route('admin.company-settings.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res.success) {
                    loadSettings();
                    showAlert(res.message, 'success');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error updating settings!';
                if (xhr.responseJSON?.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                Swal.fire('Error', errorMsg, 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(original);
            }
        });
    }
</script>
@endpush