<?php

namespace App\Http\Controllers;

use Elastic\Elasticsearch\ClientBuilder;

class ClientController extends Controller
{
    protected $elasticsearch;
    protected $elastica;

    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()
            ->setBasicAuthentication('elastic', 'q4G2tEOOV=2Ku*HFkoyR')->build();
    }

    public function importData()
    {
        $path = public_path() . "/data.json";
        $json = json_decode(file_get_contents($path), true);

        $param = [];
        foreach ($json as $item) {
            $param['body'][] = [
                'index' => [
                    '_index' => 'docs',
                ]
            ];

            $param['body'][] = [
                'text' => $item['text'],
            ];
        }
        return response()->json($this->elasticsearch->bulk($param));
    }
}
