<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SearchController extends Controller
{


    protected $newsApi;
    protected $category;


    public function index(Request $request)
    {
        $apiKey = 'ece69b0361e84e9989cb6651757a5d7c';
        $client = new Client([
            'base_uri' => 'https://newsapi.org/v2/',
            'verify' => true
        ]);

        $keyword = $request->q;
        $source = $request->source;
        $from = $request->from;
        $to = $request->to;
        $category = $request->category;

        $query = [
            'q' => $keyword,
            'apiKey' => $apiKey
        ];


        if ($from && $to) {
            $query['from'] = $from;
            $query['to'] = $to;
        }


        if ($source) {
            $query['source'] = $source;
        }


        $endpoint = 'everything';
        if ($category) {
            $endpoint = 'top-headlines';
            $query['category'] = $category;

        }

        if ($from && $to) {
            $query['sortBy'] = 'publishedAt';
        }

        $response = $client->request('GET', $endpoint, [
            'query' => $query
        ]);

        return $response->getBody();
    }




}
