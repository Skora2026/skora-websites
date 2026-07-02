@extends('layouts.admin')
@section('title', 'Admin || Management Properties')
@push('styles')
    <script src="{{ asset('tiny/vendor/tinymce/tinymce.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa !important;
    }
    #searchSuggestions {
        border-top: none;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .search-suggestion-item {
        transition: background 0.2s;
    }
    .dropdownsss{
        font-size: 11px !important;
    }
    .onsearchingcolor{
        color: rgb(111, 16, 245);
    }

    .progress-bar{
        background: #43bf09 !important;
    }
</style>
    @endpush
@section('content')
@section('page', 'Management Properties')
<div class="container pt-3 card">
    <div class="properties-section">
            <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="position-relative">
                            <input type="text" id="smartSearch" class="form-control" style="font-size: 13px;" placeholder="Search by Title, Property ID, Price, Location..."
                                autocomplete="off">
                            <!-- Suggestions Dropdown -->
                            <div id="searchSuggestions"
                                class="position-absolute w-100 bg-white border rounded-bottom shadow-lg mt-1"
                                style="z-index: 9999; max-height: 400px; overflow-y: auto; display: none;">
                                <div class="p-2 text-center text-muted small" id="noResults">
                                    Type to search or click to see all properties
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-primary" onclick="showAddModal()">
                        <i class="fas fa-plus"></i> Add Property
                    </button>
                </div>
            </div>
        <div class="table-responsive">
            <table id="propertiesTable" class="table table-striped table-bordered w-100">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="15%">Project</th>
                        <th width="15%">Image</th>
                        <th>Property main title</th>
                        <th>Building Name</th>
                        <th>Price</th>
                        <th>Status</th>
                         <th width="12%">Video</th>
                         <th width="12%">Property Listing</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="propertiesLoading" class="spinner-container">
            <div class="spinner"></div>
        </div>
    </div>
</div>
<!-- Add Property Modal -->
<div class="modal fade" id="addPropertyModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Property</h5>
               <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="addPropertyForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step-item active" data-step="1">1</div>
                        <div class="step-item" data-step="2">2</div>
                        <div class="step-item" data-step="3">3</div>
                    </div>
                    <!-- Step 1: Basic Information -->
                    <div class="step active" id="addStep1">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Project Type</label>
                                <select class="form-control" name="project_id">
                                    <option value="">Select Project Type</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a project</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Property main title </label>
                                <input type="text" class="form-control" name="title" placeholder="Enter Main Title Property As,BHK(1,2,3....10)">
                                <div class="invalid-feedback">Please enter property title</div>
                            </div>
                             <div class="col-md-4 mb-3">
                                <label class="form-label">Building Name</label>
                                <input type="text" class="form-control" name="building_name" placeholder="Enter Building Name">
                                <div class="invalid-feedback">Please enter Property Building Name</div>
                            </div>
                             <div class="col-md-4 mb-3">
                                <label class="form-label">Property Logo/image</label>
                                <input type="file" class="form-control" name="logo" accept="image/*">
                                <div class="form-text">Upload property Logo/image</div>
                                <div id="currentaddlogo" class="mt-2"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Property ID</label>
                                <input type="text" class="form-control" name="property_id" placeholder="e.g., PR-45892">
                                <div class="invalid-feedback">Please enter property ID</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="price" placeholder="e.g., 3850000">
                                <div class="invalid-feedback">Please enter price</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-control" name="type">
                                    <option value="Apartment">Apartment</option>
                                    <option value="Villa">Villa</option>
                                    <option value="Independent House">Independent House</option>
                                    <option value="Plot">Plot</option>
                                </select>
                                <div class="invalid-feedback">Please select type</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status">
                                    <option value="Ready To Move">Ready To Move</option>
                                    <option value="Under Construction">Under Construction</option>
                                    <option value="New Launch">New Launch</option>
                                </select>
                                <div class="invalid-feedback">Please select status</div>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2: Property Details -->
                    <div class="step" id="addStep2">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Area (Sq Ft)</label>
                                <input type="number" class="form-control" name="area_sqft" placeholder="e.g., 1840">
                                <div class="invalid-feedback">Please enter area</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bedrooms</label>
                                <input type="number" class="form-control" name="bedrooms" placeholder="e.g., 3">
                                <div class="invalid-feedback">Please enter bedrooms</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bathrooms</label>
                                <input type="number" class="form-control" name="bathrooms" placeholder="e.g., 2">
                                <div class="invalid-feedback">Please enter bathrooms</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Furnishing</label>
                                <select class="form-control" name="furnishing">
                                    <option value="Furnished">Furnished</option>
                                    <option value="Semi-furnished">Semi-furnished</option>
                                    <option value="Unfurnished">Unfurnished</option>
                                </select>
                                <div class="invalid-feedback">Please select furnishing</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Property Age (Years)</label>
                                <input type="number" class="form-control" name="property_age" placeholder="e.g., 4">
                                <div class="invalid-feedback">Please enter property age</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sale Type</label>
                                <select class="form-control" name="sale_type">
                                    <option value="For Sale">For Sale</option>
                                    <option value="For Rent">For Rent</option>
                                </select>
                                <div class="invalid-feedback">Please select sale type</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Parking</label>
                                <div>
                                    <input type="checkbox" class="form-check-input" name="parking" value="1">
                                    <span class="form-check-label">Enable parking</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Listed Date</label>
                                <input type="date" class="form-control" name="listed_date">
                            </div>
                        </div>
                    </div>
                    <div class="step" id="addStep3">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Location Details (comma-separated)</label>
                                <input type="text" class="form-control" name="location_details_input" placeholder="e.g., Near Air Force Station, Near New Noida">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Map Location</label>
                                <input type="text" class="form-control" name="map" placeholder="e.g., https://www.google.com/maps/embed?pb=!1m18!1m1......en!2sin">
                            </div>
                           
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Amenities</label>
                                <select class="form-control amenities-select" name="amenities[]" multiple>
                                      @foreach ($Amenities as $amenity)
                                        <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select amenities</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Images (Multiple)</label>
                                <input type="file" class="form-control" name="images[]" accept="image/*" multiple>
                                <div class="form-text">Upload property images</div>
                                <div id="addImagePreviews" class="d-flex flex-wrap gap-2 mt-2"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Floor Plan Image</label>
                                <input type="file" class="form-control" name="floor_plan_image" accept="image/*">
                                <div class="form-text">Upload floor plan</div>
                                <div id="addFloorPlanPreview" class="mt-2"></div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="text-black fw-semibold">Long Description/Details :</label>
                                <textarea name="description" id="description" class="form-control tinymce-editor" placeholder="Enter Description" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="addPrevBtn" style="display: none;"><i class="bi bi-arrow-left-circle"></i> Previous</button>
                    <button type="button" class="btn btn-primary" id="addNextBtn"><i class="bi bi-arrow-right-circle"></i> Go Next</button>
                    <button type="submit" class="btn btn-primary" id="addSubmitBtn" style="display: none;">Save Property</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Property Modal -->
