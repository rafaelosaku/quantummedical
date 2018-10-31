<?php
require '_app/Config.inc.php';
?>
<!DOCTYPE html>
<html lang="pt-br" itemscope itemtype="https://schema.org/Article">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="uptec" content="https://www.upinside.com.br/s/RafaelOsaku">
        <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="<?= REQUIRE_PATH; ?>/img/icons/quantum-favicon.ico" />
        <link rel="stylesheet" type="text/css" href="<?= REQUIRE_PATH; ?>/css/style.css">
        <title><?= $pg_title; ?></title>
        <!--NORMAL PAGE-->
        <meta name="description" content="<?= $pg_desc; ?>"/>
        <meta name="robots" content="index, follow"/>

        <link rel="author" href="https://plus.google.com/<?= PG_GOOGLE_AUTHOR; ?>/posts"/>
        <link rel="publisher" href="https://plus.google.com/<?= PG_GOOGLE_PUBLISHER; ?>"/>
        <link rel="canonical" href="<?= $pg_url; ?>">
        <link rel="base" href="<?= HOME; ?>"/>
        <link rel="alternate" type="application/rss+xml" href="<?= HOME; ?>/rss.xml"/>

        <meta itemprop="name" content="<?= $pg_title; ?>"/>
        <meta itemprop="description" content="<?= $pg_desc; ?>"/>
        <meta itemprop="image" content="<?= $pg_image; ?>"/>
        <meta itemprop="url" content="<?= $pg_url; ?>"/>

        <!--FACEBOOK-->
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?= $pg_title; ?>" />
        <meta property="og:description" content="<?= $pg_desc; ?>" />
        <meta property="og:image" content="<?= $pg_image; ?>" />
        <meta property="og:url" content="<?= $pg_url; ?>" />
        <meta property="og:site_name" content="<?= $pg_site; ?>" />
        <meta property="og:locale" content="pt_BR" />
        <meta property="og:app_id" content="<?= PG_FB_APP; ?>" />
        <meta property="article:author" content="https://www.facebook.com/<?= PG_FB_AUTHOR; ?>" />
        <meta property="article:publisher" content="https://www.facebook.com/<?= PG_FB_PAGE; ?>" />

        <!--TWITTER-->
        <meta property="twitter:card" content="summary_large_image" />
        <meta property="twitter:site" content="<?= $pg_twitter; ?>" />
        <meta property="twitter:domain" content="<?= $pg_domain; ?>" />
        <meta property="twitter:title" content="<?= $pg_title; ?>" />
        <meta property="twitter:description" content="<?= $pg_desc; ?>" />
        <meta property="twitter:image:src" content="<?= $pg_image; ?>" />
        <meta property="twitter:url" content="<?= $pg_url; ?>" />     

        <!--[if lt IE 9]>
            <script src="<?= INCLUDE_PATH; ?>/js/html5shiv.js"></script>
        <![endif]-->   
        

    </head>
    <body>
    	<header class="main-header">

	    	<div class="content">
		    	<div class="logo-box">
		    		<div class="main-logo">
			    		<h1 class="fontzero">Quantum Medical</h1>
			    		<a href="<?= HOME; ?>">
		    				<img src="<?= REQUIRE_PATH; ?>/img/logo-300x100.PNG" alt="Home" title="Home">
		    			</a>
		    		</div><!-- main-logo -->
		    		<div class="menu-buttom-mobile">
	                    <i class="j_buttom buttom-mobile fa fa-bars"></i>
	                </div><!-- menu-buttom-mobile -->
                </div><!-- LOGO-BOX -->
            

	    		<div class="main-menu">
		    		<div class="content-menu">
		    			<ul class="menu-list">
		    				<li class="menu-item <?php if($Url[0] == 'quem-somos')echo 'menu-item-active'; ?>"><a class="menu-link" href="<?= HOME; ?>/quem-somos">Quem somos</a></li>
		    				<li class="menu-item <?php if($Url[0] == 'produtos')echo 'menu-item-active'; ?>"><a class="menu-link" href="<?= HOME; ?>/produtos">Produtos</a></li>
                            <li class="menu-item <?php if($Url[0] == 'contato')echo 'menu-item-active'; ?>"><a class="menu-link" href="<?= HOME; ?>/contato">Contato</a></li>
		    			</ul>
	    			</div>
	    		</div><!-- main-menu -->
    		</div><!-- CONTENT -->
    		
    	</header><!-- main-header -->
    	<!--CONTEUDO-->
        <?php
        $Url[1] = (empty($Url[1]) ? null : $Url[1]);

        if (file_exists(REQUIRE_PATH . '/' . $Url[0] . '.php')):
            require REQUIRE_PATH . '/' . $Url[0] . '.php';
        elseif (file_exists(REQUIRE_PATH . '/' . $Url[0] . '/' . $Url[1] . '.php')):
            require REQUIRE_PATH . '/' . $Url[0] . '/' . $Url[1] . '.php';
        else:
            require REQUIRE_PATH . '/404.php';
        endif;
        ?>
        <!--CONTEUDO-->
        <section class="share">
            <div class="content">
                <?php  
                require REQUIRE_PATH . '/inc/ShareBox.inc.php';
                ?>
            </div>
        </section>
        
        <footer class="main-footer">
    		<section>
	    		<div class="content">
	    			<h1 class="fontzero">Formas de contato</h1>
			        <article class="social">
			        	<h1 class="fontzero">Redes Sociais</h1>
				        
				            <ul class="social-list">
				                <li class="social-item"><a class="social-link" href="https://www.facebook.com/quantumlocacoes/?fref=ts" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</a></li>
				                <li class="social-item"><a class="social-link" href="#"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a></li>
				                <li class="social-item"><a class="social-link" href="https://www.instagram.com/explore/locations/1028277433/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></li>
				            </ul>
			            
			        </article><!-- social -->
					
			        <article class="contato">
			        	<!--<div class="content">-->
			        		<h1 class="fontzero">Telefones e E-mails:</h1>
				        	<ul class="contato-list">
				        		<li class="contato-item"><a class="contato-link" href="intent://send/+5515996484846#Intent;scheme=smsto;package=com.whatsapp;action=android.intent.action.SENDTO;end"><i class="fa fa-whatsapp" aria-hidden="true"></i> +55 15 99648-4846</a></li>
				        		<li class="contato-item"><a class="contato-link" href="tel:015996484846"><i class="fa fa-mobile" aria-hidden="true"></i> (15) 99648-4846</a></li>
				        		<li class="contato-item"><a class="contato-link" href="mailto:contato@quantummedical.com.br"><i class="fa fa-envelope" aria-hidden="true"></i> contato@quantummedical.com.br</a></li>
				        	</ul>
			        	<!--</div>-->
			        </article><!-- contato -->
                    
			        <article class="copy">
                        <h1 class="fontzero">Todos os direitos reservados</h1>
                        <p class="plast">&copy; <?= date('Y'); ?> - Quantum Medical, Todos os Direitos Reservados!</p>
                        <a class="copy-link" href="<?= HOME; ?>" title="Quantum Medical">www.quantummedical.com.br</a>         
                    </article><!-- copy -->
		        </div>
	        </section>  
	        <article class="dev" style="display:none">
        		<h1 class="fontzero">Rafael Osaku - Desenvolvedor Web</h1>
        		<p class="tagline">Desenvolvido por Rafael Osaku - contato@rafaelosaku.com.br</p>            
    		</article> 

		</footer>
        <script src="<?= INCLUDE_PATH; ?>/js/jquery.js"></script>
        <script src="<?= INCLUDE_PATH; ?>/js/owl.carousel.min.js"></script>
        <script src="<?= INCLUDE_PATH; ?>/js/picturefill.min.js"></script>
        <script src="<?= INCLUDE_PATH; ?>/js/quantum.js"></script>
        <script src="<?= INCLUDE_PATH; ?>/js/sharebox.js"></script>
    </body>
</html>
