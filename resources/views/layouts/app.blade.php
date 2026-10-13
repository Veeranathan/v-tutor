<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $noIndex = request()->is(
            'my-profile*',
            'my-class*',
            'student-mytutors*',
            'my-review*',
            'student-my-payments*',
            'tutor/*',
            'admin/*'
        ) || request()->query();
    @endphp

    @if ($noIndex)
        <meta name="robots" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow">
    @endif

    <link rel="canonical" href="{{ url()->current() }}">
 
    <!-- Dynamic Title & Description -->
    <title>@yield('page_title', 'V-Tutor | Online Tutoring in Australia | Qualified Online Tutors')</title>
    <meta name="description" content="@yield('meta_description', 'Find qualified online tutors across Australia for English, Maths and Science. WWCC-verified and ACARA-aligned tutors for personalised learning.')">
    <meta name="keywords" content="@yield('meta_keywords', 'online tutoring Australia, online tutors Australia, online tutors, qualified tutors Australia, English tutors, Maths tutors, Science tutors, ACARA-aligned tutors, WWCC verified tutors, online tutor, online learning Australia, home tutoring Australia, remote tutoring Australia, online tuition Australia, best online tutors Australia')">
    
    <meta property="og:title" content="Online Tutoring in Australia | V-Tutor">
    <meta property="og:description" content="Find qualified online tutors across Australia for Maths, Science and English.">
    <meta property="og:image" content="{{ public_asset('assets/images/favicon-512x512.png') }}">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    {{--  <script src="{{ public_asset('js/app.js') }}" defer></script> --}}
    @if (app()->environment('stage'))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='da
    taLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TL5XC3F');</script>
    <!-- End Google Tag Manager -->
    <!-- Meta Pixel Code --> 
     <script> !function(f,b,e,v,n,t,s) 
     {if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)}; 
     if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0'; n.queue=[];t=b.createElement(e);
     t.async=!0; t.src=v;s=b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s)}
     (window, document,'script', 'https://connect.facebook.net/en_US/fbevents.js'); 
     fbq('init', '389051179217833'); fbq('track', 'PageView'); 
     </script> 
     <noscript><img height="1" width="1" style="display:none" 
     src="https://www.facebook.com/tr?id=389051179217833&ev=PageView&noscript=1" />
    </noscript> 
    <!-- End Meta Pixel Code -->
     <meta name="facebook-domain-verification" content="mdcra0a4u5h0o6e71spq1t5ovthnki" />
    @endif
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.2.616/styles/kendo.common.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2021.2.616/styles/kendo.blueopal.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ public_asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
    @if (app()->environment('stage'))
    <script src="https://cdn.cookiehub.eu/c2/22654967.js"></script>
    <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
    var cpm = {};
    window.cookiehub.load(cpm);
    });
    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6903b59565e9a6194e3c08ba/1j8r7qklm';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!-- Popup smart script -->
    <script src="https://cdn.popupsmart.com/bundle.js" data-id="1012070" async defer></script>
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '389051179217833');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=389051179217833&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    @endif
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    @if (app()->environment('stage'))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TL5XC3F"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif
    <div id="app">

        {{-- <div class="d-flex" id="wrapper"> --}}
        @yield('left_part')
        @yield('content')
        {{-- </div> --}}
        <div class="wrapper-page">
            @yield('body')
            @yield('errors')
            @yield('footer')
        </div>
        @yield('script')

        <div class="modal " id="st_meeting_popup">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title bb_disabled_booking_u" id="st_meeting_popupLabel">Heads up! Your session
                            starts in 5 minutes!</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body st_meeting_popupbody">
                        <div class="">
                            <div class=" ">
                                <div class="meass-popup">
                                    <ul class="st_meeting_popupUl">
                                        <li class="">
                                            <p>Get ready to join your session with <span
                                                    class="st_mp_tut_name">Tutor</span> at <span class="st_mp_time">5
                                                    mins</span> (<span class="st_mp_tz">Australia</span>).</p>
                                            <p>Click below to jump in when you’re ready:</p>
                                            <p><a href="javascript:void(0);"
                                                    id="st_meeting_popup_redirectButton"><button type="button"
                                                        class="btn_stl btn btn-primary">Meeting Link</button></a></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="modal-footerst_meeting_popup_errorFooter">
                        <a href="javascript:void(0);" id="st_meeting_popup_redirectButton"><button type="button" class="btn_stl btn btn-primary">Meeting Link</button></a>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="modal " id="tut_meeting_popup">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title bb_disabled_booking_u" id="tut_meeting_popupLabel">Heads up! Your session
                            starts in 5 minutes!</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body tut_meeting_popupbody">
                        <div class="">
                            <div class=" ">
                                <div class="meass-popup">
                                    <ul class="tut_meeting_popupUl">
                                        <li class="">
                                            <p>Get ready to join your session with <span
                                                    class="tut_mp_tut_name">Tutor</span> at <span class="tut_mp_time">5
                                                    mins</span> (<span class="tut_mp_tz">Australia</span>).</p>
                                            <p>Click below to jump in when you’re ready:</p>
                                            <p><a href="javascript:void(0);"
                                                    id="tut_meeting_popup_redirectButton"><button type="button"
                                                        class="btn_stl btn btn-primary">Meeting Link</button></a></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="modal-footertut_meeting_popup_errorFooter">
                        <a href="javascript:void(0);" id="tut_meeting_popup_redirectButton"><button type="button" class="btn_stl btn btn-primary">Meeting Link</button></a>
                    </div> --}}
                </div>
            </div>
        </div>



        <script>
            function checkStudentMeetingStart() {
                $.ajax({
                    url: "{{ route('check_student_zoom_meeting') }}",
                    type: "GET",
                    success: function(res) {
                        if (res.status) {
                            if (res.rlt) {
                                if (res.rlt.name) {
                                    $('#st_meeting_popup .st_mp_tut_name').text(res.rlt.name);
                                    if (res.rlt.time) {
                                        $('#st_meeting_popup .st_mp_time').text(res.rlt.time);
                                    }

                                    if (res.rlt.timezone) {
                                        $('#st_meeting_popup .st_mp_tz').text(res.rlt.timezone);
                                    }

                                    if (res.rlt.zoom_link) {
                                        $('#st_meeting_popup_redirectButton').attr('href', res.rlt.zoom_link);
                                    }

                                    $("#st_meeting_popup").fadeIn();
                                }
                            }
                        }
                    }
                });
            }

           // setInterval(checkStudentMeetingStart, 60000);

            $(document).on('click', '#st_meeting_popup button.close', function(e) {
                $("#st_meeting_popup").fadeOut();
            });

            function checkTutorMeetingStart() {
                $.ajax({
                    url: "{{ route('check_tutor_zoom_meeting') }}",
                    type: "GET",
                    success: function(res) {
                        if (res.status) {
                            if (res.rlt) {
                                if (res.rlt.name) {
                                    $('#tut_meeting_popup .tut_mp_tut_name').text(res.rlt.name);
                                    if (res.rlt.time) {
                                        $('#tut_meeting_popup .tut_mp_time').text(res.rlt.time);
                                    }

                                    if (res.rlt.timezone) {
                                        $('#tut_meeting_popup .tut_mp_tz').text(res.rlt.timezone);
                                    }

                                    if (res.rlt.zoom_link) {
                                        $('#tut_meeting_popup_redirectButton').attr('href', res.rlt.zoom_link);
                                    }

                                    $("#tut_meeting_popup").fadeIn();
                                }
                            }
                        }
                    }
                });
            }

           // setInterval(checkTutorMeetingStart, 60000);

            $(document).on('click', '#tut_meeting_popup button.close', function(e) {
                $("#tut_meeting_popup").fadeOut();
            });
        </script>
    </div>

    <style>
        #bookingList {
            max-height: 250px;
            overflow-y: auto;
        }

        #fcm-toast-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .fcm-toast {
            background: #323232;
            color: #fff;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            font-family: 'Inter', sans-serif;
            min-width: 280px;
            max-width: 350px;
            position: relative;
            animation: fadeInUp 0.4s ease;
        }

        .fcm-toast h4 {
            margin: 0 0 5px;
            font-size: 16px;
            font-weight: 600;
            color: #fff !important;
        }

        .fcm-toast p {
            margin: 0;
            font-size: 14px;
        }

        .fcm-toast .close-btn {
            position: absolute;
            top: 8px;
            right: 12px;
            color: #bbb;
            font-size: 18px;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .fcm-toast .close-btn:hover {
            color: #fff;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Toast container -->
    <div id="fcm-toast-container"></div>
    @auth
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
        </script>

        <script type="module">
            import {
                initializeApp
            } from "https://www.gstatic.com/firebasejs/11.0.0/firebase-app.js";
            import {
                getMessaging,
                getToken,
                deleteToken, // ✅ Add this
                onMessage
            } from "https://www.gstatic.com/firebasejs/11.0.0/firebase-messaging.js";
            const firebaseConfig = {
                apiKey: "{{ config('services.firebase.api_key') }}",
                authDomain: "{{ config('services.firebase.auth_domain') }}",
                projectId: "{{ config('services.firebase.project_id') }}",
                storageBucket: "{{ config('services.firebase.storage_bucket') }}",
                messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
                appId: "{{ config('services.firebase.app_id') }}"
            };

            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);

            // register service worker at root
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/firebase-messaging-sw.js')
                    .then(() => console.log('✅ Service Worker registered'))
                    .catch(err => console.error('❌ SW register failed', err));
            }
            async function handleLogout() {
                try {
                    const currentToken = await getToken(messaging);

                    if (currentToken) {
                        // Tell backend to remove this token
                        await fetch("{{ url('/remove-fcm-token') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                fcm_token: currentToken
                            }),
                        });

                        // Delete token from Firebase
                        await deleteToken(messaging);
                        console.log("✅ FCM token removed from Firebase and backend");
                    }
                } catch (error) {
                    console.warn("⚠️ Failed to remove FCM token:", error);
                } finally {
                    // Continue with Laravel logout
                    document.getElementById('logout-form').submit();
                }
            }
            window.handleLogout = handleLogout; // 👈 this line makes it available to inline onclick


            async function ensureTokenSentToServer(forceNew = false) {
                try {
                    const registration = await navigator.serviceWorker.ready;
                    const storedToken = localStorage.getItem('fcm_token');

                    // 🔹 Delete old token if forced (e.g. at login)
                    if (storedToken && forceNew) {
                        await deleteToken(messaging);
                        localStorage.removeItem('fcm_token');
                        console.log('🗑️ Old FCM token deleted');
                    }

                    const permission = await Notification.requestPermission();
                    if (permission !== 'granted') {
                        console.warn('Notification permission not granted');
                        return;
                    }

                    const token = await getToken(messaging, {
                        vapidKey: "BPezr-qburYYx1cFFP4_X82rsmYWR5PaUfZxNBgBvgwBMouLqNEK8-CotqH4vmAlStl3RPumBtALXmU4kVWkmMQ",
                        serviceWorkerRegistration: registration
                    });

                    if (token) {
                        console.log('✅ New/Refreshed FCM Token:', token);

                        await fetch('/save-fcm-token', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                token
                            })
                        });

                        localStorage.setItem('fcm_token', token);
                    }
                } catch (err) {
                    console.error('Error ensuring FCM token', err);
                }
            }


            onMessage(messaging, payload => {
                console.log('📩 Foreground message received:', payload);

                const {
                    title,
                    body
                } = payload.notification || {};
                const data = payload.data || {};
                const link = data.link || '#';

                const container = document.getElementById('fcm-toast-container');

                // Create a new toast element
                const toast = document.createElement('div');
                toast.classList.add('fcm-toast');
                toast.innerHTML = `
                    <span class="close-btn">&times;</span>
                    <h4>${title || 'VTutor'}</h4>
                    <p>${body || 'New message received'}</p>
                `;

                // Add close behavior
                toast.querySelector('.close-btn').addEventListener('click', () => {
                    toast.remove();
                    if (payload && payload.data && payload.data.notification_id) {
                        const notificationId = payload.data.notification_id;
                        fetch("/notifications/mark-read", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                        .content
                                },
                                body: JSON.stringify({
                                    ids: [notificationId]
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                console.log("✅ Marked as read:", data);
                                loadUnreadNotificationsFromDB();
                            });

                    }
                });

                // Append toast to container
                container.appendChild(toast);

                // Remove after 5 minutes
                setTimeout(() => toast.remove(), 300000);

                // ✅ Step 1: Update notification bell count
                const countElem = document.getElementById('bookingCount');
                if (countElem) {
                    let count = parseInt(countElem.textContent || '0', 10) + 1;
                    countElem.textContent = count;
                    countElem.classList.remove('hidden');
                }

                // ✅ Step 2: Add new notification to dropdown list
                const listElem = document.getElementById('bookingList');
                if (listElem) {
                    const newItem = document.createElement('li');
                    newItem.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                    newItem.innerHTML = `
            <div class="font-medium">${title || 'New Notification'}</div>
            <div class="text-sm text-gray-600">${body || ''}</div>
        `;
                    newItem.onclick = () => window.location.href = link;
                    listElem.prepend(newItem);
                }

                // ✅ Step 3: Also show native browser notification (if allowed)
                if (Notification.permission === 'granted') {
                    new Notification(title || 'VTutor', {
                        body: body || 'New message'
                    });
                }
            });


            ensureTokenSentToServer();

            // 🔹 Toggle dropdown visibility on bell click
            const bellButton = document.getElementById("bellButton");
            const bookingDropdown = document.getElementById("bookingDropdown");

            bellButton.addEventListener("click", (e) => {
                e.stopPropagation();
                bookingDropdown.classList.toggle("hidden");
            });

            // 🔹 Hide dropdown when clicking outside
            document.addEventListener("click", (e) => {
                if (!bellButton.contains(e.target) && !bookingDropdown.contains(e.target)) {
                    bookingDropdown.classList.add("hidden");
                }
            });
            // 🔹 Handle "Mark All as Read"
            document.getElementById("markAllReadBtn")?.addEventListener("click", function() {
                if (!confirm("Mark all notifications as read?")) return;

                fetch("/notifications/mark-read", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({}) // empty = mark all
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log("✅ All notifications marked as read:", data);
                        loadUnreadNotificationsFromDB(); // refresh list and count
                    })
                    .catch(err => console.error("❌ Failed to mark all as read:", err));
            });




            // 👇 Listen to messages from Service Worker (even when tab inactive)
            navigator.serviceWorker.addEventListener('message', (event) => {
                if (event.data?.type === 'FCM_NOTIFICATION') {
                    const {
                        title,
                        body,
                        link
                    } = event.data.data || {};
                    console.log('📩 Message received from Service Worker:', event.data.data);

                    // Optional: Update your 🔔 bell icon count
                    let countElem = document.getElementById('notif-count');
                    if (countElem) {
                        let count = parseInt(countElem.innerText || '0', 10);
                        countElem.innerText = count + 1;
                        countElem.style.display = 'inline-block';
                    }

                    // Optional: Show toast if you want
                    //showFcmToast(title, body, link);
                }
            });

            document.addEventListener("DOMContentLoaded", () => {
                console.log("🚀 Page loaded — fetching unread notifications...");
                loadUnreadNotificationsFromDB();
            });

            function loadUnreadNotificationsFromDB() {
                console.log("📡 Starting AJAX request to load unread notifications...");

                $.ajax({
                    url: "/notifications/unread-count",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log("✅ AJAX success:", response);

                        const notifications = Array.isArray(response.items) ? response.items : [];
                        const unreadCount = response.unread_count || notifications.length;

                        updateNotificationUI(notifications, unreadCount);
                    },
                    error: function(xhr, status, error) {
                        console.error("❌ AJAX error:", status, error);
                        console.error("Response text:", xhr.responseText);
                    },
                    complete: function() {
                        console.log("🔁 AJAX request completed.");
                    }
                });
            }


            function updateNotificationUI(notifications = [], unreadCount = 0) {
                const bookingList = document.getElementById("bookingList");
                const bookingCount = document.getElementById("bookingCount");

                // 🧹 Clear list only when actually re-rendering
                bookingList.innerHTML = "";

                if (!notifications || notifications.length === 0) {
                    bookingList.innerHTML = `<li class="px-4 py-2 text-gray-500 text-sm text-center">No new notifications</li>`;
                    bookingCount.classList.add("hidden");
                    return;
                }

                // 🔢 Update badge
                bookingCount.textContent = unreadCount;
                bookingCount.classList.toggle("hidden", unreadCount === 0);

                // 📨 Render new notifications
                notifications.forEach((n) => {
                    const li = document.createElement("li");
                    li.className = "px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm border-b border-gray-100";
                    li.innerHTML = `
            <div class="font-semibold text-gray-800">${n.title || "Notification"}</div>
            <div class="text-gray-600">${n.body || ""}</div>
        `;
                    bookingList.appendChild(li);
                });
            }





            setInterval(() => {
                if (document.visibilityState !== 'visible') return; // Skip if not viewing
                loadUnreadNotificationsFromDB();
            }, 120000); // every 2 mins
        </script>
    @endauth




    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script src="https://cdn.popupsmart.com/bundle.js" data-id="1012070" async defer></script>
</body>

</html>
@if (session('clear_localstorage'))
    <script>
        localStorage.clear();
        sessionStorage.clear();
    </script>
@endif
