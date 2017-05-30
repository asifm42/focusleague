<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameScoreController extends Controller
{
    public function edit(Request $request, $id)
    {
        // find game
        $game = Game::findOrFail($id);

        return view('games.edit')->withGame($game);
        // add score
        // $game->teams()->updateExistingPivot($team->id)
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        foreach($request->score as $teamId => $points)
        {
            $game->score($teamId, $points);
        }

        flash()->success('score updated');

        return view('games.edit')->withGame($game);
    }
}
