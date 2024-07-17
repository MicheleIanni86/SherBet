@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="d-flex gap-4 mb-3">
            @foreach ($days_array as $day)
                <li class="button" id="{{ $day }}">{{ $day }}</li>
            @endforeach
        </ul>

    </div>
    <div class="container">
        <ul id="match-list">
            @foreach ($first_day as $match)
                <li>{{ $match->home_team_id }} vs {{ $match->away_team_id }}</li>
            @endforeach
        </ul>
    </div>

    <script>
        const buttons = document.querySelectorAll(".button");
        buttons.forEach((button, index) => {
            button.addEventListener('click', (e) => {
                filterMatch(e.target.id);
            })
        })

        function filterMatch(id) {
            axios.post('/admin/filter', {
                filter: id,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }).then(function(response) {
                const matchList = document.getElementById('match-list');
                matchList.innerHTML = "";
                const arrayObj = [];

                for (const key in response.data) {
                    const match = response.data[key];
                    arrayObj.push({
                        id: key,
                        home_team_id: match.home_team_id,
                        away_team_id: match.away_team_id
                    });

                    const li = document.createElement('li');
                    li.innerText = `${match.home_team_id} vs ${match.away_team_id}`;
                    matchList.appendChild(li);

                }
            }).catch((error) => {
                console.log(error);
            })

        }
    </script>
@endsection
