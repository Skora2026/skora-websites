<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ContactPropertyController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProcessStepController;
use App\Http\Controllers\GalleryCategoryController;
use App\Http\Controllers\GalleryImageController;
use App\Http\Controllers\VideoCategoryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CampController;

/* ───────────────────────────────────────────────
   PUBLIC ROUTES
─────────────────────────────────────────────── */
Route::get('/',          [FrontController::class, 'Homepageloaded'])->name('home');
Route::get('/about-us',  [FrontController::class, 'aboutPage'])->name('about');
Route::get('/services',  [FrontController::class, 'servicesPage'])->name('services');
Route::get('/service-details/{slug}', [FrontController::class, 'serviceDetail'])->name('service.detail');
Route::get('/blogs',     [FrontController::class, 'frontendIndexblogss'])->name('blogs.index');
Route::get('/blog-details/{slug}', [FrontController::class, 'showDetailsa_of_blogs'])->name('blog.show');
Route::get('/gallery',   [FrontController::class, 'galleryload'])->name('gallery');
Route::get('/video',     [FrontController::class, 'videoPage'])->name('video');
Route::get('/camps',     [CampController::class, 'index'])->name('camps');

Route::match(['get','post'], '/contact-us', [ContactController::class, 'index'])->name('contact-us');
Route::post('/contact',  [ContactController::class, 'store'])->name('contact.store');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::post('/appointments/save', [AppointmentController::class, 'save'])->name('admin.appointments.save');
Route::post('/save-consultation', [FrontController::class, 'storeconsultform'])->name('save-consult');
Route::post('/submit-resume',     [FrontController::class, 'storeresume'])->name('submit.resume');

Route::get('/get-interests', [FrontController::class, 'intrestsload']);
Route::get('/get-budgets',   [FrontController::class, 'budgetsload']);

Route::get('logout', [LoginController::class, 'logout'])->name('mylogout');
Route::get('/register', fn() => abort(404))->name('register');

