<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tutor_calander_availability;
use App\Models\MyAvailability;
use App\Models\User;
use Carbon\Carbon;

class RefreshTutorAvailability extends Command
{
    protected $signature = 'availability:refresh';
    protected $description = 'Refresh tutor calendar availability for next 90 days';

    public function handle()
    {
        $today = Carbon::now('UTC')->startOfDay();
        $ninetyDaysLater = $today->copy()->addDays(90);

        $tutors = User::where('user_type', 'T')->get();

        foreach ($tutors as $tutor) {

            // Get latest availability date
            $maxDate = Tutor_calander_availability::where('tutor_id', $tutor->id)->max('date');
            $maxDate = $maxDate ? Carbon::parse($maxDate) : $today;

            if ($maxDate->lt($ninetyDaysLater)) {

                // Delete only past records
                Tutor_calander_availability::where('tutor_id', $tutor->id)
                    ->where('date', '<', $today->toDateString())
                    ->delete();

                $availabilities = MyAvailability::where('teacher_id', $tutor->id)
                    ->where('status', 'A')
                    ->get();

                if ($availabilities->isEmpty()) {
                    continue;
                }

                $newEntries = [];

                for ($i = 0; $i < 90; $i++) {

                    $targetDate = $today->copy()->addDays($i);

                    $dayNumber = $targetDate->dayOfWeekIso;

                    foreach ($availabilities->where('day', $dayNumber) as $avail) {

                        $interval = 60;

                        $startTime = Carbon::createFromFormat(
                            'Y-m-d H:i:s',
                            $targetDate->toDateString() . ' ' . $avail->from_time,
                            $tutor->timezone_id
                        );

                        $endTime = Carbon::createFromFormat(
                            'Y-m-d H:i:s',
                            $targetDate->toDateString() . ' ' . $avail->to_time,
                            $tutor->timezone_id
                        );

                        while ($startTime->lt($endTime)) {

                            $slotEnd = $startTime->copy()->addMinutes($interval);

                            if ($slotEnd->gt($endTime)) {
                                $slotEnd = $endTime->copy();
                            }

                            // Convert to UTC
                            $slotStartUtc = $startTime->copy()->timezone('UTC');
                            $slotEndUtc = $slotEnd->copy()->timezone('UTC');

                            // Skip duplicate records
                            $exists = Tutor_calander_availability::where([
                                'tutor_id'   => $tutor->id,
                                'date'       => $slotStartUtc->toDateString(),
                                'start_time' => $slotStartUtc->format('H:i:s'),
                                'end_time'   => $slotEndUtc->format('H:i:s'),
                            ])->exists();

                            if (!$exists) {
                                $newEntries[] = [
                                    'tutor_id'       => $tutor->id,
                                    'available_id'   => $avail->id,
                                    'start_time'     => $slotStartUtc->format('H:i:s'),
                                    'end_time'       => $slotEndUtc->format('H:i:s'),
                                    'date'           => $slotStartUtc->toDateString(),
                                    'day'            => $slotStartUtc->dayOfWeekIso,
                                    'booking_status' => 'NB',
                                    'created_at'     => now(),
                                    'updated_at'     => now(),
                                ];
                            }

                            $startTime = $slotEnd;
                        }
                    }
                }

                if (!empty($newEntries)) {
                    Tutor_calander_availability::insert($newEntries);
                    $this->info("Refreshed availability for tutor ID {$tutor->id}");
                }
            }
        }

        $this->info('Tutor availability refresh completed.');
    }
}