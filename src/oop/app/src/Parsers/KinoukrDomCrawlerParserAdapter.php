<?php

namespace src\oop\app\src\Parsers;

use Symfony\Component\DomCrawler\Crawler;
use src\oop\app\src\Models\Movie;

class KinoukrDomCrawlerParserAdapter implements ParserInterface
{

    protected const imagesFolder = __DIR__.'/../../../public/images';

    public function parseContent(string $siteContent): Movie
    {
        $crawler = new Crawler($siteContent);
        $url = $crawler->filterXpath("//link[@rel='canonical']")->first()->attr('href');
        preg_match('/http[s]{0,1}:\/\/.*?(\/|$)/isu', $url, $site);
        $site = $site[0];

        $title = $crawler->filterXpath("//div[@id='fheader']/h1")->first()->text();

        $posterSrc = $crawler->filterXpath("//div[@class='fposter']/a/img")->extract(array('src'))[0];

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

        $description = $crawler->filterXpath("//div[@id='fdesc']")->first()->html();

        // remove container html tag
        $description = preg_replace("/<(?'tag'[a-z]+?) .*?>|<\/(?&tag)>/isu", '', $description);

        // remove h[1-6] tags from description
        $description = preg_replace("/<(?'tag'h[1-6]).*?>.*?<\/(?&tag)>/isu", '', $description);

        $movie = new Movie();
        $movie->setTitle($title);
        $movie->setPoster($poster);
        $movie->setDescription($description);
        return $movie;
    }

}
