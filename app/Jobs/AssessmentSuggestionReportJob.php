<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\AssessmentPdfService;
use App\Mail\AssessmentSuggestionReportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class AssessmentSuggestionReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The assessment ID.
     */
    protected int $assessmentId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $assessmentId)
    {
        $this->assessmentId = $assessmentId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pdfPath = null;

        try {
            /** @var AssessmentPdfService $pdfService */
            $pdfService = app(AssessmentPdfService::class);
            
            // 1. Fetch complete dataset including suggestion
            $data = $pdfService->getSuggestionData($this->assessmentId);

            $assessment   = $data['assessment'];
            $result       = $data['result'];
            $myAssessment = $data['myAssessment'];
            $suggestion   = $data['suggestion'];

            $directory = storage_path('app/reports/suggestions');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $pdfPath = $directory . '/suggestion-report-' . $assessment->id . '.pdf';

            // Generate Suggestion & Assessment PDF
            $pdfService->generateSuggestionToFile($assessment, $result, $myAssessment, $suggestion, $pdfPath);

            // Verify file creation and send email
            if (file_exists($pdfPath) && filesize($pdfPath) > 0) {
                Mail::send(new AssessmentSuggestionReportMail($assessment, $suggestion, $pdfPath));

                // Clean up file safely after mail dispatch completes
                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }
            } else {
                Log::error('Suggestion PDF generation empty or missing on disk.', [
                    'assessment_id' => $this->assessmentId
                ]);
            }

        } catch (Exception $e) {
            Log::error('Assessment Suggestion Report Job Error. Assessment ID: ' . $this->assessmentId . ' - Error: ' . $e->getMessage());

            // Clean up temporary file if exception occurs
            if ($pdfPath && file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            throw $e;
        }
    }
}