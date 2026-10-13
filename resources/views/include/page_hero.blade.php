<section id="hero" class="hero-card-section py-3">
    <div class="container">
        <div class="hero-compact-card text-center mx-auto shadow-sm {{ ($showBreadcrumb ?? true) ? '' : 'hero-title-only' }}">

            @if($showBreadcrumb ?? true)

                <nav aria-label="breadcrumb"
                     class="d-flex justify-content-center mb-0 breadcrumb-section">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">
                                <i class="bi bi-house-door-fill me-1"></i>Home
                            </a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $title }}
                        </li>
                    </ol>
                </nav>

            @else

                <h1 class="hero-title hero-title-small mb-0">
                    {{ $title }}
                </h1>

            @endif

        </div>
    </div>
</section>