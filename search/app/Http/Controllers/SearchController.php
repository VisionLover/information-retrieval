<?php

namespace App\Http\Controllers;

use App\Record;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class SearchController extends Controller
{
    public function searching(Request $request)
    {
        $mysearch = $request->mysearch;
        $currentPage = $request->pagenumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $records = Record::search("$mysearch")->paginate();
        $count = Record::search("$mysearch")->count();
        $titles = array();
        $links = array();
        $citys = array();
        $companys = array();
        $times = array();
         foreach ($records as $record){
             array_push($titles,$record['title']);
             array_push($links,$record['link']);
             array_push($citys,$record['city']);
             array_push($companys,$record['company']);
             array_push($times,$record['time']);
         }
         return [$titles , $links , $citys , $companys , $times, $count, $mysearch];
    }

    public function suggest(Request $request)
    {
        $suggest_array = array();
        $suggest = $request->suggest;
        $data = [
            'body' => [
                'query' => [
                    "prefix" => [ "title" => "$suggest" ],
                ]
            ]
        ];
        $client = ClientBuilder::create()->build();
        $response = $client->search($data);
        $x = 0;
        $response_hits = $response["hits"]["hits"];
        foreach ($response_hits as $response_hit){
            array_push($suggest_array,$response_hit["_source"]["title"]);
            if($x == 4){
                break;
            }
            $x++;
        }
        return $suggest_array;
    }

}
