<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ settings('company_short_name', 'P2GH')  }}|| @yield('title') </title>
    <link rel="icon" type="image/png" href="{{ settings('favicon') ? asset('storage/' . settings('favicon')) : asset('assets-front/img-main.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('front_assets/css/style.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="cursor"></div>   
        <div class="cursor-follower"></div>
        <div class="hero-nav">
        <div class="container d-flex justify-content-center">
            <div class="row py-3 w-100">
            <div class="col-6  col-lg-4">
                <div class="menu-toggle" id="menuToggle"><span></span></div>
            </div>
            <div class="col-6 col-lg-4 text-lg-center text-end">
                    <a href="{{ url('/') }}">
                        <img src="{{ settings('light_logo') ? asset('storage/' . settings('light_logo')) 
                            : asset('assets-front/img-main.png') }}" class="nav-logo rounded-circle"
                            width="70" alt="Logo">
                    </a>

            </div>
            <div class="col-6 col-lg-4 d-flex justify-content-end  ">
                <div class="d-none d-lg-block nav-btn">
                <span><a href="{{url('contact-us')}}" class="text-decoration-none"><button class="butt ">
                        Contact Us
                        <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                            clip-rule="evenodd">
                        </path>
                        </svg>
                    </button></a>
                </span>
                </div>

                <div class="d-none d-lg-block nav-btn ms-lg-2">
                <span><a href="" class="book-now-btn" class="text-decoration-none"><button class="butt ">
                        Book Now
                        <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                            clip-rule="evenodd">
                        </path>
                        </svg>
                    </button></a>
                </span>
                </div>

            </div>
            </div>
        </div>
        </div>

        <div class="sidebar " id="sidebar">
        <ul class="nav-menu">
            <li><a href="{{url('/')}}">Home</a></li>
            <li><a href="{{url('about')}}">About Us</a></li>
            <li><a href="{{url('projects')}}">Projects</a></li>
            <li><a href="{{url('gallery')}}">Gallery</a></li>
            <li><a href="{{url('blogs')}}">Blogs</a></li>
            <li><a href="{{url('career')}}">Career</a></li>
        </ul>
        <div class="d-lg-none">
            <span><a href="{{url('contact-us')}}" class="text-decoration-none"><button class="butt ">
                Contact Us
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path
                    fill-rule="evenodd"
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                    clip-rule="evenodd"></path>
                </svg>
                </button></a></span>
        </div>
        <div class="d-lg-none">
            <span><a href="" class="book-now-btn" class="text-decoration-none"><button class="butt ">
                Book Now
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path
                    fill-rule="evenodd"
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                    clip-rule="evenodd"></path>
                </svg>
                </button></a></span>
        </div>
        </div>

        @yield('frontcontent')



  <style>
/* Colors */
:root {
    --gold: #b3ad5b;
    --blue: #2c245a;
    --green: #019443;
}

/* Overlay */
.popup-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999999;
}

/* Popup Box */
.popup-box {
    background: #fff;
    width: 95%;
    max-width: 500px;
    padding: 25px;
    border-radius: 18px;
    position: relative;
    border-top: 6px solid var(--gold);
    animation: popupIn 0.45s ease-out;
    box-shadow: 0 10px 35px rgba(0,0,0,0.25);
}

.popup-box .form-label{
    font-size: 14px;
    font-weight: 700;
}
.popup-box .form-check-label{
    font-size: 14px;
}

/* Popup Title */
.popup-title {
    font-weight: 700;
    color: var(--blue);
    text-align: center;
}

/* Close Button */
.close-btn {
    position: absolute;
    right: 18px;
    top: 12px;
    font-size: 28px;
    cursor: pointer;
    font-weight: bold;
    color: var(--blue);
}

/* Input Fields */
.popup-input {
    border-radius: 10px;
    border: 2px solid #e7e7e7;
    padding: 5px 12px;
    transition: 0.3s;
    font-size: 14px;
}

.popup-input:focus {
    border-color: var(--green);
    box-shadow: 0 0 8px rgba(1,148,67,0.3);
}


