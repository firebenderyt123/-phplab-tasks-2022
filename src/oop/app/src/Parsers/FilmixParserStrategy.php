<?php

namespace src\oop\app\src\Parsers;

use src\oop\app\src\Models\Movie;

class FilmixParserStrategy implements ParserInterface
{

    protected const imagesFolder = __DIR__.'/../../../public/images';

    public function parseContent(string $siteContent): Movie
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML($siteContent);
        $xpath = new \DOMXPath($dom);

        $url = $xpath->query("//meta[@property='og:url']/@content")[0]->nodeValue;
        preg_match('/http[s]{0,1}:\/\/.*?(\/|$)/isu', $url, $site);
        $site = $site[0];

        $title = $xpath->query("//h1[@class='name']")[0]->nodeValue;

        $posterSrc = $xpath->query("//img[@class='poster poster-tooltip']/@src")[0]->nodeValue;

        preg_match('/http[s]{0,1}:\/\//isu', $posterSrc, $tmp);
        if (empty($tmp))
            $posterSrc = preg_replace('/(?<!:)\/{2,}/isu', '/', $site . $posterSrc);

        // download and save the image to the folder
        $path = $this::imagesFolder . "/" . basename($posterSrc);
        $file = file_get_contents($posterSrc);
        $insert = file_put_contents($path, $file);
        if (!$insert) {
            throw new \Exception('Failed to write image');
        }
        $poster = '/images/'.basename($posterSrc);

        $description = $xpath->query("//div[@class='full-story']")[0]->C14N();
        $description = preg_replace("/<(?'tag'[a-z]+?) .*?>|<\/(?&tag)>/isu", '', $description);

        $movie = new Movie();
        $movie->setTitle($title);
        $movie->setPoster($poster);
        $movie->setDescription($description);
        return $movie;
    }

}
