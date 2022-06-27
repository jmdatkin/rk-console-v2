<?php

namespace App\Mail;

use App\Carbon\RkCarbon;
use App\Models\Driver;
use App\Report\DriverReport;
use App\Repository\DriverRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DriverReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $report_data;
    public Driver $driver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct(DriverRepositoryInterface $driverRepository, DriverReport $report, $driver_id)
    public function __construct(Driver $driver)
    {
        //
        $this->driver = $driver;
        $this->report_data = resolve(DriverReport::class)->data(['driver_id' => $driver->id, 'weekday' => RkCarbon::today()->lowercaseDayName()]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.driverreport'); 
    }
}
