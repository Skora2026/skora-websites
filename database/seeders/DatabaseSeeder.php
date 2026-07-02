<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\ProgressCounter;
use App\Models\HeroBanner;
use App\Models\AboutSection;
use App\Models\WhyChooseUsSection;
use App\Models\CtaSection;
use App\Models\Testimonial;
use App\Models\CompanySetting;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\VideoCategory;
use App\Models\Video;
use App\Models\FaqSectionSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ─────────────────────────────────────────────
        if (!User::where('email', 'swatantra.stf003@gmail.com')->exists()) {
            User::create([
                'name'     => 'P2GH Admin',
                'email'    => 'swatantra.stf003@gmail.com',
                'password' => Hash::make('11111111'),
                'role'     => 'admin',
            ]);
        }

        // ── Company Settings ───────────────────────────────────────
        if (!CompanySetting::count()) {
            CompanySetting::create([
                'company_name'        => 'P2GH - 24*7 Physiotherapy',
                'company_short_name'  => 'P2GH',
                'company_tagline'     => 'Expert Physiotherapy Care, Always Available',
                'company_description' => 'P2GH provides expert physiotherapy care round the clock. Our certified therapists help you recover faster, move better, and live pain-free.',
                'company_email1'      => 'info@p2gh.com',
                'company_mobile1'     => '+91 98765 43210',
                'company_whatsapp1'   => '+91 98765 43210',
                'company_address1'    => 'Delhi, India',
                'company_address2'    => 'Ground Floor, XYZ Complex, New Delhi - 110001',
                'facebook'            => '#',
                'instagram'           => '#',
            ]);
        }

        // ── Hero Banner ────────────────────────────────────────────
        if (!HeroBanner::count()) {
            HeroBanner::create([
                'title'     => 'Move Without Pain. Live Without Limits.',
                'move_text' => 'Sports Injury Physiotherapy || Orthopedic Rehabilitation || Post-Surgery Recovery || Neurological Physiotherapy',
                'image'     => null,
            ]);
        }

        // ── About Section ──────────────────────────────────────────
        if (!AboutSection::count()) {
            AboutSection::create([
                'sub_title'   => 'Our Trusted Support',
                'title_line1' => 'Passionate About Providing',
                'title_line2' => 'Expert Care And Healing',
                'description' => 'At P2GH - 24*7 Physiotherapy, our dedicated physiotherapists combine compassionate care, continuous support, and clinical expertise to relieve pain and help patients regain a better quality of life — any time of day or night.',
                'button_text' => 'Know More',
                'button_link' => '/about-us',
                'center_image'=> 'default.jpg',
            ]);
        }

        // ── Why Choose Us ──────────────────────────────────────────
        if (!WhyChooseUsSection::count()) {
            WhyChooseUsSection::create([
                'sub_title'   => 'Why Choose Us',
                'main_title'  => 'Excellence In Care And Rehabilitation',
                'right_image' => 'default.jpg',
                'features'    => [
                    ['title' => 'Experienced Team',         'description' => 'Certified physiotherapists committed to quality care and your complete recovery.', 'icon' => 'people'],
                    ['title' => 'Patient-Centered Approach','description' => 'Every treatment plan is customized around your unique condition and recovery goals.', 'icon' => 'heart-pulse'],
                    ['title' => 'Advanced Technology',      'description' => 'Modern diagnostic tools and treatment equipment for precise, effective therapy.', 'icon' => 'cpu'],
                    ['title' => '24x7 Availability',        'description' => 'We are here whenever you need us — day or night, always on call for your recovery.', 'icon' => 'clock'],
                ],
            ]);
        }

        // ── CTA Section ────────────────────────────────────────────
        if (!CtaSection::count()) {
            CtaSection::create([
                'heading'          => 'Ready To Start Your Recovery Journey?',
                'description'      => 'Book your initial consultation today — 24x7 appointments available.',
                'button_text'      => 'Book Appointment',
                'button_link'      => '#',
                'background_image' => 'default.jpg',
            ]);
        }

        // ── Testimonials ───────────────────────────────────────────
        if (!Testimonial::count()) {
            $testimonials = [
                ['client_name' => 'Rahul Sharma',   'rating' => 5, 'message' => 'P2GH transformed my life! After my knee surgery, I thought I would never walk normally again. Their expert therapists helped me recover completely within 3 months.', 'sort_order' => 1],
                ['client_name' => 'Priya Verma',    'rating' => 5, 'message' => 'The 24x7 availability is a game changer. I had severe back pain at midnight and they were there to help immediately. Truly outstanding service!', 'sort_order' => 2],
                ['client_name' => 'Amit Singh',     'rating' => 5, 'message' => 'Highly professional team. My sports injury was treated with the latest techniques and I was back on the field in record time. Highly recommended!', 'sort_order' => 3],
                ['client_name' => 'Sunita Gupta',   'rating' => 5, 'message' => 'Dr. Nikky and her team are exceptional. My cervical pain of 5 years was resolved in just 8 sessions. The personalized care they provide is unmatched.', 'sort_order' => 4],
                ['client_name' => 'Vikram Malhotra', 'rating' => 5, 'message' => 'Best physiotherapy clinic in Delhi. The equipment is modern, staff is friendly and the results speak for themselves. Very happy with my recovery!', 'sort_order' => 5],
            ];
            foreach ($testimonials as $t) {
                Testimonial::create(array_merge($t, ['active' => true]));
            }
        }

        // ── Progress Counters ──────────────────────────────────────
        if (!ProgressCounter::count()) {
            $counters = [
                ['number' => '5000', 'suffix' => '+', 'title' => 'Happy Patients',  'icon' => 'bi-people-fill',  'sort_order' => 1, 'active' => true],
                ['number' => '20',   'suffix' => '+', 'title' => 'Years Experience', 'icon' => 'bi-award-fill',   'sort_order' => 2, 'active' => true],
                ['number' => '50',   'suffix' => '+', 'title' => 'Treatment Types',  'icon' => 'bi-activity',     'sort_order' => 3, 'active' => true],
                ['number' => '98',   'suffix' => '%', 'title' => 'Success Rate',     'icon' => 'bi-star-fill',    'sort_order' => 4, 'active' => true],
            ];
            foreach ($counters as $c) {
                ProgressCounter::create($c);
            }
        }

        // ── Process Steps ──────────────────────────────────────────
        if (!ProcessStep::count()) {
            $steps = [
                ['step_number' => 1, 'title' => 'Book an Appointment',    'description' => 'Schedule your consultation online, by phone, or walk in — available 24x7 for your convenience.', 'icon' => 'bi-calendar-check', 'is_active' => true],
                ['step_number' => 2, 'title' => 'Assessment & Treatment', 'description' => 'Our expert evaluates your condition thoroughly and begins a personalized therapy plan designed specifically for you.', 'icon' => 'bi-clipboard2-pulse', 'is_active' => true],
                ['step_number' => 3, 'title' => 'Recovery & Care',        'description' => 'Follow guided sessions with expert advice to regain strength, mobility, and a permanently pain-free life.', 'icon' => 'bi-heart-pulse', 'is_active' => true],
            ];
            foreach ($steps as $s) {
                ProcessStep::create($s);
            }
        }

        // ── FAQs ───────────────────────────────────────────────────
        if (!Faq::count()) {
            $faqs = [
                [1, 'How can I book a physiotherapy appointment?',       'You can book an appointment online through this website, call us directly, or walk into our clinic. We offer 24x7 scheduling for your convenience.'],
                [2, 'Do I need a doctor\'s referral for physiotherapy?', 'A referral is helpful but not mandatory. You can directly consult our therapists who will professionally assess your condition.'],
                [3, 'What conditions do you treat at P2GH?',             'We treat back pain, neck pain, sports injuries, post-surgery recovery, joint problems, neurological conditions, pediatric conditions, and more.'],
                [4, 'How long does a physiotherapy session take?',       'Each session typically lasts 30 to 60 minutes depending on treatment type and your condition. Your therapist will guide you accordingly.'],
                [5, 'How many sessions will I need?',                    'The number of sessions depends on your condition and recovery goals. We will provide a clear treatment timeline after your initial assessment.'],
                [6, 'Is physiotherapy available 24 hours at P2GH?',     'Yes! P2GH offers 24x7 availability for appointments and emergency consultations. Our on-call team is always ready to assist you.'],
            ];
            foreach ($faqs as [$order, $q, $a]) {
                Faq::create(['question' => $q, 'answer' => $a, 'sort_order' => $order, 'is_active' => true]);
            }
        }

        // ── Gallery Categories (no images by default — admin uploads via panel) ──
        if (!GalleryCategory::count()) {
            $galleryCategories = ['Clinic Interior', 'Equipment', 'Therapy Sessions'];
            foreach ($galleryCategories as $i => $name) {
                GalleryCategory::create(['name' => $name, 'status' => 'active', 'sort_order' => $i + 1]);
            }
        }

        // ── Video Categories (no videos by default — admin adds via panel) ──
        if (!VideoCategory::count()) {
            $videoCategories = ['Patient Stories', 'Treatment Demonstrations'];
            foreach ($videoCategories as $i => $name) {
                VideoCategory::create(['name' => $name, 'status' => 'active', 'sort_order' => $i + 1]);
            }
        }

        // ── FAQ Section Heading ──────────────────────────────────────
        if (!FaqSectionSettings::count()) {
            FaqSectionSettings::create([
                'sub_title' => 'Got Questions?',
                'main_title' => 'Frequently Asked <span>Questions</span>',
            ]);
        }
    }
}