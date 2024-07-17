<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class PlayerSeeder extends Seeder
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
            $response = Http::withOptions(['verify' => false])->withHeaders($headers)->get(env('API_PLAYER_URL'));

            if ($response->ok()) {
                $first_data = $response->json();
                $page = 1;
                $total = $first_data['paging']['total'];

                while ($page <= $total) {
                    $string_page = strval($page);
                    $newUrl = env('API_PLAYER_URL') . '&page=' . $string_page;
                    $single_call_response = Http::withOptions(['verify' => false])->withHeaders($headers)->get( $newUrl );
                    $data = $single_call_response->json();
                    $results = $data['response'];
                    foreach ($results as $player) {
                        $new_player = new Player;
                        $new_player->player_id = $player['player']['id'];
                        $new_player->team_id = $player['statistics'][0]['team']['id'];
                        $new_player->lastname = $player['player']['lastname'];
                        $new_player->photo = $player['player']['photo'];
                        $new_player->position = $player['statistics'][0]['games']['position'];
                        $new_player->save();
                    }
                    $page++;
                }
            } else {
                return response()->json(['message' => 'Errore nella richiesta all\'API esterna'], $response->status());
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
