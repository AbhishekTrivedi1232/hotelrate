<?php

use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=new \App\Hotel(array(
            "hotel_name"        =>"Siddhivinayak",
            "hotel_star"       =>"3",
            "hotel_address"     =>"Bhudhel Chowkadi"
        ));
        $data->save();
        $data=new \App\Hotel(array(
            "hotel_name"        =>"Rasoi",
            "hotel_star"       =>"4",
            "hotel_address"     =>"Kalanala"
        ));
        $data->save();
            $data=new \App\Hotel(array(
            "hotel_name"        =>"Rangoli",
            "hotel_star"       =>"5",
            "hotel_address"     =>""
        ));
        $data->save();
        $data=new \App\Hotel(array(
            "hotel_name"        =>"City Pride",
            "hotel_star"       =>"7",
            "hotel_address"     =>""
        ));
        $data->save();
    }
}