<div class="modal fade" id="editPropertyModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Property</h5>
               <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <form id="editPropertyForm" enctype="multipart/form-data">
                <input type="hidden" name="id" id="editPropertyId">
                <div class="modal-body">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step-item active" data-step="1">1</div>
                        <div class="step-item" data-step="2">2</div>
                        <div class="step-item" data-step="3">3</div>
                    </div>
                    <!-- Step 1: Basic Information -->
                    <div class="step active" id="editStep1">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Project</label>
                                <select class="form-control" name="project_id" id="editProjectId">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a project</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Property Title</label>
                                <input type="text" class="form-control" name="title" id="editTitle">
                                <div class="invalid-feedback">Please enter property title</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Building Name</label>
                                <input type="text" class="form-control" name="building_name" id="editBuildingName" placeholder="Enter Building Name">
                                <div class="invalid-feedback">Please enter Building Name</div>
                            </div>
                             <div class="col-md-4 mb-3">
                                <label class="form-label">Upload new property logo (Optional)</label>
                                <input type="file" class="form-control" name="logo" accept="image/*">
                                <div class="form-text">Upload new property logo(replaces current)</div>
                                <div id="editlogoPreview" class="mt-2"></div>
                                <label class="form-label">Current logo</label>
                                <div id="currentlogo" class="mb-2"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Property ID</label>
                                <input type="text" class="form-control" name="property_id" id="editPropertyIdField">
                                <div class="invalid-feedback">Please enter property ID</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price (₹)</label>
                                <input type="number" step="0.01" class="form-control" name="price" id="editPrice">
                                <div class="invalid-feedback">Please enter price</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-control" name="type" id="editType">
                                    <option value="Apartment">Apartment</option>
                                    <option value="Villa">Villa</option>
                                    <option value="Independent House">Independent House</option>
                                    <option value="Plot">Plot</option>
                                </select>
                                <div class="invalid-feedback">Please select type</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="editStatus">
                                    <option value="Ready To Move">Ready To Move</option>
                                    <option value="Under Construction">Under Construction</option>
                                    <option value="New Launch">New Launch</option>
                                </select>
                                <div class="invalid-feedback">Please select status</div>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2: Property Details -->
                    <div class="step" id="editStep2">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Area (Sq Ft)</label>
                                <input type="number" class="form-control" name="area_sqft" id="editAreaSqft">
                                <div class="invalid-feedback">Please enter area</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bedrooms</label>
                                <input type="number" class="form-control" name="bedrooms" id="editBedrooms">
                                <div class="invalid-feedback">Please enter bedrooms</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bathrooms</label>
                                <input type="number" class="form-control" name="bathrooms" id="editBathrooms">
                                <div class="invalid-feedback">Please enter bathrooms</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Furnishing</label>
                                <select class="form-control" name="furnishing" id="editFurnishing">
                                    <option value="Furnished">Furnished</option>
                                    <option value="Semi-furnished">Semi-furnished</option>
                                    <option value="Unfurnished">Unfurnished</option>
                                </select>
                                <div class="invalid-feedback">Please select furnishing</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Property Age (Years)</label>
                                <input type="number" class="form-control" name="property_age" id="editPropertyAge">
                                <div class="invalid-feedback">Please enter property age</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sale Type</label>
                                <select class="form-control" name="sale_type" id="editSaleType">
                                    <option value="For Sale">For Sale</option>
                                    <option value="For Rent">For Rent</option>
                                </select>
                                <div class="invalid-feedback">Please select sale type</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Parking</label>
                                <div>
                                    <input type="checkbox" class="form-check-input" name="parking" value="1" id="editParking">
                                    <span class="form-check-label">Enable parking</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Listed Date</label>
                                <input type="date" class="form-control" name="listed_date" id="editListedDate">
                            </div>
                        </div>
                    </div>
                    <!-- Step 3: Advanced Details -->
                    <div class="step" id="editStep3">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Location Details (comma-separated)</label>
                                <input type="text" class="form-control" name="location_details_input" id="editLocationDetails" placeholder="e.g., Near Air Force Station, Near New Noida">
                                <div class="invalid-feedback">Please enter location details</div>
                            </div>
                             <div class="col-md-8 mb-3">
                                <label class="form-label">Map Location</label>
                                <input type="text" class="form-control" name="map" id="editmap" placeholder="e.g., https://www.google.com/maps/embed?pb=!1m18!1m1......en!2sin">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Amenities</label>
                                <select class="form-control amenities-select" id="editAmenitiesSelect" name="amenities[]" multiple>
                                    @foreach ($Amenities as $amenity)
                                        <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select amenities</div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 mb-3">
                                <label class="form-label">Update Images (Optional)</label>
                                <input type="file" class="form-control" name="images[]" id="editNewImagesInput" accept="image/*" multiple>
                                <div class="form-text">Upload additional property images</div>
                                <div id="newImagePreviews" class="d-flex flex-wrap gap-2 mt-2"></div>
                                 <label class="form-label">Current Images</label>
                                <div id="currentImagesContainer" class="d-flex flex-wrap gap-2 mb-2"></div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Update Floor Plan (Optional)</label>
                                <input type="file" class="form-control" name="floor_plan_image" accept="image/*">
                                <div class="form-text">Upload new floor plan (replaces current)</div>
                                <div id="editFloorPlanPreview" class="mt-2"></div>
                                <label class="form-label">Current Floor Plan</label>
                                <div id="currentFloorPlan" class="mb-2"></div>
                            </div>
                            </div>
                          
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control tinymce-editor" name="description" id="editDescription" rows="4" placeholder="Enter Description"></textarea>
                                <div class="invalid-feedback">Please enter description</div>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="editPrevBtn" style="display: none;"> <i class="bi bi-arrow-left-circle"></i> Previous</button>
                    <button type="button" class="btn btn-primary" id="editNextBtn"> <i class="bi bi-arrow-right-circle"></i> Next</button>
                    <button type="submit" class="btn btn-primary" id="editSubmitBtn" style="display: none;">Update Property</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Property Listing Modal -->
