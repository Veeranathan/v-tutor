<?php

namespace App\Mail;

use App\Models\LearningProgramAssessment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class AssessmentReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessment;
    public $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct(
        LearningProgramAssessment $assessment,
        string $pdfPath
    ) {
        $this->assessment = $assessment;
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     */
    public function build()
    {

        $lastName = !empty($this->assessment->last_name)
            ? ucfirst(strtolower(trim($this->assessment->last_name)))
            : '';

        $fileName = $lastName 
            ? "{$lastName}_Diagnostic_Assessment_Report.pdf" 
            : 'diagnostic_assessment_report.pdf';

        return $this
        ->from('support@v-tutor.com.au', 'V-Tutor Student Assessment')
        ->to($this->assessment->email)
        ->cc('support@v-tutor.com.au')
        ->subject("Your Child's Diagnostic Assessment Report is Ready")
        ->view('mail.assessment_report')
        ->with([
            'assessment' => $this->assessment,
        ])
        ->attach($this->pdfPath, [
            'as' => $fileName,
            'mime' => 'application/pdf',
        ]);
    }
}