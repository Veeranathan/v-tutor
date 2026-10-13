@extends('layouts.app')

@section('page_title', $blog->seo_page_title ?? $blog->post_title)
@section('meta_description', $blog->seo_description)
@section('meta_keywords', $blog->seo_keyword)

@section('og_title', $blog->seo_page_title ?? $blog->post_title)
@section('og_description', $blog->seo_description)
@section('og_image', $blog->post_image
        ? asset('storage/blog_images/'.$blog->post_image)
        : public_asset('assets/images/favicon.png'))

@section('canonical', url()->current())
@section('language', 'en-au')

@section('left_part')
@include('include.header_menu_part')
@endsection

@section('content')

<!-- =======================
   BLOG DETAIL BANNER
======================= -->
<section class="about-banner newabtban newabb"
    style="background-image: url({{ public_asset('assets/images/about-nbanner.jpg') }});">

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('home.blog') }}">Blog</a>
                </li>
                {{-- <li class="breadcrumb-item active" aria-current="page">
                    {{ $blog->post_title }}
                </li> --}}
            </ol>
        </nav>
    </div>
</section>

<!-- =======================
   BLOG DETAIL CONTENT
======================= -->
<section class="bannertext-sec blog-detail-page">
    <div class="container">
        <div class="row justify-content-center">

            <!-- FIXED CONTENT WIDTH -->
            <div class="col-lg-9 col-md-10">

                <!-- TITLE -->
                <h1 class="blog-detail-title text-center">
                    {{ $blog->post_title }}
                </h1>

                <!-- META -->
                <div class="blog-meta text-center">
                    <span>Posted on {{ $blog->created_at->format('d M Y') }}</span>

                    @if(!empty($blog->user_name))
                        <span class="separator">|</span>
                        <span>By {{ $blog->user_name }}</span>
                    @endif
                </div>

                <!-- IMAGE -->
                <div class="blog-detail-image text-center">
                    <img
                        src="{{ $blog->post_image
                            ? asset('storage/blog_pics_app/'.$blog->post_image)
                            : public_asset('assets/images/default-blog.jpg') }}"
                        alt="{{ $blog->post_title }}"
                        class="img-fluid">
                </div>

                <!-- CONTENT -->
                <div class="blog-detail-content">
                    {!! $blog->post_content !!}
                </div>

            </div>

        </div>
    </div>
</section>

@endsection

@section('footer')
@include('include.footer')
@endsection

@section('script')
@include('include.script')

<style>
/* ==========================
   BLOG DETAIL PAGE
========================== */

/* Ensure white background */
.blog-detail-page {
    padding-top: 50px;
    padding-bottom: 60px;
    background-color: #ffffff;
}

/* ==========================
   TOP BANNER OVERLAY
========================== */

.about-banner {
    position: relative;
    background-size: cover;
    background-position: center;
}

/* Black overlay */
.about-banner::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45); /* adjust opacity if needed */
    z-index: 1;
}

/* Keep banner content above overlay */
.about-banner .container {
    position: relative;
    z-index: 2;
}

/* Breadcrumb visibility */
.about-banner .breadcrumb a,
.about-banner .breadcrumb-item {
    color: #ffffff;
}

.about-banner .breadcrumb-item.active {
    color: #dddddd;
}

/* ==========================
   TITLE
========================== */

.blog-detail-title {
    font-size: 32px;
    font-weight: 600;
    color: #b80f0a;
    margin-bottom: 15px;
}

/* ==========================
   META
========================== */

.blog-meta {
    font-size: 14px;
    color: #777;
    margin-bottom: 30px;
}

.blog-meta .separator {
    margin: 0 8px;
}

/* ==========================
   IMAGE
========================== */

.blog-detail-image {
    margin-bottom: 40px;
}

.blog-detail-image img {
    width: 100%;
    max-height: 420px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

/* ==========================
   CONTENT
========================== */

.blog-detail-content {
    font-size: 16px;
    line-height: 1.8;
    color: #444;
}

.blog-detail-content h2,
.blog-detail-content h3 {
    color: #b80f0a;
    margin-top: 30px;
    margin-bottom: 15px;
}

.blog-detail-content p {
    margin-bottom: 18px;
}

/* ==========================
   MOBILE
========================== */

@media (max-width: 767px) {
    .blog-detail-title {
        font-size: 26px;
    }

    .blog-detail-image img {
        max-height: 300px;
    }
}
.footer-custom {
  margin-top: 0px !important;
}
</style>
@endsection
