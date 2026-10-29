<style>
    .assessment-box h1 {
        font-size: 28px;
        line-height: 1.3;
        margin-bottom: 10px;
    }

    .assessment-box > p {
        font-size: 15px;
        line-height: 1.6;
    }

    @media (max-width: 767px) {
        .assessment-box h1 {
            font-size: 23px;
        }

        .assessment-box > p {
            font-size: 14px;
        }
    }
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
                        <h1 class="mb-2">
                            <span class="section-heading">Find the Right Learning Path for Your Child</span>
                        </h1>
                        <p class="mb-4">Tell us about your child’s learning needs, strengths and goals. We’ll help you 
                            explore suitable learning programs and take the next step towards more targeted support</p>

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
