<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $headers = [
                'x-rapidapi-host' => env('X_RAPIDAPI_HOST'),
                'x-rapidapi-key' => env('X_RAPIDAPI_KEY')
            ];
            $response = Http::withOptions(['verify' => false])->withHeaders($headers)->get(env('API_TEAM_URL'));

            if ($response->ok()) {
                $data = $response->json();
                $results = $data['response'];

                foreach ($results as $team) {
                    $new_team = new Team;
                    $new_team->team_id = $team['team']['id'];
                    $new_team->team_name = $team['team']['name'];
                    $new_team->team_code = $team['team']['code'];
                    $new_team->logo = $team['team']['logo'];
                    $new_team->save();
                }
            } else {
                return response()->json(['message' => 'Errore nella richiesta all\'API esterna'], $response->status());
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
