<?php

namespace App\Console\Commands;

use App\CallRailService\Facades\CallRail;
use App\Models\Lead;
use Illuminate\Console\Command;

class CallRailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'callrail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $lead;
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching CallRail data...');

        $this->lead = Lead::latest()->select('lead_id','start_time')->first();
        if($this->lead) {
            $this->call_api(date('Y-m-d', strtotime($this->lead->start_time)));
        } else {
            $this->call_api(date('Y-10-d'));
        }

        $this->info('Data fetched and saved successfully.');
    }



    public function call_api($start_date, $offset = 0)
    {
        $data = CallRail::calls()->where(['start_date'=> $start_date, 'order' => 'asc'])->paginate(5, $offset);

        if($data['calls']) {
            foreach($data['calls'] as $item) {
                if($this->lead && $item['lead_id'] == $this->lead->lead_id) {
                    $this->update($item);
                } else {
                    $this->insert($item);
                }
            }
            return $this->call_api($start_date, $offset++);
        }
    }



    public function insert($data) {
        //dd($data);
        return Lead::create([
            'lead_id' => $data['id'],
            'start_time' => date('Y-m-d H:i:s', strtotime($data['start_time'])),
            'name' => $data['customer_name'],
            //'phone' => implode(',', [$data['business_phone_number'], $data['customer_phone_number'], $data['tracking_phone_number']]),
            'phone' => $data['customer_phone_number'],
            'city' => $data['customer_city'],
            'state' => $data['customer_state'],
            'status' => 'Waiting On Intake Status',
        ]);
    }

    public function update($data) {

        return Lead::where('lead_id', $this->lead->lead_id)->update([
            'start_time' => date('Y-m-d H:i:s', strtotime($data['start_time'])),
            'name' => $data['customer_name'],
            //'phone' => implode(',', [$data['business_phone_number'], $data['customer_phone_number'], $data['tracking_phone_number']]),
            'phone' => $data['customer_phone_number'],
            'city' => $data['customer_city'],
            'state' => $data['customer_state'],
        ]);

    }
}
