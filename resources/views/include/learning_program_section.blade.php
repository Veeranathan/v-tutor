<style>
    @media (max-width: 576px) {
    .assessment-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
        flex-wrap: nowrap;
    }

    .assessment-actions .assessment-btn {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 8px;
        width: auto !important;
        min-width: 110px;
        white-space: nowrap;
    }
}
</style>
<section class="makes_special_sec faq-sec {{ !empty($isCategoryPage) ? 'mt-4 mb-10' : '' }}">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1 col-md-12">

                <div class="assessment-box text-center">

                    @if(empty($isCategoryPage))
                        <h3 class="mb-2">
                            <span class="section-heading">Start Your Learning Journey</span> with the Right Program
                        </h3>
                        <p class="mb-4">Who is this learning for?</p>

                        <div class="assessment-actions">
                            <button type="button" class="assessment-btn" data-type="me">For Me</button>
                            <button type="button" class="assessment-btn" data-type="child">For My Child</button>
                        </div>
                    @else
                        <h3 class="mb-4">
                            Book a <span class="section-heading">Free Assessment</span> to Identify Learning Gaps
                            and <span class="section-heading">Get Academic Counselling</span>
                        </h3>

                        <div class="assessment-actions">
                            <button type="button" class="assessment-btn" data-type="me">
                                Book Free Assessment
                            </button>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</section>
