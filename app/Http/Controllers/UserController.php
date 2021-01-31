<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\Company;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * This is use to get us all users who are 
     * associated with companies in a given country
     *
     */ 
    public function userlist(){
    	$user=Users::with('Company')->whereHas('company.country', function($q){
		    $q->where('country_name','=', 'USA');
		})->get();
		dd($user);
    }

    /**
     * This is use to to display all company names 
     * the users associated with and dates when a user
     * was associated with a company
     *
     */ 
    public function companylist(){
    	$company=Company::with('user')->get();
		dd($company);
    }

}
