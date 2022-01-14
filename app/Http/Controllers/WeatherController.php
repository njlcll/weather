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
     * E.g /api/weather?city=Exeter
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function  show(Request $request)
    {       
        $api = env('OPEN_WEATHER_API');
      
        $city = "London";
        if ($request->has('city')) {
            $city = $request['city'];
        }

        $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
