<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScraperController extends Controller
{    
    public function index()
    {
        $url = [
            ['https://www.webscraper.io/test-sites/e-commerce/static/computers/laptops?page=', 20],
            ['https://www.webscraper.io/test-sites/e-commerce/static/computers/tablets?page=', 4],
            ['https://www.webscraper.io/test-sites/e-commerce/static/phones/touch?page=', 2] 
        ];

        $title = [];
        $description = [];
        $price = [];

        $client = new Client();

        for($j = 0; $j < 3; $j++)
        {
            $max_page = 0;
            $url = '';

            if($j == 0)
            {
                $max_page = 20;
                $url = 'https://www.webscraper.io/test-sites/e-commerce/static/computers/laptops?page=';
            }
            else if($j == 1)
            {
                $max_page = 4;
                $url = 'https://www.webscraper.io/test-sites/e-commerce/static/computers/tablets?page=';
            }
            else
            {
                $max_page = 2;
                $url = 'https://www.webscraper.io/test-sites/e-commerce/static/phones/touch?page=';
            }

            for ($x = 1; $x <= $max_page; $x++) {
                $url_2 = $url. (string)$x;
    
                $website = $client->request('GET', $url_2);
            
                $website->filter('.card.thumbnail')->each(function ($node) use (&$title) {
    
                    $tdValues = $node->filter('.title')->each(function ($tdNode) {
                        return trim($tdNode->text());
                    });
    
                    $title[] = $tdValues;
                });
    
                //dd($title);
    
                $website->filter('.card.thumbnail')->each(function ($node) use (&$description) {
    
                    $tdValues = $node->filter('.description.card-text')->each(function ($tdNode) {
                        return trim($tdNode->text());
                    });
    
                    $description[] = $tdValues;
                });
    
                //dd($description);
    
                $website->filter('.card.thumbnail')->each(function ($node) use (&$price) {
    
                    $tdValues = $node->filter('.price.float-end.card-title.pull-right')->each(function ($tdNode) {
                        return trim($tdNode->text());
                    });
    
                    $price[] = $tdValues;
                });
    
                //dd($price);
    
            }
        }

        //dd($title);
        

        return view('index', ['title' => $title, 'description' => $description, 'price' => $price]);
    }
}