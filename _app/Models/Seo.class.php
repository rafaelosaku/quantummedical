<?php

/**
 * Seo [ MODEL ]
 * Classe de apoio para o modelo LINK. Pode ser utilizada para gerar SSEO para as páginas do sistema!
 * 
 * @copyright (c) 2016, Rafael Osaku Desenvolvimento
 */
class Seo {

    private $File;
    private $Link;
    private $Data;
    private $Tags;

    /* DADOS POVOADOS */
    private $SeoTags;
    private $SeoData;

    function __construct($File, $Link) {
        $this->File = strip_tags(trim($File));
        $this->Link = strip_tags(trim($Link));
    }

    public function getTags() {
        $this->checkData();
        return $this->SeoTags;
    }

    public function getData() {
        $this->checkData();
        return $this->SeoData;
    }

    /*
     * *******************************
     * ****** PRIVATE METHODS ********
     * *******************************
     */

    private function checkData() {
        if (!$this->SeoData):
            $this->getSeo();
        endif;
    }

    private function getSeo() {
        $ReadSeo = new Read;

        switch ($this->File):
            //SEO:: ARTIGO
            case 'artigo':
                $Admin = (isset($_SESSION['userlogin']['userlevel']) && $_SESSION['userlogin']['userlevel'] == 3 ? TRUE : FALSE);
                $Check = ($Admin ? '' : 'post_status = 1 AND');

                $ReadSeo->ExeRead('ws_posts', "WHERE {$Check} post_name = :link", "link=$this->Link");
                if (!$ReadSeo->getResult()):
                    $this->SeoData = NULL;
                    $this->SeoTags = NULL;
                else:
                    extract($ReadSeo->getResult()[0]);
                    $this->SeoData = $ReadSeo->getResult()[0];
                    $this->Data = [$post_title . ' - ' . SITENAME, $post_content, HOME . "/artigo/{$post_name}", HOME . "/uploads/{$post_cover}"];

                    //post:: conta views do post
                    $ArrUpdate = ['post_views' => $post_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate('ws_posts', $ArrUpdate, "WHERE post_id = :postid", "postid={$post_id}");

                endif;
                break;

            //SEO:: CATEGORIA
            case 'categoria':
                $ReadSeo->ExeRead('ws_categories', "WHERE category_name = :link", "link=$this->Link");
                if (!$ReadSeo->getResult()):
                    $this->SeoData = NULL;
                    $this->SeoTags = NULL;
                else:
                    extract($ReadSeo->getResult()[0]);
                    $this->SeoData = $ReadSeo->getResult()[0];
                    $this->Data = [$category_title . ' - ' . SITENAME, $category_content, HOME . "/categoria/{$category_name}", INCLUDE_PATH . '/images/site.png'];

                    //category:: conta views da categoria
                    $ArrUpdate = ['category_views' => $category_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate('ws_categories', $ArrUpdate, "WHERE category_id = :catid", "catid={$category_id}");

                endif;
                break;

            //SEO:: PESQUISA    
            case 'pesquisa':
                $ReadSeo->ExeRead('ws_posts', "WHERE post_status = 1 AND (post_title LIKE '%' :link '%' OR post_content LIKE '%' :link '%')", "link={$this->Link}");
                if (!$ReadSeo->getResult()):
                    $this->SeoData = NULL;
                    $this->SeoTags = NULL;
                else:
                    $this->SeoData['count'] = $ReadSeo->getRowCount();
                    $this->Data = ["Pesquisa por: {$this->Link}" . ' - ' . SITENAME, "Sua pesquisa por {$this->Link} retornou {$this->SeoData['count']} resultados.", HOME . "/pesquisa/{$this->Link}", INCLUDE_PATH . '/images/site.png'];
                endif;
                break;

            //SEO:: LISTA EMPRESAS
            case 'empresas':
                $Name = ucwords(str_replace("-", " ", $this->Link));
                $this->SeoData = ["categoria" => $this->Link,"empresa_cat" => $Name];
                $this->Data = ["Empresas {$this->Link}" . SITENAME, "Confira o guia completo de sua cidade, e encontre empresas {$this->Link}.", HOME . '/empresas/' . $this->Link, INCLUDE_PATH . '/images/site.png'];
                break;

            //SEO:: HOME - DEFAULT
            case 'index':
                $this->Data = [SITENAME . ' Seu guia de empresas, eventos e baladas!', SITEDESC, HOME, INCLUDE_PATH . '/images/site.png'];
                break;
            
            //SEO:: EMPRESA SINGLE
            case 'empresa':
                $Admin = (isset($_SESSION['userlogin']['userlevel']) && $_SESSION['userlogin']['userlevel'] == 3 ? TRUE : FALSE);
                $Check = ($Admin ? '' : 'empresa_status = 1 AND');

                $ReadSeo->ExeRead('app_empresas', "WHERE {$Check} empresa_name = :link", "link=$this->Link");
                if (!$ReadSeo->getResult()):
                    $this->SeoData = NULL;
                    $this->SeoTags = NULL;
                else:
                    extract($ReadSeo->getResult()[0]);
                    $this->SeoData = $ReadSeo->getResult()[0];
                    $this->Data = [$empresa_title . ' - ' . SITENAME, $empresa_sobre, HOME . "/empresa/{$empresa_name}", HOME . "/uploads/{$empresa_capa}"];

                    //post:: conta views da empresa
                    $ArrUpdate = ['empresa_views' => $empresa_views + 1];
                    $Update = new Update();
                    $Update->ExeUpdate('app_empresas', $ArrUpdate, "WHERE empresa_id = :empresaid", "empresaid={$empresa_id}");

                endif;
                break;

            //SEO:: 404
            default :
                $this->Data = ['Opsss! Nada encontrado' . SITENAME, SITEDESC, HOME . '/404', INCLUDE_PATH . '/images/site.png'];
        endswitch;

        if ($this->Data):
            $this->setTags();
        endif;
    }

    private function setTags() {
        $this->Tags['Title'] = $this->Data[0];
        $this->Tags['Content'] = Check::Words(html_entity_decode($this->Data[1]), 25);
        $this->Tags['Link'] = $this->Data[2];
        $this->Tags['Image'] = $this->Data[3];

        $this->Tags = array_map('strip_tags', $this->Tags);
        $this->Tags = array_map('trim', $this->Tags);

        $this->Data = NULL;

        //NORMAL PAGE
        $this->SeoTags = '<title>' . $this->Tags['Title'] . '</title>' . "\n";
        $this->SeoTags .= '<meta name="decription" content="' . $this->Tags['Content'] . '"/>' . "\n";
        $this->SeoTags .= '<meta name="robots" content="index, follow"/>' . "\n";

        $this->SeoTags .= '<link rel="canonical" href="' . $this->Tags['Link'] . '"/>' . "\n";
        $this->SeoTags .= '<link rel="author" href="https://plus.google.com/' . PG_GOOGLE_AUTHOR . '"/>' . "\n";
        $this->SeoTags .= "\n";

        $this->SeoTags .= '<meta itemprop="name" content="' . $this->Tags['Title'] . '"/>' . "\n";
        $this->SeoTags .= '<meta itemprop="description" content="' . $this->Tags['Content'] . '"/>' . "\n";
        $this->SeoTags .= '<meta itemprop="image" content="' . $this->Tags['Image'] . '"/>' . "\n";
        $this->SeoTags .= '<meta itemprop="url" content="' . $this->Tags['Link'] . '"/>' . "\n";
        $this->SeoTags .= "\n";

        //FACEBOOK
        $this->SeoTags .= '<meta property="og:type" content="article" />';
        $this->SeoTags .= '<meta property="og:title" content="' . $this->Tags['Title'] . '" />' . "\n";
        $this->SeoTags .= '<meta property="og:description" content="' . $this->Tags['Content'] . '" />' . "\n";
        $this->SeoTags .= '<meta property="og:image" content="' . $this->Tags['Image'] . '" />' . "\n";
        $this->SeoTags .= '<meta property="og:url" content="' . $this->Tags['Link'] . '" />' . "\n";
        $this->SeoTags .= '<meta property="og:site_name" content="' . SITENAME . '" />' . "\n";
        $this->SeoTags .= '<meta property="og:locale" content="pt_BR" />' . "\n";
        $this->SeoTags .= '<meta property="og:app_id" content="' . PG_FB_APP . '" />' . "\n";
        $this->SeoTags .= '<meta property="article:author" content="https://www.facebook.com/' . PG_FB_AUTHOR . '" />' . "\n";
        $this->SeoTags .= '<meta property="article:publisher" content="https://www.facebook.com/' . PG_FB_PAGE . '" />' . "\n";
        $this->SeoTags .= "\n";

        //TWITTER
        $this->SeoTags .= '<meta property="twitter:title" content="' . $this->Tags['Title'] . '" />' . "\n";
        $this->SeoTags .= '<meta property="twitter:description" content="' . $this->Tags['Content'] . '" />' . "\n";
        $this->SeoTags .= '<meta property="twitter:image:src" content="' . $this->Tags['Image'] . '" />' . "\n";
        $this->SeoTags .= '<meta property="twitter:url" content="' . $this->Tags['Link'] . '" />' . "\n";

        $this->Tags = NULL;
    }

}
