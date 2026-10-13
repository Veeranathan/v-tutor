<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SUBJECT PAGES
    |--------------------------------------------------------------------------
    */
    'subject' => [

        'maths' => [
            'page_short_name' => 'Maths',
            'hero' => [
                'title' => 'Maths Tutoring',
                'image' => 'hero-maths.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-calculator', 'title' => 'Master Algebra Concepts'],
                ['icon' => 'bi-graph-up', 'title' => 'Master Algebra & Functions'],
                ['icon' => 'bi-lightbulb', 'title' => 'Master Functions & Calculus'],
                ['icon' => 'bi-award', 'title' => 'Master Fraction Foundations'],
                ['icon' => 'bi-trophy', 'title' => 'Master Core Number Skills'],
            ],
        ],

        'english' => [
            'page_short_name' => 'English',
            'hero' => [
                'title' => 'English Tutoring',
                'image' => 'hero-english.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-book', 'title' => 'Master Critical Reading'],
                ['icon' => 'bi-pencil', 'title' => 'Master Written Expression'],
                ['icon' => 'bi-chat-dots', 'title' => 'NAPLAN Year 3'],
                ['icon' => 'bi-award', 'title' => 'NAPLAN Year 5'],
            ],
        ],

        'science' => [
            'page_short_name' => 'Science',
            'hero' => [
                'title' => 'Science Tutoring',
                'image' => 'hero-science.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-flask', 'title' => 'Master Scientific Thinking'],
            ],
        ],

        'physics' => [
            'page_short_name' => 'Physics',
            'hero' => [
                'title' => 'Physics Tutoring',
                'image' => 'hero-physics.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
                ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
                ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
                ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
                ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
            ],
        ],

        'chemistry' => [
            'page_short_name' => 'Chemistry',
            'hero' => [
                'title' => 'Chemistry Tutoring',
                'image' => 'hero-chemistry.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
                ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
                ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
                ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
                ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
            ],
        ],

        'biology' => [
            'page_short_name' => 'Biology',
            'hero' => [
                'title' => 'Biology Tutoring',
                'image' => 'hero-biology.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
                ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
                ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
                ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
                ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
            ],
        ],

        'naplan' => [
            'page_short_name' => 'NAPLAN',
            'hero' => [
                'title' => 'NAPLAN',
                'image' => 'hero-maths.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-journal-check', 'title' => 'NAPLAN Prep Year 3'],
                ['icon' => 'bi-clipboard-data', 'title' => 'NAPLAN Prep Year 5'],
                ['icon' => 'bi-graph-up-arrow', 'title' => 'NAPLAN Prep Year 7'],
                ['icon' => 'bi-bullseye', 'title' => 'NAPLAN Prep Year 9'],
            ],
        ],

        'opportunity-class' => [
            'page_short_name' => 'Opportunity Class',
            'hero' => [
                'title' => 'Opportunity Class',
                'image' => 'hero-maths.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-journal-check', 'title' => 'Core Test Prep Maths Year 4'],
                ['icon' => 'bi-clipboard-data', 'title' => 'Core Test Prep Reading Year 3'],
                ['icon' => 'bi-graph-up-arrow', 'title' => 'Core Test Prep Thinking Year  4'],
                ['icon' => 'bi-bullseye', 'title' => 'Crash Test Prep Reading Year 3'],
            ],
        ],

        'learning-programs' => [
            'page_short_name' => 'Academic Learning Programs',
            'hero' => [
                'title' => 'Academic Learning Programs',
                'image' => 'hero-maths.webp',
            ],
            'top_programs' => [
                ['icon' => 'bi-calendar-check', 'title' => 'Master Algebra Concepts'],
                ['icon' => 'bi-diagram-3', 'title' => 'Master Algebra & Functions'],
                ['icon' => 'bi-lightbulb', 'title' => 'Master Fraction Foundations'],
                ['icon' => 'bi-book', 'title' => 'Master Critical Reading'],
                ['icon' => 'bi-lightbulb', 'title' => 'Master Scientific Thinking'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | YEAR PAGES
    |--------------------------------------------------------------------------
    */
    'year' => collect(range(1, 12))->mapWithKeys(function ($year) {
        return [
            "year-$year" => [
                'page_short_name' => "year-$year",
                'hero' => [
                    'title' => "Year $year",
                    'image' => "hero-year-$year.webp",
                ],
                'top_programs' => [
                    ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
                    ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
                    ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
                    ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
                    ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
                ],
            ],
        ];
    })->toArray(),

/*
|--------------------------------------------------------------------------
| CURRICULUM PAGES
|--------------------------------------------------------------------------
*/
'curriculum' => [

    'nesa-curriculum' => [
        'page_short_name' => 'NESA',
        'hero' => [
            'title' => 'NESA Curriculum',
            'image' => 'hero-nesa.webp',
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'vcaa-curriculum' => [
        'page_short_name' => 'VCAA',
        'hero' => [
            'title' => 'VCAA Curriculum',
            'image' => 'hero-vcaa.webp',
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'qcaa-curriculum' => [
        'page_short_name' => 'QCAA',
        'hero' => [
            'title' => 'QCAA Curriculum',
            'image' => 'hero-qcaa.webp',
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'sace-curriculum' => [
        'page_short_name' => 'SACE',
        'hero' => [
            'title' => 'SACE Curriculum',
            'image' => 'hero-sace.webp',
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'wace-curriculum' => [
        'page_short_name' => 'WACE',
        'hero' => [
            'title' => 'WACE Curriculum',
            'image' => 'hero-wace.webp',
        ],
        'top_programs' => [
           ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
           ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
           ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
           ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
           ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'bsss-curriculum' => [
        'page_short_name' => 'BSSS',
        'hero' => [
            'title' => 'BSSS Curriculum',
            'image' => 'hero-bsss.webp',
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'tasc-curriculum' => [
        'page_short_name' => 'TASC',
        'hero' => [
            'title' => 'TASC Curriculum',
            'image' => 'hero-tasc.webp',
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'ntbs-curriculum' => [
        'page_short_name' => 'NTBS',
        'hero' => [
            'title' => 'NTBS Curriculum',
            'image' => 'hero-ntbs.webp',
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

],

    /*
|--------------------------------------------------------------------------
| STATE PAGES
|--------------------------------------------------------------------------
*/
'state' => [
    'new-south-wales' => [
        'page_short_name' => 'NSW',
        'hero' => [
            'title' => 'New South Wales',
            'image' => 'hero-nsw.webp'
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'victoria' => [
        'page_short_name' => 'Victoria',
        'hero' => [
            'title' => 'Victoria',
            'image' => 'hero-vic.webp'
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'queensland' => [
        'page_short_name' => 'QLD',
        'hero' => [
            'title' => 'Queensland',
            'image' => 'hero-qld.webp'
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'south-australia' => [
        'page_short_name' => 'SW',
        'hero' => [
            'title' => 'South Australia',
            'image' => 'hero-sa.webp'
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'western-australia' => [
        'page_short_name' => 'WA',
        'hero' => [
            'title' => 'Western Australia',
            'image' => 'hero-wa.webp'
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'tasmania' => [
        'page_short_name' => 'Tasmania',
        'hero' => [
            'title' => 'Tasmania',
            'image' => 'hero-tas.webp'
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'australian-capital-territory' => [
        'page_short_name' => 'ACT',
        'hero' => [
            'title' => 'Australian Capital Territory',
            'image' => 'hero-act.webp'
        ],
        'top_programs' => [
           ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
           ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
           ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
           ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
           ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'northern-territory' => [
        'page_short_name' => 'NT',
        'hero' => [
            'title' => 'Northern Territory',
            'image' => 'hero-nt.webp'
        ],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],
],

    /*
|--------------------------------------------------------------------------
| CITY PAGES
|--------------------------------------------------------------------------
*/
'city' => [
    
    'sydney' => [
        'page_short_name' => 'Sydney',
        'hero' => ['title' => 'Sydney Tutors', 'image' => 'hero-sydney.webp'],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'melbourne' => [
        'page_short_name' => 'Melbourne',
        'hero' => ['title' => 'Melbourne Tutors', 'image' => 'hero-melbourne.webp'],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'brisbane' => [
        'page_short_name' => 'Brisbane',
        'hero' => ['title' => 'Brisbane Tutors', 'image' => 'hero-brisbane.webp'],
        'top_programs' => [
           ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
           ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
           ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
           ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
           ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'adelaide' => [
        'page_short_name' => 'Adelaide',
        'hero' => ['title' => 'Adelaide Tutors', 'image' => 'hero-adelaide.webp'],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'perth' => [
        'page_short_name' => 'Perth',
        'hero' => ['title' => 'Perth Tutors', 'image' => 'hero-perth.webp'],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'hobart' => [
        'page_short_name' => 'Hobart',
        'hero' => ['title' => 'Hobart Tutors', 'image' => 'hero-hobart.webp'],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'canberra' => [
        'page_short_name' => 'Canberra',
        'hero' => ['title' => 'Canberra Tutors', 'image' => 'hero-canberra.webp'],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],

    'darwin' => [
        'page_short_name' => 'Darwin',
        'hero' => ['title' => 'Darwin Tutors', 'image' => 'hero-darwin.webp'],
        'top_programs' => [
            ['icon' => 'bi-lightning', 'title' => 'Curriculum-Aligned Personalised Learning'],
            ['icon' => 'bi-radioactive', 'title' => 'Targeted approach for Subject Mastery'],
            ['icon' => 'bi-graph-up', 'title' => 'Validation Assessment & Free Counselling'],
            ['icon' => 'bi-award', 'title' => 'Expert Specialist Subject Tutors'],
            ['icon' => 'bi-trophy', 'title' => 'Flexible Online Booking & Scheduling'],
        ],
    ],
],


];
