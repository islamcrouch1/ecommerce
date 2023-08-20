<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Link;


class FrontController extends Controller
{
    public function index()
    {
        return view('front.home');
    }

    public function fqs()
    {
        return view('front.fqs');
    }

    public function terms()
    {
        return view('front.terms');
    }
    public function about()
    {
        return view('front.about');
    }
    public function strategy()
    {
        return view('front.strategy');
    }
    public function contact()
    {
        return view('front.contact');
    }


    public function steel()
    {
        return view('front.steel');
    }


    public function real()
    {
        return view('front.real');
    }


    public function currency()
    {
        return view('front.currency');
    }


    public function educational()
    {
        return view('front.educational');
    }

    public function photos()
    {
        return view('front.photos');
    }
    public function videos()
    {
        return view('front.videos');
    }
    public function careers()
    {
        return view('front.careers');
    }



    function aliexpress()
    {
        $url = 'https://ar.aliexpress.com/item/1005005491529196.html?pdp_ext_f=%7B%22ship_from%22:%22CN%22,%22sku_id%22:%2212000033292794209%22%7D&&scm=1007.28480.338741.0&scm_id=1007.28480.338741.0&scm-url=1007.28480.338741.0&pvid=3ed1320f-766b-4e9f-b35a-551e58d788cc&utparam=%257B%2522process_id%2522%253A%25221102%2522%252C%2522x_object_type%2522%253A%2522product%2522%252C%2522pvid%2522%253A%25223ed1320f-766b-4e9f-b35a-551e58d788cc%2522%252C%2522belongs%2522%253A%255B%257B%2522id%2522%253A%252232094162%2522%252C%2522type%2522%253A%2522dataset%2522%257D%255D%252C%2522pageSize%2522%253A%252210%2522%252C%2522language%2522%253A%2522ar%2522%252C%2522scm%2522%253A%25221007.28480.338741.0%2522%252C%2522countryId%2522%253A%2522EG%2522%252C%2522scene%2522%253A%2522SD-Waterfall%2522%252C%2522tpp_buckets%2522%253A%252221669%25230%2523265320%252339_21669%25234190%252319163%2523528_18480%25230%2523338741%25230_18480%25233885%252317679%252310%2522%252C%2522x_object_id%2522%253A%25221005005491529196%2522%257D&pdp_npi=3%40dis%21EGP%21EGP%204%2C938.21%21EGP%20444.41%21%21%21%21%21%40210321c616855936633354295ea7c0%2112000033292794209%21gsd%21%21&spm=a2g0o.11810135fornew.waterfall.0&aecmd=true';
        $response = Http::get($url);
        $html = $response->body();

        $crawler = new Crawler($html);

        // Wait for the product information to be loaded
        sleep(3); // Adjust the delay as needed

        $productData = $crawler->filter('script:contains("window.runParams")')->each(function ($node) {
            $scriptContent = $node->text();
            $jsonData = self::extractJsonData($scriptContent);


            if (!empty($jsonData)) {
                $title = $jsonData['data']['title'] ?? '';
                $price = $jsonData['data']['price'] ?? '';

                $images = array_column($jsonData['data']['imageModule']['imagePathList'], 'imageUrl') ?? [];

                $description = $jsonData['data']['descriptionModule']['description'] ?? '';

                return [
                    'title' => $title,
                    'price' => $price,
                    'images' => $images,
                    'description' => $description
                ];
            }

            return [];
        });

        return $productData[0] ?? [];
    }

    private static function extractJsonData($scriptContent)
    {
        $matches = [];
        preg_match('/(?<=window\.runParams = ).*?(?=;)/', $scriptContent, $matches);

        if (isset($matches[0])) {
            return json_decode($matches[0], true);
        }

        return [];
    }
}