<div class="modal fade" id="listingModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Property Listing</h5>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="listingSelect" class="form-label">Choose Listing Type</label>
                    <select class="form-select" id="listingSelect">
                        <option value="top Property">Top Property</option>
                        <option value="list on banner">List on Banner Hero Section</option>
                        <option value="none">Unselect / None</option>
                    </select>
                </div>
                <div class="alert alert-info small">
                    Note: Only one "Top Property" and one "List on Banner" can be active at a time. Selecting a new one will unselect the previous.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveListingBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Video Upload Modal -->
<div class="modal fade" id="videoUploadModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Property Video</h5>
                 <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm position-absolute top-0 end-0 m-3 z-3" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;" data-bs-dismiss="modal" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>            </div>
            <form id="videoUploadForm" enctype="multipart/form-data">
                <input type="hidden" name="property_id" id="videoPropertyId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-danger">Select Video File (Max 2GB, MP4/MOV/AVI/WMV/FLV/WEBM)</label>
                        <input type="file" class="form-control" name="video" accept="video/*" required>
                        <div class="form-text">Upload a video for this property. Existing video will be replaced.</div>
                    </div>
                    <div class="progress mb-3" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                    </div>
                    <div id="videoUploadStatus" class="alert" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="videoSubmitBtn">Upload Video</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Global vars
        let propertiesTable = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let addSelectedImages = [];
        let editSelectedImages = [];
        let currentAddStep = 1;
        let currentEditStep = 1;
        let allProperties = []; // For smart search
        let currentVideoPropertyId = null;
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        $(document).ready(function() {
            initializeDataTable();
            loadProperties(); // Merged version
            $('#addPropertyForm').submit(addProperty);
            $('#editPropertyForm').submit(updateProperty);
            setupMultiStepModals();
            setupImagePreviews();
            setupFloorPlanPreviews();
            setupVideoUpload(); // Video handler
        });
        function setupMultiStepModals() {
            // Add Modal Steps
            $('#addNextBtn').click(function() {
                if (validateStep('add', currentAddStep)) {
                    goToNextStep('add');
                }
            });
            $('#addPrevBtn').click(function() {
                goToPrevStep('add');
            });
            $('#addSubmitBtn').click(function(e) {
                if (validateStep('add', currentAddStep)) {
                    addProperty(e);
                }
            });
            // Edit Modal Steps
            $('#editNextBtn').click(function() {
                if (validateStep('edit', currentEditStep)) {
                    goToNextStep('edit');
                }
            });
            $('#editPrevBtn').click(function() {
                goToPrevStep('edit');
            });
            $('#editSubmitBtn').click(function(e) {
                if (validateStep('edit', currentEditStep)) {
                    updateProperty(e);
                }
            });
            setupStepClickHandlers('add');
            setupStepClickHandlers('edit');
        }
        // Make step indicators clickable
        function setupStepClickHandlers(modalType) {
            const prefix = modalType === 'add' ? '#addPropertyModal ' : '#editPropertyModal ';
            $(`${prefix}.step-indicator .step-item`).off('click').click(function() {
                const stepNum = parseInt($(this).data('step'));
                if (modalType === 'add') {
                    if (stepNum <= currentAddStep) {
                        goToStep('add', stepNum);
                    }
                } else {
                    if (stepNum <= currentEditStep) {
                        goToStep('edit', stepNum);
                    }
                }
            });
        }
        function goToStep(modalType, stepNum) {
            if (modalType === 'add') {
                currentAddStep = stepNum;
                $('.step').removeClass('active');
                $(`#addStep${stepNum}`).addClass('active');
                updateStepIndicator('add');
                updateButtons('add');
                $('#addPropertyModal .step-indicator .step-item').removeClass('completed');
                for (let i = 1; i < stepNum; i++) {
                    $('#addPropertyModal .step-indicator .step-item[data-step="' + i + '"]').addClass('completed');
                }
            } else {
                currentEditStep = stepNum;
                $('.step').removeClass('active');
                $(`#editStep${stepNum}`).addClass('active');
                updateStepIndicator('edit');
                updateButtons('edit');
                $('#editPropertyModal .step-indicator .step-item').removeClass('completed');
                for (let i = 1; i < stepNum; i++) {
                    $('#editPropertyModal .step-indicator .step-item[data-step="' + i + '"]').addClass('completed');
                }
            }
        }
        function goToNextStep(modalType) {
            if (modalType === 'add') {
                if (currentAddStep < 3) {
                    $(`#addStep${currentAddStep}`).removeClass('active');
                    currentAddStep++;
                    $(`#addStep${currentAddStep}`).addClass('active');
                    updateStepIndicator('add');
                    updateButtons('add');
                }
            } else {
                if (currentEditStep < 3) {
                    $(`#editStep${currentEditStep}`).removeClass('active');
                    currentEditStep++;
                    $(`#editStep${currentEditStep}`).addClass('active');
                    updateStepIndicator('edit');
                    updateButtons('edit');
                }
            }
        }
        function goToPrevStep(modalType) {
            if (modalType === 'add') {
                if (currentAddStep > 1) {
                    $(`#addStep${currentAddStep}`).removeClass('active');
                    currentAddStep--;
                    $(`#addStep${currentAddStep}`).addClass('active');
                    updateStepIndicator('add');
                    updateButtons('add');
                }
            } else {
                if (currentEditStep > 1) {
                    $(`#editStep${currentEditStep}`).removeClass('active');
                    currentEditStep--;
                    $(`#editStep${currentEditStep}`).addClass('active');
                    updateStepIndicator('edit');
                    updateButtons('edit');
                }
            }
        }
        function updateStepIndicator(modalType) {
            const prefix = modalType === 'add' ? '#addPropertyModal ' : '#editPropertyModal ';
            $(`${prefix}.step-indicator .step-item`).removeClass('active completed');
            const currentStep = modalType === 'add' ? currentAddStep : currentEditStep;
            $(`${prefix}.step-indicator .step-item[data-step="${currentStep}"]`).addClass('active');
            // Mark previous as completed
            for (let i = 1; i < currentStep; i++) {
                $(`${prefix}.step-indicator .step-item[data-step="${i}"]`).addClass('completed');
            }
        }
        function updateButtons(modalType) {
            const step = modalType === 'add' ? currentAddStep : currentEditStep;
            const prefix = modalType === 'add' ? '#add' : '#edit';
            if (step === 1) {
                $(`${prefix}PrevBtn`).hide();
                $(`${prefix}NextBtn`).show();
                $(`${prefix}SubmitBtn`).hide();
            } else if (step === 3) {
                $(`${prefix}PrevBtn`).show();
                $(`${prefix}NextBtn`).hide();
                $(`${prefix}SubmitBtn`).show();
            } else {
                $(`${prefix}PrevBtn`).show();
                $(`${prefix}NextBtn`).show();
                $(`${prefix}SubmitBtn`).hide();
            }
        }
        function validateStep(modalType, step) {
            let isValid = true;
            const prefix = modalType === 'add' ? '#addPropertyForm ' : '#editPropertyForm ';
            $(`${prefix}.step.active .form-control, ${prefix}.step.active select, ${prefix}.step.active input[type="number"], ${prefix}.step.active input[type="url"], ${prefix}.step.active input[type="date"]`).each(function() {
                if ($(this).hasClass('is-invalid') || ($(this).val() === '' && $(this).attr('required') !== undefined)) {
                    isValid = false;
                }
            });
            if (!isValid) {
                showAlert('Please fill all required fields in this step!', 'error');
            }
            return isValid;
        }
        function showAddModal() {
            currentAddStep = 1;
            $('#addPropertyForm')[0].reset();
            addSelectedImages = [];
            $('#addImagePreviews').empty();
            $('#addFloorPlanPreview').empty();
            $('#currentaddlogo').empty();
            $('#addPropertyForm .is-invalid').removeClass('is-invalid');
            $('#addPropertyForm .invalid-feedback').hide();
            if (tinymce.get('description')) tinymce.get('description').setContent('');
            $('#addPropertyModal .amenities-select').select2({
                placeholder: 'Select amenities',
                allowClear: true,
                width: '100%',
                dropdownParent: $('#addPropertyModal')
            });
            $('.step').removeClass('active');
            $('#addStep1').addClass('active');
            updateStepIndicator('add');
            updateButtons('add');
            setupStepClickHandlers('add');
            $('#addPropertyModal').modal('show');
        }
        function addProperty(e) {
            e.preventDefault();
            e.stopPropagation();
           
            // Sync TinyMCE content back to textarea
            if (tinymce.get('description')) {
                tinymce.get('description').save();
            }
        const amenitiesSelect = $('#addPropertyForm .amenities-select');
            const selectedAmenities = amenitiesSelect.val() || [];
           
            const imageInput = $('#addPropertyForm input[name="images[]"]')[0];
            imageInput.value = '';
            const form = document.getElementById('addPropertyForm');
            const formData = new FormData(form);
           
            const locationInput = formData.get('location_details_input');
            if (locationInput) {
                const locationArray = locationInput.split(',').map(item => item.trim()).filter(item => item);
                formData.append('location_details', JSON.stringify(locationArray));
            }
            formData.delete('location_details_input');
           
            formData.append('amenities', JSON.stringify(selectedAmenities));
           
            addSelectedImages.forEach(file => formData.append('images[]', file));
           
            const submitBtn = $('#addSubmitBtn');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
           
            $.ajax({
                url: "/properties/store",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        $('#addPropertyModal').modal('hide');
                        loadProperties();
                        showAlert(response.message, 'success');
                        addSelectedImages = [];
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
              error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('#addPropertyForm .is-invalid').removeClass('is-invalid');
                    $('#addPropertyForm .invalid-feedback').text('').hide();
                    let errorMessages = [];
                    for (const field in errors) {
                        const inputField = $(`#addPropertyForm [name="${field}"]`);
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            let feedback = inputField.next('.invalid-feedback');
                            if (!feedback.length) {
                                feedback = inputField.parent().find('.invalid-feedback');
                            }
                            feedback.text(errors[field][0]).show();
                        }
                        errorMessages.push(errors[field][0]);
                    }
                    showAlert(errorMessages.join('<br>'), 'error');
                } else {
                    showAlert(
                        xhr.responseJSON?.message || 'Something went wrong!',
                        'error'
                    );
                }
            },
            complete: function () {
                submitBtn.prop('disabled', false).html(originalText);
            }

            });
        }
        function editProperty(id) {
            currentEditStep = 1;
            addSelectedImages = [];
            editSelectedImages = [];
            $('#newImagePreviews').empty();
            $('#editFloorPlanPreview').empty();
            $('#editlogoPreview').empty();
           
            $.ajax({
                url: "/properties/" + id,
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const property = response.data;
                       
                        $('#editPropertyId').val(property.id);
                        $('#editProjectId').val(property.project_id);
                        $('#editTitle').val(property.title);
                        $('#editBuildingName').val(property.building_name);
                        $('#editPropertyIdField').val(property.property_id);
                        $('#editPrice').val(property.price);
                        $('#editType').val(property.type);
                        $('#editStatus').val(property.status);
                        $('#editAreaSqft').val(property.area_sqft);
                        $('#editBedrooms').val(property.bedrooms);
                        $('#editBathrooms').val(property.bathrooms);
                        $('#editFurnishing').val(property.furnishing);
                        $('#editPropertyAge').val(property.property_age);
                        $('#editSaleType').val(property.sale_type);
                        $('#editParking').prop('checked', property.parking == 1);
                        $('#editListedDate').val(property.listed_date);
                        $('#editDescription').val(property.description || '');
                        $('#editmap').val(property.map || '');
                       
                        let locationDetails = [];
                        if (property.location_details) {
                            locationDetails = typeof property.location_details === 'string' ?
                                JSON.parse(property.location_details) : property.location_details;
                        }
                        $('#editLocationDetails').val(locationDetails.join(', '));
                       
                        let amenities = [];
                        if (property.amenities) {
                            amenities = typeof property.amenities === 'string' ?
                                JSON.parse(property.amenities) : property.amenities;
                        }
                        $('#editAmenitiesSelect').select2({
                            placeholder: 'Select amenities',
                            allowClear: true,
                            width: '100%',
                            dropdownParent: $('#editPropertyModal')
                        });
                        $('#editAmenitiesSelect').val(amenities).trigger('change');
                       
                        let imageHtml = '<p class="text-muted">No images</p>';
                        if (property.images) {
                            try {
                                const images = typeof property.images === 'string' ?
                                    JSON.parse(property.images) : property.images;
                                if (images.length > 0) {
                                    imageHtml = images.map(img => `
                                        <div class="position-relative d-inline-block">
                                            <img src="/storage/${img.replace(/^public\//, '')}" class="img-thumbnail" style="width:80px;height:60px; object-fit:cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                                onclick="deleteImage(${property.id}, '${img}')"
                                                style="transform:translate(50%,-50%);padding:2px 6px; font-size:12px;">×</button>
                                        </div>
                                    `).join('');
                                }
                            } catch (e) {
                                console.log('Error parsing images:', e);
                            }
                        }
                        $('#currentImagesContainer').html(imageHtml);
                       
                        if (property.floor_plan_image) {
                            $('#currentFloorPlan').html(`
                                <img src="/storage/${property.floor_plan_image.replace(/^public\//, '')}" class="img-thumbnail" style="max-width:100px;">
                            `);
                        } else {
                            $('#currentFloorPlan').html('<p class="text-muted">No floor plan</p>');
                        }
                         
                          if (property.logo) {
                            $('#currentlogo').html(`
                                <img src="/storage/${property.logo.replace(/^public\//, '')}" class="img-thumbnail" style="max-width:100px;">
                            `);
                        } else {
                            $('#currentlogo').html('<p class="text-muted">No Property logo </p>');
                        }
                       
                        $('#editPropertyForm .is-invalid').removeClass('is-invalid');
                        $('#editPropertyForm .invalid-feedback').hide();
                        if (tinymce.get('editDescription')) tinymce.get('editDescription').setContent(property.description || '');
                        $('.step').removeClass('active');
                        $('#editStep1').addClass('active');
                        updateStepIndicator('edit');
                        updateButtons('edit');
                        setupStepClickHandlers('edit');
                        $('#editPropertyModal').modal('show');
                    }
                },
                error: function() {
                    showAlert('Error loading property data!', 'error');
                }
            });
        }
            function updateProperty(e) {
            e.preventDefault();
            e.stopPropagation();
           
            // Sync TinyMCE content (from previous fix)
            if (tinymce.get('editDescription')) {
                tinymce.get('editDescription').save();
            }
           
            // ENSURE THESE LINES ARE PRESENT & IN ORDER:
            const amenitiesSelect = $('#editPropertyForm .amenities-select');
            const selectedAmenities = amenitiesSelect.val() || []; // <- This defines the variable; fallback to empty array if null/undefined
           
            const imageInput = $('#editPropertyForm input[name="images[]"]')[0];
            imageInput.value = '';
  
            const form = document.getElementById('editPropertyForm');
            const formData = new FormData(form);
           
            const locationInput = formData.get('location_details_input');
            if (locationInput) {
                const locationArray = locationInput.split(',').map(item => item.trim()).filter(item => item);
                formData.append('location_details', JSON.stringify(locationArray));
            }
            formData.delete('location_details_input');
            formData.append('amenities', JSON.stringify(selectedAmenities));
           
            editSelectedImages.forEach(file => formData.append('images[]', file));
           
            const id = $('#editPropertyId').val();
            const submitBtn = $('#editSubmitBtn');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
           
            formData.append('_method', 'PUT');
           
            $.ajax({
                url: "/properties/" + id,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        $('#editPropertyModal').modal('hide');
                        loadProperties();
                        showAlert(response.message, 'success');
                        editSelectedImages = [];
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
               error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('#editPropertyForm .is-invalid').removeClass('is-invalid');
                    $('#editPropertyForm .invalid-feedback').text('').hide();
                    let errorMessages = [];
                    for (const field in errors) {
                        const cleanField = field.replace(/\.\d+$/, '[]');

                        const inputField = $(`#editPropertyForm [name="${cleanField}"]`);

                        if (inputField.length) {
                            inputField.addClass('is-invalid');

                            let feedback = inputField.next('.invalid-feedback');
                            if (!feedback.length) {
                                feedback = inputField.parent().find('.invalid-feedback');
                            }

                            feedback.text(errors[field][0]).show();
                        }

                        errorMessages.push(errors[field][0]);
                    }
                    showAlert(errorMessages.join('<br>'), 'error');

                } else {
                    showAlert(
                        'Error updating property: ' +
                        (xhr.responseJSON?.message || error),
                        'error'
                    );
                }
            },
            complete: function () {
                submitBtn.prop('disabled', false).html(originalText);
            }
            });
        }
        function deleteImage(propertyId, imagePath) {
            if (!confirm('Are you sure you want to delete this image?')) return;
           
            $.ajax({
                url: "/properties/delete-image/" + propertyId,
                type: "POST",
                data: {
                    image_path: imagePath,
                    _token: csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        editProperty(propertyId);
                        showAlert(response.message, 'success');
                    } else {
                        showAlert(response.message, 'error');
                    }
                },
                error: function() {
                    showAlert('Error deleting image!', 'error');
                }
            });
        }
        // Delete Property
        $(document).on('click', '.delete-property', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the property permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
               background: 'rgb(255 249 247)',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/properties/" + id,
                        type: "DELETE",
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                        success: function(response) {
                            if (response.success) {
                                loadProperties();
                                showAlert(response.message, 'success');
                            } else {
                                showAlert(response.message, 'error');
                            }
                        },
                        error: function() {
                            showAlert('Error deleting property!', 'error');
                        }
                    });
                }
            });
        });
       
        $('#addPropertyModal, #editPropertyModal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').hide();
            if ($(this).attr('id') === 'addPropertyModal') {
                currentAddStep = 1;
                addSelectedImages = [];
                $('#addImagePreviews').empty();
                $('#addFloorPlanPreview').empty();
                $('#currentaddlogo').empty();
                if (tinymce.get('description')) tinymce.get('description').setContent('');
            } else {
                currentEditStep = 1;
                editSelectedImages = [];
                $('#newImagePreviews').empty();
                $('#editFloorPlanPreview').empty();
                $('#editlogoPreview').empty();
                if (tinymce.get('editDescription')) tinymce.get('editDescription').setContent('');
            }
        });
        function setupImagePreviews() {
            // Add modal
            $('#addPropertyModal input[name="images[]"]').off('change').change(function(e) {
                const files = Array.from(e.target.files);
                files.forEach(file => {
                    if (addSelectedImages.findIndex(f => f.name === file.name && f.size === file.size) === -1) {
                        addSelectedImages.push(file);
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            const preview = `
                                <div class="position-relative d-inline-block">
                                    <img src="${ev.target.result}" class="img-thumbnail" style="width:80px;height:60px; object-fit:cover;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image"
                                        style="transform:translate(50%,-50%); padding:2px 6px; font-size:12px;"
                                        data-file-name="${file.name}" data-file-size="${file.size}">×</button>
                                </div>
                            `;
                            $('#addImagePreviews').append(preview);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
            $(document).on('click', '#addPropertyModal .remove-image', function() {
                const name = $(this).data('file-name');
                const size = $(this).data('file-size');
                addSelectedImages = addSelectedImages.filter(f => !(f.name === name && f.size === size));
                $(this).closest('.position-relative').remove();
            });
            // Edit modal
            $('#editPropertyModal input[name="images[]"]').off('change').change(function(e) {
                const files = Array.from(e.target.files);
                files.forEach(file => {
                    if (editSelectedImages.findIndex(f => f.name === file.name && f.size === file.size) === -1) {
                        editSelectedImages.push(file);
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            const preview = `
                                <div class="position-relative d-inline-block">
                                    <img src="${ev.target.result}" class="img-thumbnail" style="width:80px;height:60px; object-fit:cover;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image"
                                        style="transform:translate(50%,-50%); padding:2px 6px; font-size:12px;"
                                        data-file-name="${file.name}" data-file-size="${file.size}">×</button>
                                </div>
                            `;
                            $('#newImagePreviews').append(preview);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
            $(document).on('click', '#editPropertyModal .remove-image', function() {
                const name = $(this).data('file-name');
                const size = $(this).data('file-size');
                editSelectedImages = editSelectedImages.filter(f => !(f.name === name && f.size === size));
                $(this).closest('.position-relative').remove();
            });
        }
        function setupFloorPlanPreviews() {
            // Add modal
            $('#addPropertyModal input[name="floor_plan_image"]').off('change').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#addFloorPlanPreview').html(`<img src="${ev.target.result}" class="img-thumbnail" style="max-width:70px; height:auto;">`);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#addFloorPlanPreview').empty();
                }
            });
             $('#addPropertyModal input[name="logo"]').off('change').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#currentaddlogo').html(`<img src="${ev.target.result}" class="img-thumbnail" style="max-width:70px; height:auto;">`);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#currentaddlogo').empty();
                }
            });
            // Edit modal
            $('#editPropertyModal input[name="floor_plan_image"]').off('change').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#editFloorPlanPreview').html(`<img src="${ev.target.result}" class="img-thumbnail" style="max-width:70px; height:auto;">`);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#editFloorPlanPreview').empty();
                }
            });
             $('#editPropertyModal input[name="logo"]').off('change').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#editlogoPreview').html(`<img src="${ev.target.result}" class="img-thumbnail" style="max-width:100px; height:auto;">`);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#editlogoPreview').empty();
                }
            });
        }

        // Merged loadProperties (with allProperties and smart search)
        function loadProperties() {
            $('#propertiesLoading').show();
            $.ajax({
                url: "/properties/list",
                type: "GET",
                success: function(response) {
                    $('#propertiesLoading').hide();
                    if (response.success) {
                        allProperties = response.data; // Set for smart search
                        propertiesTable.clear().rows.add(allProperties).draw();
                        setupSmartSearch(); // Init smart search
                    } else {
                        propertiesTable.clear().draw();
                    }
                },
                error: function() {
                    $('#propertiesLoading').hide();
                    showAlert('Error loading properties!', 'error');
                }
            });
        }
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable('#propertiesTable')) {
                $('#propertiesTable').DataTable().destroy();
            }
            propertiesTable = $('#propertiesTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: false,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search in table..."
                },
                columns: [
                    { data: 'id' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.project ? row.project.title : 'No Project';
                        }
                    },
                    {
                        data: 'images',
                        orderable: false,
                        render: function(data) {
                            if (!data || data === 'null') return '<span class="text-muted">No Image</span>';
                            try {
                                const images = typeof data === 'string' ? JSON.parse(data) : data;
                                if (images && images.length > 0) {
                                    const img = images[0];
                                    const cleanPath = img.replace(/^public\//, '');
                                    return `<img src="/storage/${cleanPath}" class="property-image rounded" style="width:60px;height:50px;object-fit:cover;" onerror="this.src='/images/no-image.jpg'">`;
                                }
                            } catch (e) {}
                            return '<span class="text-muted">No Image</span>';
                        }
                    },
                    { data: 'title' },
                    { data: 'building_name' },
                    {
                        data: 'price',
                        render: function(data) {
                            return '₹ ' + parseFloat(data || 0).toLocaleString('en-IN');
                        }
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            const badge = data === 'Ready To Move' ? 'bg-success' :
                                        data === 'Under Construction' ? 'bg-warning' : 'bg-info';
                            return `<span class="badge ${badge}">${data}</span>`;
                        }
                    },
                    { // Video column - UPDATED: Uploaded badge + Replace button
                        data: 'video_url',
                        orderable: false,
                        render: function(data, type, row) {
                            if (data && data.trim() !== '') {
                                return `
                                    <span class="badge bg-success me-1">Uploaded</span>
                                    <button class="btn btn-sm btn-warning" onclick="openVideoUploadModal(${row.id}, '${escapeHtml(row.title || row.building_name)}')" title="Replace Video">
                                        <i class="bi bi-arrow-repeat"></i> Replace
                                    </button>
                                `;
                            } else {
                                return `<button class="btn btn-sm btn-outline-success" onclick="openVideoUploadModal(${row.id}, '${escapeHtml(row.title || row.building_name)}')">Upload Video</button>`;
                            }
                        },
                        width: "12%"
                    },
                    {  
                        data: 'property_listing_status',
                        orderable: false,
                        render: function(data, type, row) {
                            let badge = '';
                            if (data) {
                                badge = `<span class="badge bg-success ms-2">${ucwords(data.replace(/_/g, ' '))}</span>`;
                            } else {
                                badge = `<span class="badge bg-secondary ms-2">None</span>`;
                            }
                            return `
                                <button class="btn btn-sm btn-outline-primary" 
                                        onclick="openListingModal(${row.id}, '${data || 'none'}')">
                                    Set Listing
                                </button>
                                ${badge}
                            `;
                        },
                        width: "12%"
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-success me-1" onclick="editProperty(${row.id})" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-property" data-id="${row.id}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ]
            });
        }

        // Video Upload Functions
        function openVideoUploadModal(id, propertyTitle) {
            currentVideoPropertyId = id;
            $('#videoPropertyId').val(id);
            $('#videoUploadForm')[0].reset();
            $('.progress').hide().find('.progress-bar').css('width', '0%').text('0%');
            $('#videoUploadStatus').hide();
            $('#videoUploadModal .modal-title').text(`Upload Video for: ${propertyTitle}`);
            $('#videoUploadModal').modal('show');
        }

        function setupVideoUpload() {
            $('#videoUploadForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('_token', csrfToken);

                const submitBtn = $('#videoSubmitBtn');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');

                const xhr = new XMLHttpRequest();
                xhr.open('POST', `/properties/${currentVideoPropertyId}/upload-video`);
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        $('.progress').show();
                        $('.progress-bar').css('width', percent + '%').text(percent + '%');
                    }
                });

                xhr.onload = function() {
                    if (xhr.status === 200 || xhr.status === 201) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                $('#videoUploadModal').modal('hide');
                                loadProperties(); 
                                showAlert(response.message, 'success');
                            } else {
                                throw new Error(response.message || 'Upload failed');
                            }
                        } catch (err) {
                            showAlert('Upload failed: ' + err.message, 'error');
                        }
                    } else {
                        let errorMsg = 'Upload failed. Please try again.';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) errorMsg = response.message;
                        } catch (e) {}
                        showAlert(errorMsg, 'error');
                    }
                    submitBtn.prop('disabled', false).html(originalText);
                    $('.progress').hide();
                };

                xhr.onerror = function() {
                    showAlert('Network error during upload. Please check your connection.', 'error');
                    submitBtn.prop('disabled', false).html(originalText);
                    $('.progress').hide();
                };

                xhr.send(formData);
            });
        }

        // Smart Search (unchanged, but now called in merged loadProperties)
        function setupSmartSearch() {
            const $input = $('#smartSearch');
            const $dropdown = $('#searchSuggestions');
            $input.on('click focus', function () {
                const query = $input.val().trim();
                if (query === '') {
                    showAllSuggestions();
                }
            });
            $input.on('input', function () {
                const query = $input.val().trim();
                if (query === '') {
                    propertiesTable.clear().rows.add(allProperties).draw();
                    showAllSuggestions();
                    return;
                }
                const lowerQuery = query.toLowerCase();
                const matched = allProperties
                    .map(prop => {
                        const title = (prop.title || '').toLowerCase();
                        const building = (prop.building_name || '').toLowerCase();
                        const id = (prop.property_id || '').toLowerCase();
                        const price = (prop.price || '').toString();
                        const locations = extractLocations(prop.location_details).join(' ').toLowerCase();
                        let score = 0;
                        if (title.startsWith(lowerQuery)) score += 200;
                        else if (title.includes(lowerQuery)) score += 100;
                        if (building.startsWith(lowerQuery)) score += 180;
                        else if (building.includes(lowerQuery)) score += 90;
                        if (id.startsWith(lowerQuery)) score += 150;
                        else if (id.includes(lowerQuery)) score += 80;
                        if (locations.includes(lowerQuery)) score += 50;
                        if (price.includes(lowerQuery.replace(/[^0-9]/g, ''))) score += 30;
                        return { prop, score };
                    })
                    .filter(item => item.score > 0)
                    .sort((a, b) => b.score - a.score)
                    .slice(0, 20)
                    .map(item => item.prop);
                propertiesTable.clear().rows.add(matched.length > 0 ? matched : []).draw();
                if (matched.length === 0) {
                    $dropdown.html(`<div class="p-2 text-center text-muted small">No results found for "<strong>${escapeHtml(query)}</strong>"</div>`).show();
                } else {
                    showSuggestions(matched, lowerQuery);
                }
            });
            $(document).on('click', function (e) {
                if (!$(e.target).closest('#smartSearch, #searchSuggestions').length) {
                    $dropdown.hide();
                }
            });
            function showAllSuggestions() {
                if (allProperties.length === 0) {
                    $dropdown.html('<div class="p-2 text-center text-muted small">No properties available</div>').show();
                    return;
                }
                $dropdown.html('<div class="p-2 text-center text-muted small">Click any property to filter</div>');
                showSuggestions(allProperties);
            }
            function showSuggestions(properties, highlightQuery = '') {
                let html = '';
                properties.slice(0, 20).forEach(prop => {
                    const locations = extractLocations(prop.location_details);
                    const locText = locations.length > 0 ? locations.slice(0, 2).join(', ') : 'No location';
                    const highlight = (text) => {
                        if (!text || !highlightQuery) return escapeHtml(text || '');
                        const regex = new RegExp(`(${highlightQuery.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                        return escapeHtml(text).replace(regex, '<strong class="onsearchingcolor fw-bold">$1</strong>');
                    };
                    const title = highlight(prop.title || 'Untitled');
                    const building = prop.building_name ? `<small class="text-muted d-block">${highlight(prop.building_name)}</small>` : '';
                    html += `
                        <div class="p-2 border-bottom hover-bg-light cursor-pointer search-suggestion-item"
                             onclick="selectProperty(${prop.id})">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-P2GH-main" style="font-size: 13px;">${title}</div>
                                    ${building}
                                    <small class="text-muted">ID: ${highlight(prop.property_id || '-')}</small>
                                    <span class="text-P2GH ms-2 fw-bold">₹${Number(prop.price).toLocaleString('en-IN')}</span>
                                </div>
                                <div class="text-end small text-muted text-nowrap ms-3">
                                    <div>${prop.type || 'N/A'} • ${prop.bedrooms || '?'} BHK</div>
                                    <div class="text-success mt-1" style="font-size:11px;">${escapeHtml(locText)}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $dropdown.html(html).show();
            }
            function extractLocations(data) {
                if (!data) return [];
                try {
                    const parsed = typeof data === 'string' ? JSON.parse(data) : data;
                    return Array.isArray(parsed) ? parsed : [];
                } catch (e) {
                    return [];
                }
            }
            window.selectProperty = function (id) {
                const property = allProperties.find(p => p.id === id);
                if (property) {
                    $input.val(property.title);
                    $dropdown.hide();
                    propertiesTable.clear().rows.add([property]).draw();
                }
            };
        }


        let currentListingPropertyId = null;

        function openListingModal(id, currentStatus) {
            currentListingPropertyId = id;
            $('#listingSelect').val(currentStatus);
            $('#listingModal').modal('show');
        }

        $('#saveListingBtn').click(function() {
            const selectedStatus = $('#listingSelect').val();
            $.ajax({
                url: `/properties/update-front-status/${currentListingPropertyId}`,
                type: 'POST',
                data: JSON.stringify({ status: selectedStatus }),
                contentType: 'application/json',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                success: function(response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        loadProperties();  // Reload table to update badges
                        $('#listingModal').modal('hide');
                    } else {
                        showAlert('Error updating status!', 'error');
                    }
                },
                error: function() {
                    showAlert('Error updating status!', 'error');
                }
            });
        });

        // Helper function for ucwords
        function ucwords(str) {
            return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
        }

    </script>
    <script>
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
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
@endpush