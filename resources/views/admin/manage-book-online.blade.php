@extends('layouts.admin')
@section('title', 'Admin || Manage Book Online Section')

@push('styles')
    <style>
        textarea { min-height: 150px; }
        .tox-tinymce {
            height: 400px !important;
        }
    </style>
@endpush

@section('content')
@section('page', 'Manage Book Online Section')

<div class="container pt-3 card">
    <div class="card-body">
        <h5 class="card-title mb-4">Edit Book Online Section</h5>

        <form id="updateForm" class="row g-4">
            @csrf

            <div class="col-md-6">
                <label class="form-label">Sub Title</label>
                <input type="text" class="form-control" name="sub_title" id="sub_title" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Main Title</label>
                <input type="text" class="form-control" name="main_title" id="main_title" required>
            </div>

            <div class="col-12">
                <label class="form-label">Description 1 (Right of Image)</label>
                <textarea class="tinymce-editor" name="description_left" id="description_left" required></textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Description 2 (Full Width Bottom)</label>
                <textarea class="tinymce-editor" name="description_bottom" id="description_bottom" required></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Current GIF/Image</label>
                <div id="currentGifPreview" class="mb-3">
                    <img src="{{ asset('assets-front/img/gif.gif') }}" class="img-fluid rounded shadow" style="max-height:400px;">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Upload New GIF/Image (optional)</label>
                <input type="file" class="form-control" name="gif_image" accept="image/*">
                <small class="text-muted">Supports GIF, JPG, PNG etc.</small>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary btn-lg">Update Section</button>
            </div>
        </form>

        <div id="loading" class="spinner-container mt-4">
            <div class="spinner"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('tiny/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let tinymceEditors = {}; // To store editor instances

    $(document).ready(function() {
        initTinyMCE();
        loadSection();
        $('#updateForm').submit(updateSection);
    });

    function initTinyMCE() {
        const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        tinymce.init({
            selector: 'textarea.tinymce-editor',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            branding: false,
            promotion: false,
            elementpath: false,
            skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',
            height: 400,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            forced_root_block: "",
            force_br_newlines: true,
            force_p_newlines: false,
            convert_newlines_to_brs: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_retention: '2m',
            link_list: [],
            image_list: [],
            file_picker_callback: (callback, value, meta) => {},
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
            setup: function (editor) {
                editor.on('init', function () {
                    // Store editor instance
                    tinymceEditors[editor.id] = editor;
                });
            }
        });
    }

    function loadSection() {
        $('#loading').show();
        $.ajax({
            url: "{{ route('admin.bookonline.get') }}",
            type: "GET",
            success: function(res) {
                $('#loading').hide();
                if (res.success && res.data) {
                    let s = res.data;
                    $('#sub_title').val(s.sub_title);
                    $('#main_title').val(s.main_title);

                    // Set TinyMCE content if editors are initialized
                    if (tinymceEditors['description_left']) {
                        tinymceEditors['description_left'].setContent(s.description_left || '');
                    } else {
                        $('#description_left').val(s.description_left || '');
                    }
                    if (tinymceEditors['description_bottom']) {
                        tinymceEditors['description_bottom'].setContent(s.description_bottom || '');
                    } else {
                        $('#description_bottom').val(s.description_bottom || '');
                    }

                    if (s.gif_image) {
                        $('#currentGifPreview img').attr('src', '/storage/' + s.gif_image);
                    }
                } else {
                    showAlert('No data found. Fill and update to create.', 'info');
                }
            },
            error: function() {
                $('#loading').hide();
                showAlert('Error loading data!', 'error');
            }
        });
    }

    function updateSection(e) {
        e.preventDefault();
        let formData = new FormData(this);

        // Get TinyMCE content
        if (tinymceEditors['description_left']) {
            formData.append('description_left', tinymceEditors['description_left'].getContent());
        }
        if (tinymceEditors['description_bottom']) {
            formData.append('description_bottom', tinymceEditors['description_bottom'].getContent());
        }

        let btn = $(this).find('button[type="submit"]');
        let original = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        $.ajax({
            url: "{{ route('admin.bookonline.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(res) {
                if (res.success) {
                    loadSection();
                    showAlert(res.message, 'success');
                }
            },
            error: function() {
                showAlert('Error updating section!', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(original);
            }
        });
    }
</script>
@endpush