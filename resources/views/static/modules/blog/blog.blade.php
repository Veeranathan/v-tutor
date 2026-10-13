@extends('layouts.app')

@section('page_title', 'V-Tutor Blog | Online Tutoring Tips & Education Insights Australia')
@section('meta_description', 'Read the latest online tutoring tips, education insights, and learning resources from V-Tutor. Helping Australian students succeed.')
@section('meta_keywords', 'online tutoring blog, education blog Australia, tutoring tips, learning resources')

@section('og_title', 'V-Tutor Blog | Online Tutoring & Education Insights')
@section('og_description', 'Explore expert articles on online tutoring, learning strategies, and education trends across Australia.')
@section('og_image', public_asset('assets/images/favicon.png'))

@section('canonical', url()->current())
@section('language', 'en-au')

@section('left_part')
@include('include.header_menu_part')
@endsection

@section('content')
@php
$title = 'Blog';
@endphp
<!-- ================= HERO (Modern Card Header) ================= -->
@include('include.page_hero', [
    'title' => $title,
    'showBreadcrumb' => true
])

<!-- =======================
   BLOG LISTING
======================= -->
<section class="bannertext-sec blog-listing">
    <div class="container">

        <!-- BLOG LIST -->
        <div id="blog-list">

            @forelse($blogs as $blog)
            <div class="row blog-card align-items-center mb-4">

                <!-- IMAGE -->
                <div class="col-md-3">
                    <div class="blog-thumb">
                        <img
                            src="{{ $blog->post_image
                                ? asset('storage/blog_pics_app/'.$blog->post_image)
                                : public_asset('assets/images/default-blog.jpg') }}"
                            alt="{{ $blog->post_title }}"
                            width="247"
                            height="200">

                        <div class="blog-date-overlay">
                            {{ $blog->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="col-md-9">
                    <div class="blog-content">
                        <h2 class="blog-title">
                            {{ $blog->post_title }}
                        </h2>

                        <p class="blog-excerpt">
                            {{ \Illuminate\Support\Str::limit(strip_tags($blog->post_content), 200) }}
                        </p>

                        <a href="{{ route('blog.detail', $blog->slug) }}" class="assessment-btn">
                            Read More
                        </a>
                    </div>
                </div>

            </div>
            @empty
                <p class="text-center" id="noBlogsMsg">No more blogs</p>
        @endforelse

        </div>

        <!-- LOAD MORE BUTTON -->
        @if($blogs->isNotEmpty() && $blogs->hasMorePages())
            <div class="text-center mt-4">
                <button id="loadMoreBtn" class="assessment-btn" data-page="2">
                    Load More
                </button>
            </div>
        @endif

    </div>
</section>

@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')

<script>
$(document).on('click', '#loadMoreBtn', function () {

    let btn  = $(this);
    let page = btn.data('page');

    btn.text('Loading...').prop('disabled', true);

    $.ajax({
        url: "{{ route('home.blog') }}",
        data: { page: page },
        success: function (response) {
        
    let $response = $(response);

    // If last page reached
    if ($response.find('#noBlogsMsg').length > 0) {

        // Append the message ONCE
        if ($('#noBlogsMsg').length === 0) {
            $('#blog-list').append(
                '<p class="text-center mt-4" id="noBlogsMsg">No more blogs</p>'
            );
        }

        btn.hide();
        return;
    }

    let newCards = $response.find('.blog-card');

    $('#blog-list').append(newCards);

    btn.data('page', page + 1);
    btn.text('Load More').prop('disabled', false);
        }
    });
});

</script>

<style>
/* ===========================
   BLOG PAGE STYLES
=========================== */

.blog-card {
    padding: 30px 0;
    border-bottom: 1px solid #eee;
}

/* ===========================
   THUMBNAIL
=========================== */

.blog-thumb {
    position: relative;
    width: 247px;
    height: 200px;
    border-radius: 6px;
    overflow: hidden;
    transition: box-shadow 0.35s ease;
}

.blog-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.35s ease;
}

/* ===========================
   DATE OVERLAY
=========================== */

.blog-date-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 25%;
    background-color: rgba(158, 13, 8, 0.92);
    color: #ffffff;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    letter-spacing: 0.4px;
    z-index: 2;
}

/* ===========================
   HOVER EFFECT
=========================== */

.blog-thumb::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.25);
    opacity: 0;
    transition: opacity 0.35s ease;
    z-index: 1;
}

.blog-thumb:hover::after {
    opacity: 1;
}

.blog-thumb:hover img {
    transform: scale(1.05);
}

.blog-thumb:hover {
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
}

/* ===========================
   CONTENT
=========================== */

.blog-title {
    font-size: 22px;
    font-weight: 600;
    color: #b80f0a;
    margin-bottom: 12px;
}

.blog-excerpt {
    font-size: 15px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 18px;
}

/* ===========================
   BUTTON
=========================== */

.assessment-btn {
    display: inline-block;
    background-color: #b80f0a;
    color: #fff !important;
    padding: 8px 22px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.25s ease;
}

.assessment-btn:hover {
    background-color: #9e0d08;
    color: #fff;
}

/* ===========================
   LOAD MORE
=========================== */

#loadMoreBtn {
    margin-top: 30px;
}
</style>

@endsection
