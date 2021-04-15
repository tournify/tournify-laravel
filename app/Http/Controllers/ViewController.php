<?php
/**
 * @author    Markus Tenghamn
 * @copyright 2021 GAIA AG, Hamburg
 * @package   tournify
 *
 * Created using PhpStorm at 02.03.21 03:36
 */

namespace App\Http\Controllers;


class ViewController extends Controller
{
    public function legalTerms() {
        return view('legal.terms');
    }

    public function legalPrivacy() {
        return view('legal.privacy');
    }

    public function welcome() {
        return view('welcome')->with(array('tournaments' => \App\Tournament::orderBy('created_at','desc')->take(5)->get()));
    }
}