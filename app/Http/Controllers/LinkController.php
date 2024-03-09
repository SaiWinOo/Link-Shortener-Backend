<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;

class LinkController extends Controller
{
    function random_string($string_length = 6) {
    $random_string = "";
    $random_characters = array_merge(range('0', '9'), range('A', 'Z'), range('a', 'z'));
    $max = count($random_characters) - 1;
    for ($i = 0; $i < $string_length; $i++) {
        $random_string .= $random_characters[rand(0, $max)];
    }
    return $random_string;
}

    public function store(StoreLinkRequest $request)
    {
        $link = $this->generateIfExist();
        Link::create([
            'long' => $request->url,
            'short' => $link,
        ]);
        return response()->json([
            'link' => env('APP_URL') . $link,
        ]);
    }

    public function generateIfExist()
    {
        $link = $this->random_string(6);
        if (Link::whereRaw('BINARY short = ?', [$link])->first()) {
            $this->generateIfExist();
        }else{
            return $link;
        }
    }


    public function redirectLink()
    {
        $requestedLink = str_replace('/','', request()->getRequestUri());
        $link = Link::whereRaw('BINARY short = ?', [$requestedLink])->first();
        if($link){
            return redirect($link->long);
        }else{
            return abort(404);
        }
    }
}
