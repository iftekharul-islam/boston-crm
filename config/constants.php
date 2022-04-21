<?php
return [
    'image_file_size'                => [
        'min' => 100,
        'max' => 1024,
    ],
    'image_path_directory'           => 'public',
    'time_format'                    => [
        '24_hours'        => 'H:i',
        '12_hours'        => 'h:i A',
        '24_hours_second' => 'H:i:s',
    ],
    'date_format'                    => 'Y-m-d',
    'date_format_full_month_name'    => 'd F y',
    'date_format_month_type_1'       => 'd M y',
    'date_format_month_type_2'       => "d M'y",
    'date_format_only_day_and_month' => "d M",
    'date_with_24_hrs_time_format'   => 'Y-m-d H:i:s',
    'date_with_12_hrs_time_format'   => 'Y-m-d h:i A',
];
