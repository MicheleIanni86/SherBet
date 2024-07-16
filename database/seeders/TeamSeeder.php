<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

use function Termwind\terminal;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $client = new http\Client;
        // $request = new http\Client\Request;

        // $request->setRequestUrl('https://v3.football.api-sports.io/countries');
        // $request->setRequestMethod('GET');
        // $request->setHeaders(array(
        //     'x-rapidapi-host' => 'v3.football.api-sports.io',
        //     'x-rapidapi-key' => 'XxXxXxXxXxXxXxXxXxXxXxXx'
        // ));

        // $client->enqueue($request)->send();
        // $response = $client->getResponse();

        // echo $response->getBody();


        try {
            $headers = [
                'x-rapidapi-host' => 'v3.football.api-sports.io',
                'x-rapidapi-key' => '1cbe552513901b74becee58c0a547751'
            ];
            $response = Http::withOptions(['verify' => false])->withHeaders($headers)->get('https://v3.football.api-sports.io/teams?league=135&season=2024');

            if ($response->ok()) {
                $data = $response->json();
                $results = $data['response'];
                dump($results);
            } else {
                return response()->json(['message' => 'Errore nella richiesta all\'API esterna'], $response->status());
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
