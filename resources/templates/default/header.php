<!DOCTYPE html>
<html lang="<?= $attrLang ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Learning Resourse">
    <meta name="description" content="Learning Resourse">
    <title>Site description</title>


	<link href="<?= ROOT ?>/assets/css/default.css?ver=<?= time() ?>" rel="stylesheet">



    </head>
    <body>
      <div class="container">
        <?php if(@!$noTemplate): ?>
            <header class="main-header ">

                <nav class="main-header__nav ">


                    <div id="mainHeaderTouchBtn" class="main-header__touch-btn">
                        <div class="main-header__icon-bar"></div>
                        <div class="main-header__icon-bar"></div>
                        <div class="main-header__icon-bar"></div>
                    </div>

                     <ul id="mainHeaderMenu" class="main-header__menu" >
                         <li class="main-header__menu-item"><a href="/#"><?= $ourBrandL ?></a></li>
                         <li class="main-header__menu-item"><a href="/"><?= $mainPageL ?></a></li>
                    </ul>




                    <?php //get the given languages array
                    $langs = \Lib\HelperService::prozessLangArray(); ?>

                    <ul class="main-header__language-select"><?= \Lib\HelperService::getCurrentLanguageTitle() ?>
                        <div class="main-header__language-select-dropdown hidden">
                            <?php foreach($langs as $key => $value): ?>

                                <li><a href="/<?= \Lib\HelperService::overrideLangInUrl($key) ?>"><?= $value ?></a></li>
                            <?php endforeach; ?>
                        </div>
                    </ul>

                    <div id="mainHeaderSearchContainer" class="main-header__search-container" >
                        <span class="main-header__search-field-label"><?= $searchL ?></span>
                        <input type="text" name="search" id="mainHeaderSearchField" class="main-header__search-field" value=""  maxlength="20"  >
                    </div>

                    <div class="main-header__member-enter">
                        <?php if (@$_SESSION['member']): ?>
                            <a href="<?= \Lib\HelperService::currentLang() ?>/member/<?= $_SESSION['member'] ?>/edit"><?= $updateMemberL ?></a>
                            <a href="<?= \Lib\HelperService::currentLang() ?>/signOut"><?= $signOutL ?></a>
                        <?php else: ?>
                        <a href="<?= \Lib\HelperService::currentLang() ?>/signUp"><?= $signUpL ?></a>
                            <a href="<?= \Lib\HelperService::currentLang() ?>/signIn"><?= $signInL ?></a>
                        <?php endif; ?>
                    </div>

                 </nav>


            </header><!--/site-header-->
        <?php endif; ?>
       <section class="content">

