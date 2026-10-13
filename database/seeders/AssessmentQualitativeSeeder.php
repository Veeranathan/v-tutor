<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningProgramAssessmentQuestion;

class AssessmentQualitativeSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | COMMON QUESTIONS
        |--------------------------------------------------------------------------
        | General + Year-1 to Year-12
        */

        $commonQuestions = [

            [
                'question' => 'What are the student’s strongest subjects in school?',
            ],

            [
                'question' => 'Which areas does the student find most challenging?',
            ],

            [
                'question' => 'How does the student usually prepare for school exams?',
            ],

            [
                'question' => 'What are the student’s academic goals for this year?',
            ],

            [
                'question' => 'What type of support would help the student improve most?',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | OC QUESTIONS
        |--------------------------------------------------------------------------
        */

        $ocQuestions = [

            [
                'question' => 'What motivates the student to prepare for the OC test?',
            ],

            [
                'question' => 'Which OC section does the student find most difficult?',
            ],

            [
                'question' => 'How does the student manage difficult reasoning questions?',
            ],

            [
                'question' => 'What are the student’s strengths in OC preparation?',
            ],

            [
                'question' => 'What additional support would help the student perform better in OC?',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | SELECTIVE QUESTIONS
        |--------------------------------------------------------------------------
        */

        $selectiveQuestions = [

            [
                'question' => 'Why does the student want to join a Selective School?',
            ],

            [
                'question' => 'Which Selective test section needs the most improvement?',
            ],

            [
                'question' => 'How does the student prepare for advanced academic challenges?',
            ],

            [
                'question' => 'What are the student’s biggest strengths in Selective preparation?',
            ],

            [
                'question' => 'What support would help the student achieve a higher Selective score?',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | STORE COMMON QUESTIONS
        |--------------------------------------------------------------------------
        */

        $assessmentTypes = [
            'general',
            'year-1',
            'year-2',
            'year-3',
            'year-4',
            'year-5',
            'year-6',
            'year-7',
            'year-8',
            'year-9',
            'year-10',
            'year-11',
            'year-12',
        ];

        foreach ($assessmentTypes as $assessmentType) {

            foreach ($commonQuestions as $index => $q) {

                LearningProgramAssessmentQuestion::updateOrCreate(

                    [
                        'assessment_type' => $assessmentType,
                        'type' => 'qualitative',
                        'question' => $q['question'],
                    ],

                    [
                        'question_type' => 'text',
                        'options' => null,
                        'status' => 1,
                        'order' => $index + 1,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | STORE OC QUESTIONS
        |--------------------------------------------------------------------------
        */

        foreach ($ocQuestions as $index => $q) {

            LearningProgramAssessmentQuestion::updateOrCreate(

                [
                    'assessment_type' => 'oc',
                    'type' => 'qualitative',
                    'question' => $q['question'],
                ],

                [
                    'question_type' => 'text',
                    'options' => null,
                    'status' => 1,
                    'order' => $index + 1,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | STORE SELECTIVE QUESTIONS
        |--------------------------------------------------------------------------
        */

        foreach ($selectiveQuestions as $index => $q) {

            LearningProgramAssessmentQuestion::updateOrCreate(

                [
                    'assessment_type' => 'selective',
                    'type' => 'qualitative',
                    'question' => $q['question'],
                ],

                [
                    'question_type' => 'text',
                    'options' => null,
                    'status' => 1,
                    'order' => $index + 1,
                ]
            );
        }
    }
}