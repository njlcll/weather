<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    //

     /**
     * Get the weather for the city in the url, If no city default to London
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function  show(Request $request)
    {       

        $city = "London";
        if ($request->has('city')) {
            $city = $request['city'];
        }

        $url = 'https://api.openweathermap.org/data/2.5/weather?q=$city&appid=31561143db5b3c69852203b4f28629ce';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Blindly accept the certificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
