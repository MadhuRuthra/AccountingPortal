<?php

namespace App\Imports;
use App\Models\Call;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel
{

    protected $schedule_at, $context, $caller_id, $time_interval, $file_count, $input_file_path, $output_file_pat, $campaign;
	 protected $mobileNumbers = [];

    public function __construct($schedule_at, $context, $caller_id, $time_interval, $file_count, $input_file_path, $output_file_path, $campaign)
    {
     	$this->schedule_at=$schedule_at;
        $this->context=$context;
        $this->caller_id=$caller_id;
        $this->time_interval=$time_interval;
        $this->file_count=$file_count;
        $this->input_file_path=$input_file_path;
        $this->output_file_path=$output_file_path;
      $this->campaign=$campaign;
    }

    public function model(array $row)
    {
     /*	return new Call([
            'mobile'=> $row[0],
            'schedule_at' => $this->schedule_at,
            'context' => $this->context,
            'caller_id' => $this->caller_id,
            'time_interval' => $this->time_interval,
            'file_count' => $this->file_count,
            'input_file_path' => $this->input_file_path,
            'output_file_path' => $this->output_file_path,
             'campaign' => $this->campaign
        ]);
    }
}*/

	
        $mobileNumber = $row[0];

        // Check if mobile number is already in the array of seen mobile numbers
        if (in_array($mobileNumber, $this->mobileNumbers)) {
            // Skip row if mobile number is a duplicate
            return;
        }

        // Add mobile number to array of seen mobile numbers
        $this->mobileNumbers[] = $mobileNumber;
      
    $call= new Call([
        'mobile' => $mobileNumber,
    'schedule_at' => $this->schedule_at,
    'context' => $this->context,
        'caller_id' => $this->caller_id,
        'time_interval' => $this->time_interval,
        'file_count' => $this->file_count,
        'input_file_path' => $this->input_file_path,
        'output_file_path' => $this->output_file_path,
        'campaign' => $this->campaign
    ]);
    $call->save();
    
}
public function rules(): array
{
    return [
        '*.0' => [
            'required',
            Rule::unique('calls', 'mobile')->ignore($this->mobileNumbers)
        ]
    ];
}
}


