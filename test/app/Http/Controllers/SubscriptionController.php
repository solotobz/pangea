<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SubscriptionController extends Controller
{

    public function subscription(Request $request, $topic)
    {
        $this->validate($request, [
            'url' => 'required|string'
        ]);

        try{
            $data = ['url' => $request->url, 'topic' => $topic];
        }catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['data' => $data], 200);
    }

    public function publish(Request $request, $topic)
    {
        $this->validate($request, [
            'key' => 'required'
        ]);

        try{
            $obj = $request->key; ///this get automatically converted to an array by laravel
            $client = new \GuzzleHttp\Client();
            $data = $client->request('POST', 'http://localhost:8888/subscribe/tobi',[
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "url" => "http://mysubscriber.test",
                ]
            ]);
            $info = json_decode($data->getBody(), true)['data'];
            $lik = $info['topic'];
            if (in_array($lik, $obj))
            {
                $data = 'hello';
            }
            else
            {
                $data = 'Not here';
            }
        }catch (\Exception $exception){
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 500);
        }
        return response()->json(['data' => $data], 200);
    }

    public function test($test)
    {
        dd($test);
    }

}
