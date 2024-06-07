<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agentdetails_model extends Model
{
    use HasFactory;

    protected $table = 'agentdetails';

    public static function checkIfExists($email, $mobileNumber)
    {
        return self::where('email', $email)
            ->orWhere('mobile_number', $mobileNumber)
            ->count();
    }

    public static function insertAgentData($agentdata)
    {
        return self::insert($agentdata);
    }

    public static function checkEmail($email)
    {
        return self::where('email', $email)
            ->count();
    }

    public static function checkEmailaddress($email)
    {
        return self::where('email', $email)
            ->count();
    }

    public static function checkMobileno($Mobile_number)
    {
        return self::where('mobile_number', $Mobile_number)
            ->count();
    }

    // -------------------------------------------------------------

    public static function updateData($Id, $Updateagentdata)
    {
        return self::where('id', $Id)
            ->update($Updateagentdata);
    }

    public static function delete_Data($Id)
    {
        return self::where('id', $Id)
            ->delete();
    }

    // public static function get_Data()
    // {
    //     return self::all();
    // }

    public static function get_Data()
    {
        return self::select('*')->get();
    }

    public static function getDataById($agentId)
    {
        return self::where('id', $agentId)
            ->get();
    }

    //--------------pass the collge name get the city----------------------------------

    public static function getCity($collegename)
    {
        return self::join('college', 'college.cityid', '=', 'city.id')
            ->where('college.collegename', $collegename)
            ->select('city.name')
            ->first();
    }

    public static function getCityCoursename($collegename)
    {
        return self::join('college', 'college.cityid', '=', 'city.id')
            ->where('college.collegename', $collegename)
            ->select('city.name')
            ->orderBy('city.name')
            ->first();
    }

    public static function getCourseById($collegename)
    {
        return self::join('college', 'college.cityid', '=', 'city.id')
            ->where('college.collegename', $collegename)
            ->select('city.name')
            ->orderBy('city.name')
            ->first();
    }

    
}
