<?php

namespace App\Helpers;

class ServiceFieldMap
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
      public static function fields(): array
    {
       return [
        1 => [
            'nid_number' => 'NID',
            'dob' => 'Date of Birth'
        ],
        2 => [
            'type' => 'Type',
            'type_name' => 'Name',
            'type_number' => 'Type No'
        ],
        3 => [
            'type_name' => 'Option',
            'type' => 'Type',
            'type_number' => 'Type No',
            'name' => 'Name'
        ],
        4 => [
            'type_name' => 'Option',
            'type' => 'Type',
            'type_number' => 'Type No',
            'name' => 'Name'
        ],
        5 => [
            'type' => 'Option',
            'description' => 'Data'
        ],
        6 => [
            'type' => 'Option',
            'description' => 'Data'

        ],
        7 => [
            'type' => 'Option',
            'type_number' => 'Number'
        ],
        8 => [
            'type' => 'Option',
            'type_number' => 'Number'
        ],
        9=> [
            'type' => 'Option',
            'type_number' => 'Number'
        ],
        10 => [
            'type' => 'Option',
            'type_number' => 'Number'
        ],
        11 => [
            'description' => 'Data',

        ],
        12 => [
            'type' => 'Option',
            'description'=> 'Data'
        ],
        13 => [
            'type' => 'Option',
            'description'=> 'Data'
        ],
        14 => [
            'type' => 'Option',
            'description'=> 'Data'
        ],

            // Add up to 26 types here
        ];
    }

}
