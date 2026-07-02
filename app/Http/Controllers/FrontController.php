<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Faq;
use App\Models\HeroBanner;
use App\Models\WhyChooseUsSection;
use App\Models\ProgressCounter;
use App\Models\Testimonial;
use App\Models\AboutSection;
use App\Models\Service;
use App\Models\CtaSection;
use App\Models\ProcessStep;
use App\Models\Interest;
use App\Models\Consult;
use App\Models\Budget;
use App\Models\Resume;
use App\Models\Project;
use App\Models\GalleryCategory;
use App\Models\VideoCategory;
use App\Models\FaqSectionSettings;
use App\Mail\ConsultSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    // ─── HOME PAGE ────────────────────────────────────────────────
    public function Homepageloaded()
    {
        // Blogs
        $blogs = Blog::where('status', 'active')
            ->orderBy('publish_date', 'desc')
            ->limit(3)->get();

        // Hero Banner
        $hero = HeroBanner::first();

        // Homepage Services (latest 8 active)
        $indexservices = Service::where('status', 'active')->latest()->limit(8)->get();

        // About section
        $aboutsection = AboutSection::first();

        // CTA section
        $cta = CtaSection::first();

        // Why Choose Us (single row with features JSON)
        $whyChooseUsSections = WhyChooseUsSection::latest()->get();

        // Testimonials
        $testimonials = Testimonial::where('active', true)->orderBy('sort_order')->get();

        // Progress Counters (hero stats)
        $progressCounters = ProgressCounter::orderBy('sort_order')->get();

        // Process Steps
        $processSteps = ProcessStep::active()->get();

        // FAQs
        $faqs = Faq::active()->get();
        $faqSection = FaqSectionSettings::first();

        return view('front.index', compact(
            'blogs',
            'hero',
            'indexservices',
            'aboutsection',
            'cta',
            'whyChooseUsSections',
            'testimonials',
            'progressCounters',
            'processSteps',
            'faqs',
            'faqSection'
        ));
    }

    // ─── ABOUT PAGE ───────────────────────────────────────────────
    public function aboutPage()
    {
        $aboutsection        = AboutSection::first();
        $whyChooseUsSections = WhyChooseUsSection::latest()->get();
        $progressCounters    = ProgressCounter::orderBy('sort_order')->get();
        $cta                 = CtaSection::first();
        $faqs                = Faq::active()->get();
        $faqSection          = FaqSectionSettings::first();

        return view('front.about', compact('aboutsection', 'whyChooseUsSections', 'progressCounters', 'cta', 'faqs', 'faqSection'));
    }

    // ─── SERVICES PAGE ────────────────────────────────────────────
    public function servicesPage()
    {
        $services = Service::where('status', 'active')->orderBy('name')->get();
        return view('front.services', compact('services'));
    }

    // ─── SERVICE DETAIL ───────────────────────────────────────────
    public function serviceDetail($slug)
    {
        $service  = Service::where('slug', $slug)->firstOrFail();
        $services = Service::where('status', 'active')->orderBy('name')->get();
        return view('front.service-detail', compact('service', 'services'));
    }

    // ─── BLOGS LIST ───────────────────────────────────────────────
    public function frontendIndexblogss()
    {
        $blogs = Blog::where('status', 'active')
            ->orderBy('publish_date', 'desc')
            ->paginate(9);
        return view('front.blogs', compact('blogs'));
    }

    // ─── BLOG DETAIL ─────────────────────────────────────────────
    public function showDetailsa_of_blogs($slug)
    {
        $blog        = Blog::where('slug', $slug)->where('status', 'active')->firstOrFail();
        $recentBlogs = Blog::where('status', 'active')
            ->where('id', '!=', $blog->id)
            ->latest('publish_date')->take(5)->get();
        return view('front.blog-detail', compact('blog', 'recentBlogs'));
    }

    // ─── GALLERY ─────────────────────────────────────────────────
    public function galleryload()
    {
        $categories = GalleryCategory::active()
            ->with(['images' => function ($q) {
                $q->active()->orderBy('sort_order');
            }])
            ->whereHas('images', function ($q) {
                $q->active();
            })
            ->orderBy('sort_order')
            ->get();

        return view('front.gallery', compact('categories'));
    }

    // ─── VIDEO PAGE ───────────────────────────────────────────────
    public function videoPage()
    {
        $categories = VideoCategory::active()
            ->with(['videos' => function ($q) {
                $q->active()->orderBy('sort_order');
            }])
            ->whereHas('videos', function ($q) {
                $q->active();
            })
            ->orderBy('sort_order')
            ->get();

        return view('front.video', compact('categories'));
    }

    // ─── CONTACT PAGE ─────────────────────────────────────────────
    // (handled by ContactController — kept for reference)

    // ─── STORE CONSULT FORM ───────────────────────────────────────
    public function storeconsultform(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|min:10',
            'interests' => 'required|array',
            'budget'    => 'required',
        ]);

        $consult = Consult::create([
            'name'      => strip_tags($request->name),
            'phone'     => strip_tags($request->phone),
            'interests' => $request->interests,
            'budget'    => $request->budget,
        ]);

        Mail::to('aksinger70806307@gmail.com')->send(new ConsultSubmitted($consult));

        return response()->json(['success' => true, 'message' => 'Inquiry submitted!', 'id' => $consult->id], 201);
    }

    // ─── STORE RESUME ─────────────────────────────────────────────
    public function storeresume(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required|string',
            'position'  => 'required|string',
            'resume'    => 'required|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->hasFile('resume')
            ? $request->file('resume')->store('resumes', 'public')
            : null;

        Resume::create([
            'full_name'   => $request->full_name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'position'    => $request->position,
            'resume_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Resume submitted successfully!');
    }

    // ─── AJAX HELPERS ─────────────────────────────────────────────
    public function intrestsload()
    {
        return response()->json(Interest::select('id', 'name')->get());
    }

    public function budgetsload()
    {
        return response()->json(Budget::select('id', 'budgetname as label')->get());
    }

    // ─── PROJECTS (legacy) ────────────────────────────────────────
    public function projectsload()
    {
        $projects = Project::where('status', 'active')->withCount('properties')->get();
        return view('front.projects', compact('projects'));
    }
}