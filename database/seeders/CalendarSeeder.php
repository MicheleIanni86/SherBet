<?php

namespace Database\Seeders;
use App\Models\Calendar;
use App\Models\Team;
use Carbon\Doctrine\DateTimeDefaultPrecision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;
class CalendarSeeder extends Seeder
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
            $response = Http::withOptions(['verify' => false])->withHeaders($headers)->get(env('API_CALENDAR_URL'));

            if ($response->ok()) {
                $data = $response->json();
                $season_year = $data['parameters']['season'];
                $results = $data['response'];

                foreach ($results as $match) {
                    $new_match = new Calendar;
                    $new_match->season = $season_year;
                    $new_match->championship_id = $match['league']['id'];
                    $new_match->match_id = $match['fixture']['id'];
                    $date = Carbon::parse($match['fixture']['date'])-> format('Y-m-d H:i:s');
                    $new_match->match_date = $date;
                    $new_match->match_status = $match['fixture']['status']['short'];
                    $new_match->match_elapsed = $match['fixture']['status']['elapsed'];
                    $new_match->round =str_replace(' ', '', substr($match['league']['round'], -2)) ;
                    $new_match->home_team_id = $match['teams']['home']['id'];
                    $new_match->away_team_id = $match['teams']['away']['id'];
                    $new_match->home_goals = $match['goals']['home'];
                    $new_match->away_goals= $match['goals']['away'];
                     
                    $new_match->save();
                }
            } else {
                return response()->json(['message' => 'Errore nella richiesta all\'API esterna'], $response->status());
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