/* ───────────────────────────────────────────────
   ADMIN ROUTES
─────────────────────────────────────────────── */
Route::middleware(['auth:sanctum', 'verified', 'role:admin'])->group(function () {

    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::redirect('/dashboard', '/admin-dashboard')->name('dashboard');

    // Profile
    Route::get('/manage-profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('/profile',        [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',      [ProfileController::class, 'update'])->name('profile.update');

    // Consults
    Route::get('/manage-consults',   [AdminController::class, 'showconsultform'])->name('admin.showconsultform');
    Route::get('/consults/get',      [AdminController::class, 'getConsults'])->name('admin.consults.get');
    Route::get('admin/consults/{id}',[AdminController::class, 'show'])->name('admin.show');
    Route::delete('admin/consults/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Contacts
    Route::get('/show-contacts',         [ContactController::class, 'Showadmincontact'])->name('showcontactform');
    Route::get('/admin/contacts/get',    [ContactController::class, 'getContacts'])->name('admin.contacts.get');
    Route::get('contacts/{id}',          [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}',      [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts-bulk-delete', [ContactController::class, 'bulkDeleteContact'])->name('admin.contacts.bulk-delete');

    // Appointments
    Route::get('/appointments',              [AppointmentController::class, 'index'])->name('admin.appointments');
    Route::get('/appointments/get',          [AppointmentController::class, 'getAppointments'])->name('admin.appointments.get');
    Route::post('/appointments/store',       [AppointmentController::class, 'store_to_admin'])->name('admin.appointments.store');
    Route::post('/appointments/update/{id}', [AppointmentController::class, 'update'])->name('admin.appointments.update');
    Route::delete('/appointments/delete/{id}', [AppointmentController::class, 'delete'])->name('admin.appointments.delete');
    Route::post('/appointments/bulk-delete', [AppointmentController::class, 'bulkDelete'])->name('admin.appointments.bulk-delete');

    // Blogs
    Route::get('/manage-blogs',         [BlogController::class, 'showblogs'])->name('admin.manage-blogs');
    Route::get('/admin/blogs/get',      [BlogController::class, 'get'])->name('admin.blogs.get');
    Route::post('/admin/blogs',         [BlogController::class, 'store'])->name('admin.blogs.store');
    Route::put('/admin/blogs/{id}',     [BlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/admin/blogs/{id}',  [BlogController::class, 'destroy'])->name('admin.blogs.destroy');
    Route::get('/admin/blogs/categories', [BlogController::class, 'getCategories'])->name('admin.blogs.getCategories');
    Route::get('/admin/blogs/search',   [BlogController::class, 'search'])->name('admin.blogs.search');

    // Testimonials
    Route::get('/manage-testimonials',     [TestimonialController::class, 'index'])->name('admin.testimonials');
    Route::get('/testimonials-data',       [TestimonialController::class, 'getData'])->name('admin.testimonials.data');
    Route::post('/admin/testimonials',     [TestimonialController::class, 'store'])->name('admin.testimonials.store');
    Route::post('/admin/testimonials/{id}',[TestimonialController::class, 'update'])->name('admin.testimonials.update');
    Route::delete('/admin/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');
    Route::post('/testimonials/reorder',   [TestimonialController::class, 'reorder'])->name('admin.testimonials.reorder');
    Route::post('/testimonials/background',[TestimonialController::class, 'updateBackground'])->name('admin.testimonials.background');

    // Company Settings
    Route::get('/manage-company-settings',  [CompanySettingController::class, 'index'])->name('admin.company-settings');
    Route::get('/get-company-settings',     [CompanySettingController::class, 'getSettings'])->name('admin.company-settings.get');
    Route::post('/update-company-settings', [CompanySettingController::class, 'update'])->name('admin.company-settings.update');

    // Progress Counters
    Route::get('/manage-progress-counters',       [MasterController::class, 'showProgressCounters'])->name('admin.progresscounter');
    Route::get('/get-progress-counters',          [MasterController::class, 'getCounters'])->name('admin.progress-counters.get');
    Route::post('/save-progress-counter',         [MasterController::class, 'storecounter'])->name('admin.progress-counters.save');
    Route::post('/update-progress-counter/{id}',  [MasterController::class, 'updatecounter'])->name('admin.progress-counters.update');
    Route::delete('/delete-progress-counter/{id}',[MasterController::class, 'destroycounter'])->name('admin.progress-counters.delete');

    // Hero Banner
    Route::get('/manage-hero-banners',  [MasterController::class, 'showHeroBanners'])->name('admin.showherobanners');
    Route::get('/get-hero-banners',     [MasterController::class, 'getBanners'])->name('admin.herobanners.get');
    Route::post('/update-hero-banner',  [MasterController::class, 'updateherobanner'])->name('admin.herobanners.update');

    // About Section
    Route::get('/manage-about-section',  [MasterController::class, 'homeaboutsection'])->name('admin.homeaboutsection');
    Route::get('/get-about-section',     [MasterController::class, 'getAbout'])->name('admin.about.get');
    Route::post('/update-about-section', [MasterController::class, 'updatehomeaboutsection'])->name('admin.about.update');

    // CTA Section
    Route::get('/manage-cta-section',  [MasterController::class, 'showcta'])->name('admin.tagline-cta');
    Route::get('/get-cta-section',     [MasterController::class, 'getCta'])->name('admin.cta.get');
    Route::post('/update-cta-section', [MasterController::class, 'updatetagline'])->name('admin.cta.update');

    // Why Choose Us
    Route::get('/manage-why-choose-us',  [MasterController::class, 'showwhychooseus'])->name('admin.whychooseus');
    Route::get('/get-why-choose-us',     [MasterController::class, 'getSection'])->name('admin.whychooseus.get');
    Route::post('/update-why-choose-us', [MasterController::class, 'updateshowwhychooseus'])->name('admin.whychooseus.update');

    // Gallery (Categories + Images)
    Route::get('/admin/gallery-categories',                [GalleryCategoryController::class, 'index'])->name('admin.gallery-categories.index');
    Route::get('/admin/gallery-categories/get',             [GalleryCategoryController::class, 'getCategories'])->name('admin.gallery-categories.get');
    Route::post('/admin/gallery-categories/store',          [GalleryCategoryController::class, 'store'])->name('admin.gallery-categories.store');
    Route::post('/admin/gallery-categories/update/{id}',    [GalleryCategoryController::class, 'update'])->name('admin.gallery-categories.update');
    Route::delete('/admin/gallery-categories/destroy/{id}', [GalleryCategoryController::class, 'destroy'])->name('admin.gallery-categories.destroy');

    Route::get('/admin/gallery-images',                [GalleryImageController::class, 'index'])->name('admin.gallery-images.index');
    Route::get('/admin/gallery-images/get',             [GalleryImageController::class, 'getImages'])->name('admin.gallery-images.get');
    Route::post('/admin/gallery-images/store',          [GalleryImageController::class, 'store'])->name('admin.gallery-images.store');
    Route::put('/admin/gallery-images/update/{id}',     [GalleryImageController::class, 'update'])->name('admin.gallery-images.update');
    Route::delete('/admin/gallery-images/destroy/{id}', [GalleryImageController::class, 'destroy'])->name('admin.gallery-images.destroy');
    Route::post('/admin/gallery-images/reorder',        [GalleryImageController::class, 'reorder'])->name('admin.gallery-images.reorder');

    // Videos (Categories + Videos)
    Route::get('/admin/video-categories',                [VideoCategoryController::class, 'index'])->name('admin.video-categories.index');
    Route::get('/admin/video-categories/get',             [VideoCategoryController::class, 'getCategories'])->name('admin.video-categories.get');
    Route::post('/admin/video-categories/store',          [VideoCategoryController::class, 'store'])->name('admin.video-categories.store');
    Route::post('/admin/video-categories/update/{id}',    [VideoCategoryController::class, 'update'])->name('admin.video-categories.update');
    Route::delete('/admin/video-categories/destroy/{id}', [VideoCategoryController::class, 'destroy'])->name('admin.video-categories.destroy');

    Route::get('/admin/videos',                [VideoController::class, 'index'])->name('admin.videos.index');
    Route::get('/admin/videos/get',             [VideoController::class, 'getVideos'])->name('admin.videos.get');
    Route::post('/admin/videos/store',          [VideoController::class, 'store'])->name('admin.videos.store');
    Route::put('/admin/videos/update/{id}',     [VideoController::class, 'update'])->name('admin.videos.update');
    Route::delete('/admin/videos/destroy/{id}', [VideoController::class, 'destroy'])->name('admin.videos.destroy');

    // Managers
    Route::get('/manage-managers',        [MasterController::class, 'ShowManagers'])->name('admin.manage-managers');
    Route::get('/get-managers',           [MasterController::class, 'getManagers'])->name('admin.managers.get');
    Route::post('/save-managers',         [MasterController::class, 'savemanagers'])->name('admin.managers.save');
    Route::post('/update-managers/{id}',  [MasterController::class, 'updateManagers'])->name('admin.managers.update');
    Route::delete('/delete-managers/{id}',[MasterController::class, 'deleteManagers'])->name('admin.managers.delete');

    // Point of Contact
    Route::get('/manage-pointofcontact',        [MasterController::class, 'ShowPointOfContact'])->name('admin.manage-pointofcontact');
    Route::get('/get-pointofcontact',           [MasterController::class, 'getPointOfContact'])->name('admin.pointofcontact.get');
    Route::post('/save-pointofcontact',         [MasterController::class, 'savePointOfContact'])->name('admin.pointofcontact.save');
    Route::post('/update-pointofcontact/{id}',  [MasterController::class, 'updatePointOfContact'])->name('admin.pointofcontact.update');
    Route::delete('/delete-pointofcontact/{id}',[MasterController::class, 'deletePointOfContact'])->name('admin.pointofcontact.delete');

    // Resumes
    Route::get('/manage-resumes',         [MasterController::class, 'showManageresume'])->name('admin.resumes');
    Route::get('/get-resumes',            [MasterController::class, 'getResumes'])->name('admin.resumes.get');
    Route::post('/update-resume/{id}',    [MasterController::class, 'updateresume'])->name('admin.resumes.update');
    Route::delete('/delete-resume/{id}',  [MasterController::class, 'destroyresume'])->name('admin.resumes.delete');

    // ── Camps ─────────────────────────────────────────────────────
    Route::get('/manage-camps',    [CampController::class, 'adminIndex'])->name('admin.camps');
    Route::get('/get-camps',       [CampController::class, 'getData'])->name('admin.camps.get');
    Route::post('/save-camp',      [CampController::class, 'store'])->name('admin.camps.store');
    Route::post('/update-camp/{id}', [CampController::class, 'update'])->name('admin.camps.update');
    Route::delete('/delete-camp/{id}', [CampController::class, 'destroy'])->name('admin.camps.destroy');

    Route::post('/camps/bulk-delete',      [CampController::class, 'bulkDelete'])->name('admin.camps.bulk-delete');

    // ── FAQs (NEW) ────────────────────────────────────────────────
    Route::get('/manage-faqs',          [FaqController::class, 'index'])->name('admin.faqs');
    Route::get('/get-faqs',             [FaqController::class, 'getData'])->name('admin.faqs.get');
    Route::post('/save-faq',            [FaqController::class, 'store'])->name('admin.faqs.store');
    Route::post('/update-faq/{id}',     [FaqController::class, 'update'])->name('admin.faqs.update');
    Route::delete('/delete-faq/{id}',   [FaqController::class, 'destroy'])->name('admin.faqs.destroy');
    Route::post('/faqs/reorder',        [FaqController::class, 'reorder'])->name('admin.faqs.reorder');
    Route::get('/get-faq-section',      [FaqController::class, 'getSectionSettings'])->name('admin.faq-section.get');
    Route::post('/update-faq-section',  [FaqController::class, 'updateSectionSettings'])->name('admin.faq-section.update');

    // ── Process Steps (NEW) ───────────────────────────────────────
    Route::get('/manage-process-steps',        [ProcessStepController::class, 'index'])->name('admin.processsteps');
    Route::get('/get-process-steps',           [ProcessStepController::class, 'getData'])->name('admin.processsteps.get');
    Route::post('/save-process-step',          [ProcessStepController::class, 'store'])->name('admin.processsteps.store');
    Route::post('/update-process-step/{id}',   [ProcessStepController::class, 'update'])->name('admin.processsteps.update');
    Route::delete('/delete-process-step/{id}', [ProcessStepController::class, 'destroy'])->name('admin.processsteps.delete');

    // Services & Categories
    Route::prefix('admin')->group(function () {
        Route::get('service-categories',             [ServiceCategoryController::class, 'index'])->name('admin.service-categories.index');
        Route::get('service-categories/get',         [ServiceCategoryController::class, 'getCategories'])->name('admin.service-categories.get');
        Route::post('service-categories/store',      [ServiceCategoryController::class, 'store'])->name('admin.service-categories.store');
        Route::post('service-categories/update/{id}',[ServiceCategoryController::class, 'update'])->name('admin.service-categories.update');
        Route::delete('service-categories/destroy/{id}', [ServiceCategoryController::class, 'destroy'])->name('admin.service-categories.destroy');

        Route::get('services',             [ServiceController::class, 'index'])->name('admin.services.index');
        Route::get('services/get',         [ServiceController::class, 'getServices'])->name('admin.services.get');
        Route::post('services/store',      [ServiceController::class, 'store'])->name('admin.services.store');
        Route::put('services/update/{id}', [ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('services/destroy/{id}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
        Route::get('services/search',      [ServiceController::class, 'search'])->name('admin.services.search');
    });

    // Book Online
    Route::get('/manage-book-online',   [BookController::class, 'onlinebookingdetailsshow'])->name('admin.bookingline');
    Route::get('/get-book-online',      [BookController::class, 'getSection'])->name('admin.bookonline.get');
    Route::post('/update-book-online',  [BookController::class, 'updateonlinebookingdetailsshow'])->name('admin.bookonline.update');

    // Bookings
    Route::get('/manage-booking',               [BookController::class, 'index'])->name('admin.manage-booking-project');
    Route::get('/admin/bookings/data',          [BookController::class, 'getBookingsData'])->name('admin.bookings.data');
    Route::get('/admin/bookings/edit/{id}',     [BookController::class, 'getBooking'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/update/{id}',   [BookController::class, 'update'])->name('admin.bookings.update');
    Route::delete('/admin/bookings/delete/{id}',[BookController::class, 'destroy'])->name('admin.bookings.destroy');
    Route::get('/admin/bookings/export-pdf',    [BookController::class, 'exportPdf'])->name('admin.bookings.export-pdf');

    // Contact Properties
    Route::get('/admin-contacts-get',          [ContactPropertyController::class, 'getContacts'])->name('admin.contactsproperties.get');
    Route::get('/show-contacts-ptoperties',    [ContactPropertyController::class, 'showpage'])->name('showcontactpropertyform');
    Route::post('/contact-front-properties',   [ContactPropertyController::class, 'store'])->name('allcontactproperties.store');

    // Properties
    Route::get('/Manage-Properties',                 [PropertyController::class, 'Showmanageproperties'])->name('managesProperties');
    Route::get('/properties/list',                   [PropertyController::class, 'list'])->name('properties.list');
    Route::post('/properties/store',                 [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{id}',                   [PropertyController::class, 'show'])->name('properties.show');
    Route::put('/properties/{id}',                   [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{id}',                [PropertyController::class, 'destroy'])->name('properties.destroy');
    Route::post('/properties/delete-image/{id}',     [PropertyController::class, 'deleteImage'])->name('properties.delete-image');
    Route::post('/properties/{id}/upload-video',     [PropertyController::class, 'uploadVideo'])->name('properties.uploadVideo');
    Route::post('/properties/update-front-status/{id}', [PropertyController::class, 'updateFrontStatus'])->name('properties.updateFrontStatus');

    // Projects
    Route::get('/manage-Projects',     [ProjectController::class, 'Showmanagepage'])->name('managesProjects');
    Route::get('/get-projects',        [ProjectController::class, 'getProjects'])->name('admin.projects.get');
    Route::post('/save-project',       [ProjectController::class, 'saveProject'])->name('admin.projects.save');
    Route::post('/update-project/{id}',[ProjectController::class, 'updateProject'])->name('admin.projects.update');
    Route::delete('/delete-project/{id}',[ProjectController::class, 'deleteProject'])->name('admin.projects.delete');
});
