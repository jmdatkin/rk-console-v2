<?php

namespace App\Mail;

use App\Carbon\RkCarbon;
use App\Models\Driver;
use App\Report\DriverReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DriverReportEmailMdTest extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $report_data;
    public Driver $driver;

    public $theme = 'report';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct(DriverRepository $driverRepository, DriverReport $report, $driver_id)
    public function __construct(Driver $driver)
    {
        //
        $this->driver = $driver;
        $this->report_data = resolve(DriverReport::class)->data(['driver_id' => $driver->id, 'date' => RkCarbon::today()]);
    }
  

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.driverreportmd');
    }
}
