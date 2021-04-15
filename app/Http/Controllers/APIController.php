<?php
/**
 * @author    Markus Tenghamn
 * @copyright 2020 GAIA AG, Hamburg
 * @package   tournify
 *
 * Created using PhpStorm at 01.03.20 21:58
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class APIController extends Controller
{
    function user(Request $request) {
        return $request->user();
    }
}