<?php


namespace Source\Support;

use Source\Models\Blog;

class Sitemap
{
    //SITEMAP
    private $sitemap;
    private $sitemapXml;
    private $sitemapGz;
    private $sitemapPing;

    //RSS
    private $rss;
    private $rssXml;

    public function exeSitemap($ping = true)
    {
        $this->SitemapUpdate();
        if ($ping != false):
            $this->SitemapPing();
        endif;
    }

    private function SitemapUpdate()
    {
        $this->sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
        $this->sitemap .= '<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>' . "\r\n";
        $this->sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\r\n";

        //HOME
        $this->sitemap .= '<url>' . "\r\n";
        $this->sitemap .= '<loc>' . CONF_SITE['NAME'] . '</loc>' . "\r\n";
        $this->sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . "\r\n";
        $this->sitemap .= '<changefreq>daily</changefreq>' . "\r\n";
        $this->sitemap .= '<priority>1.0</priority >' . "\r\n";
        $this->sitemap .= '</url>' . "\r\n";

        //POSTS
        $posts = (new Blog())->find()->order("id DESC")->fetch(true);
        if ($posts):
            foreach ($posts as $post):
                $this->sitemap .= '<url>' . "\r\n";
                $this->sitemap .= '<loc>' . url("/blog/{$post->uri}") . '</loc>' . "\r\n";
                $this->sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP', strtotime($post->created_at)) . '</lastmod>' . "\r\n";
                $this->sitemap .= '<changefreq>monthly</changefreq>' . "\r\n";
                $this->sitemap .= '<priority>0.5</priority >' . "\r\n";
                $this->sitemap .= '</url>' . "\r\n";
            endforeach;
        endif;

        //CLOSE
        $this->sitemap .= '</urlset>';

        //CRIA O XML
        $this->sitemapXml = fopen("sitemap.xml", "w+");
        fwrite($this->sitemapXml, $this->sitemap);
        fclose($this->sitemapXml);

        //CRIA O GZ
        $this->sitemapGz = gzopen("sitemap.xml.gz", 'w9');
        gzwrite($this->sitemapGz, $this->sitemap);
        gzclose($this->sitemapGz);
    }

    private function SitemapPing()
    {
        $this->sitemapPing = array();
        $this->sitemapPing['g'] = 'https://www.google.com/webmasters/tools/ping?sitemap=' . urlencode(url("/sitemap.xml"));
        $this->sitemapPing['b'] = 'https://www.bing.com/webmaster/ping.aspx?siteMap=' . urlencode(url("/sitemap.xml"));

        foreach ($this->sitemapPing as $url):
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            curl_close($ch);
        endforeach;
    }
}
