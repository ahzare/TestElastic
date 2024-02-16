<?php

namespace App\Http\Controllers;

use Elastic\Elasticsearch\ClientBuilder;

class ClientController extends Controller
{
    protected $elasticsearch;

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

    public function index($size = 100)
    {
        $response = $this->elasticsearch->search(['size' => $size]);

        $list = collect($response['hits']['hits'])->pluck('_source')
            ->toArray();
        return view('index', compact('list'));
    }

    public function wordCloud()
    {
        $params = [
            'index' => 'docs',
            'body' => [
                'aggs' => [
                    'word_cloud' => [
                        'terms' => [
                            'field' => 'text',
                            'size' => 100
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->elasticsearch->search($params);

        $words = collect($response['aggregations']['word_cloud']['buckets'])
            ->toArray();

        return view('word_cloud', compact('words'));
    }
}