/* Animation */
@keyframes popupIn {
    from {
        transform: scale(0.1) translateY(40px);
        opacity: 0;
    }
    to {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
}

</style>

 <div id="interestsLoading" class="spinner-container" style="display: none;">
    <div class="spinner"></div>
</div>



<div class="footer-image-section">
    <img src="{{asset('assets-front/img/footer-bg.jpg')}}" class="footer-image w-100" alt="Footer Image">
    <div class="footer-overlay w-100"></div>
</div>


<footer class="footer-section text-light pt-5 pb-4">
    <div class="container">
        <div class="row gy-5">
            <!-- CONTACT US -->
            <div class="col-lg-3 col-md-6">
                <div class="">
                    <a href="{{url('/')}}"><img src="{{asset('assets-front/img/logo-main.jpg')}}" class="rounded-circle" width="80" alt=""></a>
                    <h5 class="mt-5">{{ settings('company_description', 'P2GH PLANNING SOMETHING ?')  }}</h5>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h4 class="footer-title">NEED HELP</h4>
                <p class="f-text"><a href="{{url('about')}}" class="text-decoration-none text-white">About us</a></p>
                <p class="f-text"><a href="{{url('properties')}}" class="text-decoration-none text-white">Properties</a></p>
                <p class="f-text"><a href="{{url('gallery')}}" class="text-decoration-none text-white">Gallery</a></p>
                <p class="f-text"><a href="{{url('projects')}}" class="text-decoration-none text-white">Projects</a></p>
                <p class="f-text"><a href="{{url('contact-us')}}" class="text-decoration-none text-white">Contact us</a></p>
            </div>

            <div class="col-lg-3 col-md-6">
                <h4 class="footer-title">CONTACT US</h4>
                    <div class=" footer-icon d-flex">
                        <span><i class="bi bi-telephone border  rounded-2 me-2 f-icon"></i></span>
                        <a href="tel:{{ settings('company_mobile1', '1800 203 6768')  }}" class="text-decoration-none text-white">
                           {{ '+91 '. settings('company_mobile1', '1800 203 6768')  }}
                        </a>
                    </div>

                    <div class=" footer-icon d-flex">
                        <span><i class="bi bi-telephone border  rounded-2 me-2 f-icon"></i></span>
                        <a href="tel:{{ settings('company_mobile2', '+91 9810685077')  }}" class="text-decoration-none text-white">
                            {{ '+91 '. settings('company_mobile2', '+91 9810685077')  }}
                        </a>
                    </div>

                    <div class=" footer-icon d-flex">
                        <span><i class="bi bi-envelope border rounded-2 me-2 f-icon"></i></span>
                        <a href="mailto:" class="text-decoration-none text-white">
                           {{ settings('company_email1', '')  }}
                        </a>
                    </div>
                    <div class="footer-icon d-flex">
                        <span><i class="bi bi-geo-alt border rounded-2 me-2  f-icon"></i></span>
                        <a href="" class="text-decoration-none text-white">
                          {{ settings('company_address1', '')  }}
                        </a>
                    </div>
            
            </div>



            <!-- EMAIL -->
            <div class="col-lg-4 col-md-6">
                <h4 class="footer-title">SOCIAL LINKS</h4>

                <ul class="ul-icon example-1 mt-lg-5">
                    <li class="icon-content">
                        <a href="{{ settings('facebook', '')  }}" class="link" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                <path
                                    d="M29.059 15.085C29.058 7.322 22.764 1.028 15 1.028S0.941 7.323 0.941 15.087c0 6.989 5.1 12.787 11.781 13.875l0.081 0.011V19.15H9.232v-4.065h3.57v-3.096a4.962 4.962 0 0 1 5.329 -5.469l-0.017 -0.001c1.124 0.016 2.212 0.115 3.273 0.292l-0.126 -0.018v3.459h-1.774a2.033 2.033 0 0 0 -2.291 2.204l-0.001 -0.008v2.636h3.899l-0.623 4.065h-3.276v9.823c6.762 -1.101 11.862 -6.899 11.863 -13.888"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                        <div class="tooltip">Facebook</div>
                    </li>
                    <li class="icon-content">
                        <a
                            href="{{ settings('instagram', '')  }}"
                            aria-label="Pinterest"
                            data-social="pinterest"
                            class="link">
                            <svg version="1.1" viewBox="0 0 100 100" xml:space="preserve">
                                <path
                                    d="M60 45a15 15 0 1 0 -4.395 10.61A14.4 14.4 0 0 0 60 45.225l-0.004 -0.237zm8.1 0a23.006 23.006 0 1 1 -6.738 -16.347 22.2 22.2 0 0 1 6.742 15.96l-0.004 0.41v-0.02zm6.327 -24.022v0.008a5.4 5.4 0 1 1 -1.582 -3.818 5.177 5.177 0 0 1 1.556 3.705v0.11zm-29.4 -12.9 -4.482 -0.03q-4.072 -0.03 -6.184 0t-5.655 0.176a47.143 47.143 0 0 0 -6.312 0.638l0.273 -0.038a23.571 23.571 0 0 0 -4.362 1.136l0.16 -0.052a15.446 15.446 0 0 0 -8.52 8.452l-0.038 0.102a22.543 22.543 0 0 0 -1.065 4.062l-0.02 0.138a45 45 0 0 0 -0.597 5.96l-0.004 0.08q-0.147 3.548 -0.176 5.655t0 6.184 0.03 4.482 -0.03 4.482 0 6.184 0.176 5.655c0.075 2.193 0.292 4.275 0.638 6.312l-0.038 -0.273a23.571 23.571 0 0 0 1.136 4.362l-0.052 -0.16a15.446 15.446 0 0 0 8.452 8.52l0.102 0.038c1.192 0.446 2.606 0.82 4.062 1.065l0.138 0.02c1.758 0.308 3.84 0.525 5.955 0.597l0.08 0.004q3.548 0.147 5.655 0.176t6.184 0l4.455 -0.09 4.482 0.03q4.072 0.03 6.184 0t5.655 -0.176a47.143 47.143 0 0 0 6.312 -0.638l-0.273 0.038a23.571 23.571 0 0 0 4.362 -1.136l-0.16 0.052a15.446 15.446 0 0 0 8.52 -8.452l0.038 -0.102c0.446 -1.192 0.82 -2.606 1.065 -4.062l0.02 -0.138c0.308 -1.758 0.525 -3.84 0.597 -5.955l0.004 -0.08q0.147 -3.548 0.176 -5.655t0 -6.184 -0.03 -4.482 0.03 -4.482 0 -6.184 -0.176 -5.655a47.143 47.143 0 0 0 -0.638 -6.312l0.038 0.273a23.743 23.743 0 0 0 -1.136 -4.362l0.052 0.16a15.446 15.446 0 0 0 -8.452 -8.52l-0.102 -0.038a22.543 22.543 0 0 0 -4.062 -1.065l-0.138 -0.02a45 45 0 0 0 -5.955 -0.597l-0.08 -0.004q-3.548 -0.147 -5.655 -0.176t-6.184 0zM90 45q0 13.418 -0.3 18.574a24.9 24.9 0 0 1 -26.194 26.13l0.06 0.004q-5.157 0.3 -18.574 0.3t-18.574 -0.3A24.9 24.9 0 0 1 0.286 63.514l-0.004 0.06q-0.3 -5.157 -0.3 -18.574t0.3 -18.574A24.9 24.9 0 0 1 26.478 0.297l-0.058 -0.005q5.157 -0.3 18.574 -0.3t18.574 0.3a24.9 24.9 0 0 1 26.13 26.194l0.004 -0.06Q90 31.578 90 45"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                        <div class="tooltip">Instagram</div>
                    </li>
                    <li class="icon-content">
                        <a
                            href="{{ settings('twitter', '')  }}"
                            aria-label="Dribbble"
                            data-social="dribbble"
                            class="link">
                            <svg version="1.1" viewBox="0 0 100 100">
                                <path
                                    d="M53.564 38.947 87.066 0h-7.941L50.033 33.816 26.801 0H0l35.136 51.137L0 91.977h7.941l30.722 -35.712 24.54 35.712H90L53.561 38.947zM42.686 51.588l-3.56 -5.093L10.8 5.977h12.194l22.86 32.699 3.56 5.093 29.714 42.503H66.935L42.686 51.591z"
                                    fill="currentColor"></path>
                            </svg>
                        </a>
                        <div class="tooltip">Twitter</div>
                    </li>
                    <li class="icon-content">
                        <a
                            href="{{ settings('pintrest', '')  }}"
                            aria-label="YouTube" data-social="youtube" target="_blank"
                            class="link">
                            <svg version="1.1" viewBox="0 0 100 100">
                                <path  d="M86.4 29.1c-0.8-3-3-5.4-6-6.2C72.6 21.6 50 21.6 50 21.6s-22.6 0-30.4 1.3c-3 0.8-5.2 3.2-6 6.2C12 37.1 12 50 12 50s0 12.9 1.6 20.9c0.8 3 3 5.4 6 6.2C27.4 78.4 50 78.4 50 78.4s22.6 0 30.4-1.3c3-0.8 5.2-3.2 6-6.2C88 62.9 88 50 88 50s0-12.9-1.6-20.9zM40.8 65.1V34.9l26.1 15.1L40.8 65.1z"
                                    fill="currentColor"></path> 
                            </svg>
                        </a>
                        <div class="tooltip">YouTube</div>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="mt-5 mb-4" style="border-color: rgba(255,255,255,0.15);">

        <!-- Bottom Row -->
        <div class="row gy-3 align-items-center">
            <div class="col-lg-6 col-md-12 d-flex align-items-center gap-2 justify-content-lg-start justify-content-center">
                <div class="d-flex footer-menu">
                    <div class="me-2 ">
                        <span class="f-text me-2">Refund Policy</span>
                    </div>

                    <a href="{{url('contact-us')}}" class="f-text text-decoration-none">Contact us</a>
                </div>
            </div>

            <div class="col-lg-6 text-lg-end text-center footer-menu">
                <a href="#" class="f-text me-4 text-decoration-none">Privacy Policy</a>
                <a href="#" class="f-text text-decoration-none">Terms and Conditions</a>
            </div>

            <p class="copyright text-center mt-3">
                © Copyright 2025 by {{ settings('company_name', 'P2GH')  }}. All rights reserved || designed by <a href="https://skorasoft.com/" target="_blank" class="text-decoration-none text-white">SkoraSoft</a>.
            </p>
        </div>
    </div>
</footer>


<!-- Modal -->
<!-- ================= POPUP CONSULTATION FORM ================= -->

<div id="consultPopup" class="popup-overlay">
    <div class="popup-box">
        <span class="close-btn" onclick="closePopup()">&times;</span>

        <h3 class="popup-title mb-3">
            <i class="bi bi-chat-dots-fill me-2"></i> Consult with us
        </h3>

        <form id="consultForm">
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-person-fill me-1"></i> Full Name
                </label>
                <input type="text" class="form-control popup-input" name="name" style="opacity: 1; transform: translate(0px, 0px);" placeholder="Enter your name" required>
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-telephone-fill me-1"></i> Phone Number
                </label>
                <input type="text" class="form-control popup-input" name="phone" style="opacity: 1; transform: translate(0px, 0px);" placeholder="Enter your phone number" required minlength="10" maxlength="10">
            </div>

            <!-- Interests -->
            <div class="mb-3">
                <label class="form-label d-block">
                    <i class="bi bi-ui-checks-grid me-1"></i> Interest In
                </label>
                <div id="interests-container">
                </div>
            </div>

            <!-- Budget -->
            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-cash-coin me-1"></i> Budget
                </label>
                <select class="form-select popup-input" name="budget" required>
                    <option value="">Select Budget</option>
                </select>
            </div>

          <button type="submit" class="butt mt-2 w-100" id="submitButton">  <!-- ID fixed: submitButton (no typo) -->
            Submit
            <svg class="icon" viewBox="0 0 24 24" fill="currentColor" style="display: none;">  <!-- Hide arrow during loading -->
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z" clip-rule="evenodd"></path>
            </svg>
        </button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function loadDynamicData() {
        $.get('/get-interests', function(response) {
            let html = '';
            response.forEach(function(interest) {
                html += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="interests[]" value="${interest.name}" id="interest_${interest.id}">  <!-- Value as ID (backend consistent) -->
                        <label class="form-check-label" for="interest_${interest.id}">${interest.name}</label>  <!-- Fixed: for matches id -->
                    </div>
                `;
            });
            $('#interests-container').html(html);
        }).fail(function(xhr) {
            $('#interests-container').html('<p class="text-danger">Error loading interests. Try refresh.</p>');
        });

      $.get('/get-budgets', function(response) {
            let html = '<option value="">Select Budget</option>';
            response.forEach(function(budget) {
                html += `<option value="${budget.label || budget.budgetname}">${budget.label || budget.budgetname}</option>`;
            });
            $('select[name="budget"]').html(html);
        }).fail(function() {
           
        });
    }

    loadDynamicData();  
    $('#consultForm').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $submitButton = $('#submitButton');  
        const originalHtml = $submitButton.html();  
        $submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span> Sending...');  <!-- Bootstrap spinner (no FA needed) -->

        const formData = $form.serialize();

        $.ajax({
            url: '/save-consultation',
            type: 'POST',
            data: formData,
            success: function(response) {
                showAlert(response.message || 'Submitted successfully!');  
                $form[0].reset();
                closePopup();
                loadDynamicData(); 
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors || ['An error occurred. Please try again.'];
                showAlert(errors);
            },
            complete: function() {  
                $submitButton.prop('disabled', false).html(originalHtml);
            }
        });
    });
});
</script>


<script>
    setTimeout(() => {
        document.getElementById("consultPopup").style.display = "flex";
    },5000);
    function closePopup() {
        document.getElementById("consultPopup").style.display = "none";
    }
</script>

{{-- External Libraries (CDN) --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"
    integrity="sha512-NcZdtrT77bJr4STcmsGAESr06BYGE8woZdSdEgqnpyqac7sugNO+Tr4bGwGF3MsnEkGKhU2KL2xh6Ec+BqsaHA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="{{ asset('assets-front/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"crossorigin="anonymous"></script>
<script>
document.querySelectorAll('.book-now-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        window.location.href = "{{ url('/book') }}#booking-property";
    });
});
</script>


</body>

</html>