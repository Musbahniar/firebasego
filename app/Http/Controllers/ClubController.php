<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use GuzzleHttp\Client;


class ClubController extends Controller
{
    public function store (Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://lumen-app-firebase-c884a.firebaseio.com/',
            // 'timeout'  => 2.0,
        ]);

        try {
          $response = $client->request('POST', 'clubs.json', [
            'json' => [
              'name' => $request->input('name'),
              'location' => $request->input('location'),
              'fans' => $request->input('fans')
            ]
          ]);

          $result = $response->getBody();

          $responseSuccess = [
            'status' => 'success',
            'data' => $result
          ];

          return (new Response ($responseSuccess, 200))->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
          $responseError = [
            'status' =>'failed',
            'messsage' => $e->getMessage()
          ];

          return (new Response ($responseError, 500))->header('Content-Type', 'application/json');
        }
    }
}
