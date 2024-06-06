<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScraperController extends Controller
{
    public function index()
    {
        $client = new Client();
        
        $website = $client->request('GET', 'https://www.webscraper.io/test-sites/e-commerce/static/computers/laptops?page=1');
        
        $title = [];
        $website->filter('.card.thumbnail')->each(function ($node) use (&$title) {

            $tdValues = $node->filter('.title')->each(function ($tdNode) {
                return trim($tdNode->text());
            });

            $title[] = $tdValues;
        });

        //dd($title);

        $description = [];
        $website->filter('.card.thumbnail')->each(function ($node) use (&$description) {

            $tdValues = $node->filter('.description.card-text')->each(function ($tdNode) {
                return trim($tdNode->text());
            });

            $description[] = $tdValues;
        });

        //dd($description);

        $price = [];
        $website->filter('.card.thumbnail')->each(function ($node) use (&$price) {

            $tdValues = $node->filter('.price.float-end.card-title.pull-right')->each(function ($tdNode) {
                return trim($tdNode->text());
            });

            $price[] = $tdValues;
        });

        dd($price);


        return view('index');
    }
}