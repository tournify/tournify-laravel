<?php
/**
 * @author    Markus Tenghamn
 * @copyright 2020 GAIA AG, Hamburg
 * @package   tournify
 *
 * Created using PhpStorm at 01.03.20 22:01
 */

namespace App\Http\Controllers;


class ChannelController extends Controller
{
    function user($user, $id) {
        return (int) $user->id === (int) $id;
    }
}