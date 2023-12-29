<?php

namespace App\Http\Controllers;

use App\Raketech\FlagInterface;
use App\Raketech\FlagProviderInterface;
use Illuminate\Http\Request;

class FlagsController extends Controller
{
    public function __invoke(FlagProviderInterface $flagRequester)
    {
        $flagsArray = [];
        $flagsCollection = $flagRequester->provide();

        /** @var FlagInterface $flag */
        foreach ($flagsCollection as $flag) {
            $flagsArray[] = [
                'country_name' => $flag->getCountryName(),
                'url' => $flag->getUrl()
            ];
        }

        return response()->json($flagsArray);
    }
}
