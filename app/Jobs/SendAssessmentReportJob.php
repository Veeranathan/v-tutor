<?php

namespace App\Jobs;

use App\Mail\AssessmentReportMail;
use App\Models\LearningProgramAssessment;
use App\Models\MyAssessment;
use App\Services\AssessmentPdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendAssessmentReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $assessmentId;

    /**
     * Create a new job instance.
     */
    public function __construct($assessmentId)
    {
        $this->assessmentId = $assessmentId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try { 
            $pdfService = app(AssessmentPdfService::class);
            $data = $pdfService->getAssessmentData($this->assessmentId);

            $assessment = $data['assessment'];
            $result = $data['result'];
            $myAssessment = $data['myAssessment'];

            $directory = storage_path('app/reports');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $pdfPath = $directory . '/assessment-' . $assessment->id . '.pdf';

            // Generate and save the PDF file directly to disk using the updated mPDF service method
            $pdfService->generateToFile($assessment, $result, $myAssessment, $pdfPath);

            // Verify the file was created successfully before passing it to the mail outbox
            if (file_exists($pdfPath) && filesize($pdfPath) > 0) {
                Mail::send(new AssessmentReportMail($assessment, $pdfPath));
                //Log::info('Assessment Report Mail Sent Successfully.', ['assessment_id' => $this->assessmentId]);
            } else {
                Log::error('PDF File Generation verified empty or missing on disk.', ['assessment_id' => $this->assessmentId]);
            }

        } catch (\Exception $e) {
            Log::error(
                'Assessment Report Mail Error. Assessment ID: '
                . $this->assessmentId
                . '. Error: '
                . $e->getMessage()
            );
        } finally {
            // Clean up the temporary file from the disk storage securely
            if (isset($pdfPath) && file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
    }
}