<!DOCTYPE html>
<html data-wf-page="averroes651fba54cf5533331" data-wf-site="averroes651fba54cf5533331">
<!-- <html data-wf-page="averroescf5533331be57e30" data-wf-site="averroescf5533331be57e03"> -->

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    @include('layouts.layout_partials.seo')
    {{-- <link href="assets/css/app.css" rel="stylesheet" type="text/css"> --}}
    <link rel="shortcut icon" href="{{ asset('averroes.svg') }}" type="image/x-icon">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">

</head>

<body>
    <div class="page-wrapper">
        <div class="w-embed">

        </div>
        <!-- NAVBAR -->
        <div data-w-id="navbar8e5a9691" data-animation="default" data-collapse="all" data-duration="400"
            data-easing="ease" data-easing2="ease" role="banner" class="navbar w-nav">
            <div class="navbar-container">
                <a href="{{ route('login.index') }}" aria-current="page" class="navbar-logo w-nav-brand w--current">
                    <div class="navbar-logo__image-wrapper">
                        <img src="assets/img/logo-color.png" loading="lazy" alt="" class="navbar-logo__image"
                            style="width: 70px; height: 55px;">
                    </div>
                </a>
                <div class="navbar-menu">
                    <div data-lenis-prevent="" class="navbar-menu__content">
                        <ul role="list" class="navbar-menu__list">
                            <li class="navbar-menu_list-item">
                                <a nav-animation="" href="#home" class="nav-link w-nav-link">Beranda</a>
                            </li>
                            <li class="navbar-menu_list-item">
                                <a nav-animation="" href="#pendaftaran" class="nav-link w-nav-link">Pendaftaran</a>
                            </li>
                            <li class="navbar-menu_list-item">
                                <a nav-animation="" href="#fasilitas" class="nav-link w-nav-link">Fasilitas</a>
                            </li>
                            <li class="navbar-menu_list-item">
                                <a nav-animation="" href="{{ route('login.index') }}"
                                    class="nav-link w-nav-link">Login</a>
                            </li>

                        </ul>
                        <div class="navbar-menu__content-right">
                            <ul role="list" class="navbar-menu__list is--small">
                                <li class="navbar-menu_list-item"><a href="mailto:islamicschoolaverroes@gmail.com"
                                        class="underlined-link is--nav">islamicschoolaverroes@gmail.com</a></li>
                                <li class="navbar-menu_list-item"><a href="tel:6288999999744"
                                        class="underlined-link is--nav">0889 9999
                                        9744</a></li>
                            </ul>
                            <p>Perumahan Permata Jingga <br> Blok Pinang No.5, Tunggulwulung, <br> Kec. Lowokwaru, Kota
                                Malang, Jawa
                                Timur 65141</p>
                            <ul id="navsocial" role="list" class="navbar-menu__list is--small is--bottom">
                                <li class="navbar-menu_list-item"><a href="https://instagram.com/averroes.is/"
                                        target="_blank" class="underlined-link is--nav">instagram</a></li>
                                <li class="navbar-menu_list-item"><a href="https://ppdb.averroesinsanmulia.com/"
                                        target="_blank" class="underlined-link is--nav">Website</a></li>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="navbar-controllers">
                    <div id="nav-button" class="navbar-menu__open-button w-nav-button">
                        <div class="navbar-menu__button-open">
                            <div data-w-id="29c5de8c-9698-a2ac-267a-e6e99eb63683" class="navbar-menu__button-line">
                            </div>
                            <div data-w-id="5cb0fb52-3954-54ce-fc09-c10d2b4303c8" class="navbar-menu__button-line">
                            </div>
                            <div data-w-id="9b79f3ab-026b-1302-4a40-52755f518f57" class="navbar-menu__button-line">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / NAVBAR -->
        <!-- MAIN -->
        <main class="main-wrapper" id="home">
            <section class="section is--hero">
                <div class="hero-padding">
                    <div class="hero-content__top">
                        <div class="hero-heading">
                            <h1 class="h1--test">Jiwanya Santri <br> Skillnya IT
                        </div>
                    </div>
                    <div class="hero-background">
                        <img src="{{ asset('assets/img/logo-white.png') }}" alt=""
                            class="customize-content__image is--hero">
                        <div scroll-start="top top" class="sections-wrapper" floating-zeros="3" data-loop="false"
                            total-frames="90" id="scrollElement" scroll-end="center top" url-end=".webp">
                            <div class="canvas-abs">
                                <div class="canvas-wrapper embed w-embed"><canvas></canvas></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="about-padding">
                    <div class="about-content__top">
                        <div class="about-content__top-text-wrapper">
                            <p from-bottom="" class="about-content__top-text negative-text">averroes digital <br>
                                islamic school</p>
                            <div from-bottom="" class="about-content__top-heading">
                                <div class="h2-primary is--about__heading-quote">‘</div>
                                <h2 class="h2-primary is--about__top-heading">Santri bisa Ngoding’ <br>averroes dongg!
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="content-full__asset">
                        <img src="{{ asset('assets/img/averroes-front.jpg') }}" loading="lazy" alt=""
                            sizes="100vw" class="content-full__asset-image is--desktop">
                        <img src="{{ asset('assets/img/averroes-front.jpg') }}" loading="lazy" alt=""
                            sizes="100vw" class="content-full__asset-image is--mob">
                        <div class="triangle-wrapper">
                            <div class="triangle-vector w-embed"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="100%" height="100%" viewbox="0 0 111 110" fill="none">
                                    <path
                                        d="M103.79 3.82669L3.23095 104.222C1.79552 105.796 1 110.005 1 110.005H0V0.00472293C34.6811 -0.00858413 92.5189 0.0111679 110.123 0.00441336V1.00425C110.123 1.02016 110.11 1.03305 110.094 1.0331C107.694 1.04116 105.407 2.05438 103.79 3.82669Z"
                                        fill="#D2D2D2"></path>
                                </svg></div>
                        </div>
                        <div class="triangle-vector is--bottom w-embed"><svg xmlns="http://www.w3.org/2000/svg"
                                width="100%" height="100%" viewbox="0 0 111 110" fill="none">
                                <path
                                    d="M103.79 3.82669L3.23095 104.222C1.79552 105.796 1 110.005 1 110.005H0V0.00472293C34.6811 -0.00858413 92.5189 0.0111679 110.123 0.00441336V1.00425C110.123 1.02016 110.11 1.03305 110.094 1.0331C107.694 1.04116 105.407 2.05438 103.79 3.82669Z"
                                    fill="#D2D2D2"></path>
                            </svg></div>
                        <div class="image-mask mask--vertical-full"></div>
                        <div class="image-mask mask--horizontal-full"></div>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="about-padding">
                    <div class="about-content__top">
                        <div
                            style="text-align: center; margin: 0 clamp(1rem, 1.5vw, 1.5rem); font-size: clamp(1rem, 1.5vw, 1.5rem);">
                            <h2>AVERROES DIGITAL ISLAMIC SCHOOL</h2>
                            <p style="margin-top: 2rem;">
                                Averroes Digital Islamic School merupakan sebuah lembaga pendidikan pesantren formal
                                setara SMA/SMK yang
                                dirancang untuk melahirkan genarasi Qur'ani yang ahli di bidang IT. Averroes Digital
                                Islamic School
                                memiliki moto yaitu "Jiwanya Santri, Skillnya IT. Agar terwujud generasi yang "Jiwanya
                                Santri, Skillnya
                                IT maka Averroes Digital Islamic School mengadopsi beberapa kurikulum yang menjadi acuan
                                dalam Proses
                                pembelajarannya.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="about-padding">
                    <div class="about-content__top">
                        <h2 class="h2-primary is--about__top-heading" style="text-align: center;"><span
                                class="h2-secondary">Kenapa</span> Averroes?
                        </h2>
                        <div>

                        </div>
                        <div class="step-content__grid_2" style="margin-top: 4rem; justify-content: center; ">
                            <div class="step-content__grid-item">
                                <div class="step-grid__item-content_2">
                                    <div class="step-grid__item-content-top">
                                        <i class="fa-solid fa-house-laptop"
                                            style="font-size: 2rem; background-color:var(--colors-averroes); padding: 1.5rem; border-radius: 1rem;"></i>
                                    </div>
                                    <p style="font-size: 1rem;">Fasilitas yang lengkap dan modern.</p>
                                </div>
                            </div>
                            <div class="step-content__grid-item">
                                <div class="step-grid__item-content_2">
                                    <div class="step-grid__item-content-top">
                                        <i class="fa-solid fa-chalkboard-user"
                                            style="font-size: 2rem; background-color:var(--colors-averroes); padding: 1.5rem; border-radius: 1rem;"></i>
                                    </div>
                                    <p style="font-size: 1rem;">Guru-guru yang profesional dan berpengalaman.</p>
                                </div>
                            </div>
                            <div class="step-content__grid-item">
                                <div class="step-grid__item-content_2">
                                    <div class="step-grid__item-content-top">
                                        <i class="fa-solid fa-book"
                                            style="font-size: 2rem; background-color:var(--colors-averroes); padding: 1.5rem; border-radius: 1rem;"></i>
                                    </div>
                                    <p style="font-size: 1rem;">Kurikulum yang terintegrasi antara ilmu umum dan agama.
                                    </p>
                                </div>
                            </div>
                            <div class="step-content__grid-item is--last">
                                <div class="step-grid__item-content_2">
                                    <div class="step-grid__item-content-top">
                                        <i class="fa-solid fa-code"
                                            style="font-size: 2rem; background-color:var(--colors-averroes); padding: 1.5rem; border-radius: 1rem;"></i>
                                    </div>
                                    <p style="font-size: 1rem;">Program unggulan coding dan programming.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section horizontal-section">
                <h2 class="h2-secondary" style="text-align: center;">Ikuti!</h2>
                <div class="horizontal-sticky">
                    <div class="horizontal-container">
                        <div class="horizontal-sticky__content">
                            <div data-w-id="fbce3be2-59de-e55c-35a0-747954d4003e" class="horizontal-item is--first">
                                <div class="horizontal-item__heading">
                                    <h3 class="h3-primary">Daftar</h3>
                                    <div class="subtitle horizontal-item__subtitle">1</div>
                                </div>
                                <div class="horizontal-item__images-wrapper is--first">
                                    <div class="horizontal-item__image-1"><img
                                            src="{{ asset('assets/img/slide-item-2.webp') }}"
                                            loading="lazy" alt="" class="image-full is--parallax"></div>
                                    <div class="horizontal-item__image-2"><img
                                            src="{{ asset('assets/img/slide-item-1.webp') }}"
                                            loading="lazy" alt="" class="image-full is--parallax"></div>
                                </div>
                            </div>
                            <div data-w-id="68b27e14-f4f8-47f9-ff12-77048cf4142d" class="horizontal-item is--second">
                                <div class="horizontal-item__heading">
                                    <h3 class="h3-primary">Lengkapi data</h3>
                                    <div class="subtitle horizontal-item__subtitle">2</div>
                                </div>
                                <div class="horizontal-item__images-wrapper is--second">
                                    <!-- <div class="horizontal-item__image-3"><img
                      src="assets/img/65de001af5fbb3e77d6b7fbb_section-chill-1.webp" loading="lazy"
                      sizes="(max-width: 479px) 83vw, (max-width: 767px) 53vw, (max-width: 991px) 47vw, 26vw"
                      srcset="assets/img/65de001af5fbb3e77d6b7fbb_section-chill-1-p-500.webp 500w, assets/img/65de001af5fbb3e77d6b7fbb_section-chill-1-p-800.webp 800w, assets/img/65de001af5fbb3e77d6b7fbb_section-chill-1-p-1080.webp 1080w, assets/img/65de001af5fbb3e77d6b7fbb_section-chill-1-1.webp 1140w"
                      alt="" class="image-full is--parallax"></div> -->
                                    <div class="horizontal-item__image-4"><img
                                            src="{{ asset('assets/img/slide-item-3.webp') }}" loading="lazy"
                                            alt="" class="image-full is--parallax"></div>
                                </div>
                            </div>
                            <div data-w-id="70bba157-ff3a-e1cf-da1c-4e75e5420d84" class="horizontal-item is--third">
                                <div class="horizontal-item__heading is--three">
                                    <h3 class="h3-primary">Wawancara</h3>
                                    <div class="subtitle horizontal-item__subtitle is--three">3</div>
                                </div>
                                <div class="horizontal-item__images-wrapper is--third">
                                    <div class="horizontal-item__image-5"><img src="assets/img/slide-item-5.webp.webp"
                                            loading="lazy"
                                            sizes="(max-width: 479px) 187.9947967529297px, (max-width: 767px) 50vw, (max-width: 991px) 27vw, 26vw"
                                            srcset="assets/img/slide-item-5.webp-p-500.webp 500w, assets/img/slide-item-5.webp-p-800.webp 800w, assets/img/slide-item-5.webp-p-1080.webp 1080w, assets/img/slide-item-5.webp-1.webp 1140w"
                                            alt="" class="image-full is--parallax"></div>
                                    <div class="horizontal-item__image-6"><img src="assets/img/slide-item-3.webp.webp"
                                            loading="lazy"
                                            sizes="(max-width: 479px) 83vw, (max-width: 767px) 54vw, (max-width: 991px) 36vw, 19vw"
                                            srcset="assets/img/slide-item-3.webp-p-500.webp 500w, assets/img/slide-item-3.webp-p-800.webp 800w, assets/img/slide-item-3.webp-1.webp 840w"
                                            alt="" class="image-full is--parallax"></div>
                                </div>
                            </div>
                            <div data-w-id="c06fd39d-d028-767f-6105-f66592c6c26b" class="horizontal-item is--fourth">
                                <div class="horizontal-item__heading">
                                    <h3 class="h3-primary">Pengumuman<span class="h3-secondary"> dan </span>
                                        <br>Daftar ulang
                                    </h3>
                                    <div class="subtitle horizontal-item__subtitle">4</div>
                                </div>
                                <div class="horizontal-item__images-wrapper is--fourth">
                                    <div class="horizontal-item__image-8"><img src="assets/img/slide-item-4.webp.webp"
                                            loading="lazy"
                                            sizes="(max-width: 479px) 175.99827575683594px, (max-width: 767px) 50vw, (max-width: 991px) 32vw, 19vw"
                                            srcset="assets/img/slide-item-4.webp-p-500.webp 500w, assets/img/slide-item-4.webp-p-800.webp 800w, assets/img/slide-item-4.webp-1.webp 840w"
                                            alt="" class="image-full is--parallax"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section" id="pendaftaran">
                <div class="steps-padding">
                    <div class="steps-content__top">
                        <!-- <p from-bottom="" class="negative-text text-align-right is--step">Ayokk daftar<br>dengan</p> -->
                        <h2 from-bottom="" class="h2-primary is--about__top-heading">Ayokk daftar <br>dengan beberapa
                            tahap
                            <br>berikut
                        </h2>
                    </div>
                    <div class="step-content__grid">
                        <div id="w-node-_9f756782-32ef-923f-3193-f2b1bc2b86f5-1be57e30"
                            class="step-content__grid-item">
                            <div class="step-grid__item-content">
                                <p class="step-item__content-text">Beberapa menit</p>
                            </div>
                            <div class="step-grid__item-content">
                                <div class="step-grid__item-content-top">
                                    <div class="step-grid__item-number">
                                        <div>1</div>
                                    </div>
                                    <p class="subtitle text-transform-none">Menghubungi Admin Averroes</p>
                                    <div class="step-line__desktop"></div>
                                </div>
                                <p style="font-size: 1rem;">Menghubungi Nomer WhatsApp Admin Averroes 0889 9999 9744
                                </p>
                            </div>
                            <div class="step-line__touchdevices"></div>
                        </div>
                        <div id="w-node-_3c107852-1f87-866c-be4a-14dc6728ca01-1be57e30"
                            class="step-content__grid-item">
                            <div class="step-grid__item-content">
                                <p class="step-item__content-text">Beberapa Menit</p>
                            </div>
                            <div class="step-grid__item-content">
                                <div class="step-grid__item-content-top">
                                    <div class="step-grid__item-number">
                                        <div>2</div>
                                    </div>
                                    <p class="subtitle text-transform-none">Transfer Biaya Admin</p>
                                    <div class="step-line__desktop"></div>
                                </div>
                                <p style="font-size: 1rem;">Bayar biaya Admin ke rekening averroes dengan jumlah yang
                                    telah ditentukan
                                </p>
                            </div>
                            <div class="step-line__touchdevices"></div>
                        </div>
                        <div id="w-node-a09f7f27-91cf-1955-ab95-76f3e38f724d-1be57e30"
                            class="step-content__grid-item">
                            <div class="step-grid__item-content">
                                <p class="step-item__content-text">Beberapa Jam</p>
                            </div>
                            <div class="step-grid__item-content">
                                <div class="step-grid__item-content-top">
                                    <div class="step-grid__item-number">
                                        <div>3</div>
                                    </div>
                                    <p class="subtitle text-transform-none">Melengkapi data Online</p>
                                    <div class="step-line__desktop"></div>
                                </div>
                                <p style="font-size: 1rem;">Melengkapi data di website ppdb.averroesinsanmulia.com
                                    dengan Username dan
                                    password yang telah diberikan oleh admin</p>
                            </div>
                            <div class="step-line__touchdevices"></div>
                        </div>
                        <div id="w-node-_6f40c601-2fc6-d4f4-33c3-2fe12f820efa-1be57e30"
                            class="step-content__grid-item">
                            <div class="step-grid__item-content">
                                <p class="step-item__content-text is--fourth">Beberapa waktu</p>
                            </div>
                            <div class="step-grid__item-content">
                                <div class="step-grid__item-content-top">
                                    <div class="step-grid__item-number">
                                        <div>4</div>
                                    </div>
                                    <div class="step-line__desktop"></div>
                                    <p class="subtitle text-transform-none">Sesi Wawancara</p>
                                </div>
                                <p style="font-size: 1rem;">Calon Santri tes dan wawancara bersama ust dan kepala
                                    sekolah Averroes
                                    Digital islamic school</a>
                            </div>
                            <div class="step-line__touchdevices"></div>
                        </div>
                        <div id="w-node-c829abc7-ec6c-a487-e3e6-1391eb9a8f26-1be57e30"
                            class="step-content__grid-item is--last">
                            <div class="step-grid__item-content">
                                <p class="step-item__content-text">Tunggu untuk pengumuman</p>
                            </div>
                            <div class="step-grid__item-content is--last">
                                <div class="step-grid__item-content-top">
                                    <div class="step-grid__item-number">
                                        <div>5</div>
                                    </div>
                                    <p class="subtitle text-transform-none">Pengumuman dan daftar ulang</p>
                                </div>
                                <p style="font-size: 1rem;">Santri yang lulus wawancara akan diberikan pengumuman dan
                                    daftar ulang</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section">
                <div class="description-padding">
                    <div class="description-content__top-text-wrapper">
                        <p from-bottom="" class="description-content__top-text negative-text">Daftar sekarang dan
                        </p>
                        <div from-bottom="" class="description-content__top-heading-copy">
                            <h2 class="h2-primary is--about__top-heading">Dapatkan biaya <span
                                    class="h2-secondary">sesuai</span>
                                <br>Kemampuan
                            </h2>
                        </div>
                    </div>
                    <div class="description-content__grid">
                        <div id="w-node-_2e8b993f-4d15-2906-0c89-ebd28b40b35d-1be57e30"
                            class="description-content__grid-item"><img
                                src="assets/img/6526b5630d0133018458a6b4_description-icon01.svg" loading="lazy"
                                alt="" class="description-grid__item-image">
                            <div class="description-grid__item-content">
                                <h3 class="subtitle">Uang Gedung Normal 15jt</h3>
                                <p>setelah sesi wawancara ananda bisa mendapatkan biaya yang sesuai dengan kemampuan
                                    orangtua.
                                </p>
                            </div>
                        </div>
                        <div id="w-node-ef880b73-f08b-b010-98df-20c42e1dcabe-1be57e30"
                            class="description-content__grid-item"><img
                                src="assets/img/6526b563d5c4aac155552d4f_description-icon02.svg" loading="lazy"
                                alt="" class="description-grid__item-image">
                            <div class="description-grid__item-content">
                                <h3 class="subtitle">SPP Terjangkau</h3>
                                <p>Biaya SPP yang terjangkau dengan fasilitas dan kualitas pendidikan yang unggul.</p>
                            </div>
                        </div>
                        <div id="w-node-_1a720172-809b-5df5-377b-5931c47ee32b-1be57e30"
                            class="description-content__grid-item"><img
                                src="assets/img/6526b563773e53c7bda07382_description-icon04.svg" loading="lazy"
                                alt="" class="description-grid__item-image">
                            <div class="description-grid__item-content">
                                <h3 class="subtitle">Program Unggulan</h3>
                                <p>Memadukan kurikulum nasional dengan program tahfidz dan pengembangan karakter islami.</p>
                            </div>
                        </div>
                        <div id="w-node-cdb639f5-337f-40f9-bf6b-b7b8a5b9b725-1be57e30"
                            class="description-content__grid-item"><img
                                src="assets/img/6526b563637aad9b21fd353f_description-icon03.svg" loading="lazy"
                                alt="" class="description-grid__item-image">
                            <div class="description-grid__item-content">
                                <h3 class="subtitle">Kemudahan Pendaftaran</h3>
                                <p>Proses pendaftaran yang mudah dan dapat dilakukan secara online maupun offline.</p>
                            </div>
                        </div>
                        <div id="w-node-_2e6fea72-ad4f-d905-5983-b9bc501bcca0-1be57e30"
                            class="description-content__grid-item"><img
                                src="assets/img/6526b5632de4f51a0ad656a9_description-icon05.svg" loading="lazy"
                                alt="" class="description-grid__item-image">
                            <div class="description-grid__item-content">
                                <h3 class="subtitle">Pendampingan Intensif</h3>
                                <p>Tim pengajar profesional yang akan membimbing santri dalam pembelajaran akademik dan pengembangan karakter.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section" id="fasilitas">
                <div class="assemble-padding">
                    <div class="assemble-content__top">
                        <div class="assemble-content__top-title">
                            <div from-bottom="" class="assemble-content__top-title-text">
                                <h2 class="h3-primary">Pondok Modern <br><span class="h3-secondary">Full</span> &nbsp;
                                    Fasilitas</h2>
                            </div>
                            <!-- <div from-top="" class="assemble-content__top-text">
                <p from-bottom="">Plus some time for shipping.</p>
                <div class="assemble-top__text-star">*</div>
              </div> -->
                        </div>
                    </div>
                    {{-- <div class="assemble-content__main">
                        <div class="assemble-content__main-item is--first">
                            <div id="w-node-cb39597b-0db1-1fbc-f2c5-b617bf6bec31-1be57e30"
                                class="assemble-main__item is--first">
                                <div class="assets-1x1 text-color-white">
                                    <div class="video-embed w-embed"><video width="100%" playsinline=""
                                            muted="" preload="metadata" loop="true" class="js-video lazy"
                                            poster="assets/img/65ddf7d0f79025755019ed6e_roof.webp">
                                            <source data-src="https://qudrix-assets.netlify.app/videos/Roof_opt2.mp4"
                                                type="video/mp4">
                                        </video></div><a data-sidebar="slider" href="#"
                                        class="card-link__wrapper w-inline-block">
                                        <div class="card-cursor">
                                            <div class="card-cursor__content">
                                                <div class="subtitle text-transform-none">Selengkapnya</div><img
                                                    src="assets/img/6524136739dd6805b38908ff_Icon.svg" loading="lazy"
                                                    alt="" class="card-cursor__icon">
                                            </div>
                                        </div>
                                    </a><img src="assets/img/654b816c36c9b5bbbc202fbb_Triangle.svg" loading="lazy"
                                        alt="" class="triangle-vector">
                                </div>
                                <div class="assemble-main__item-description is--first">
                                    <h3 class="subtitle is--assemble">Tempat tinggal yang nyaman</h3>
                                    <p>untuk mendukung kegiatan belajar mengajar.</p>
                                </div>
                            </div>
                            <div id="w-node-fa91f20e-49db-b00c-f52f-c65e92c67355-1be57e30"
                                class="assemble-main__item is--second">
                                <div class="assets-1x1 is--second text-color-white"><a data-sidebar="slider"
                                        href="#" class="card-link__wrapper w-inline-block">
                                        <div class="card-cursor">
                                            <div class="card-cursor__content">
                                                <div class="subtitle text-transform-none">Selengkapnya</div><img
                                                    src="assets/img/6524136739dd6805b38908ff_Icon.svg" loading="lazy"
                                                    alt="" class="card-cursor__icon">
                                            </div>
                                        </div>
                                    </a><img src="assets/img/654b816c36c9b5bbbc202fbb_Triangle.svg" loading="lazy"
                                        alt="" class="triangle-vector">
                                    <div class="video-embed w-embed"><video width="100%" playsinline=""
                                            muted="" preload="metadata" loop="true" class="js-video lazy"
                                            poster="assets/img/65ddf7cf6c614c2c4e1377bc_profiles.webp">
                                            <source
                                                data-src="https://qudrix-assets.netlify.app/videos/Profile_opt2.mp4"
                                                type="video/mp4">
                                        </video></div>
                                </div>
                                <div class="assemble-main__item-description is--second">
                                    <h3 class="subtitle is--assemble">Sustainable and safe</h3>
                                    <p>The materials and components used in the production have passed all the necessary
                                        checks by US EPA.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="assemble-content__main-item is--second">
                            <div id="w-node-d3033b67-ebb4-0d4b-cdf3-1df9b449a62c-1be57e30"
                                class="assemble-main__item is--third">
                                <div class="assemble-main__item-description is--third">
                                    <div class="assemble-item__description-third is--top">
                                        <p>Feel free to adapt and customize</p>
                                    </div>
                                    <div class="assemble-item__description-third is--bottom">
                                        <p>Qudrix does not need to be registered and no additional permits needed. So
                                            it’s easy to order
                                            &amp; to set up.</p>
                                    </div>
                                </div>
                            </div>
                            <div id="w-node-d3033b67-ebb4-0d4b-cdf3-1df9b449a634-1be57e30"
                                class="assemble-main__item is--fourth">
                                <div class="assets-1x1 text-color-white"><a data-sidebar="slider" href="#"
                                        class="card-link__wrapper w-inline-block">
                                        <div class="card-cursor">
                                            <div class="card-cursor__content">
                                                <div class="subtitle text-transform-none">Selengkapnya</div><img
                                                    src="assets/img/6524136739dd6805b38908ff_Icon.svg" loading="lazy"
                                                    alt="" class="card-cursor__icon">
                                            </div>
                                        </div>
                                    </a>
                                    <div class="video-embed w-embed"><video width="100%" playsinline=""
                                            muted="" preload="metadata" loop="true" class="js-video lazy"
                                            poster="assets/img/65ddf7cf2b5013b2f5d3d8a4_cube.webp">
                                            <source data-src="https://qudrix-assets.netlify.app/videos/Cube_opt2.mp4"
                                                type="video/mp4">
                                        </video></div><img src="assets/img/654b816c36c9b5bbbc202fbb_Triangle.svg"
                                        loading="lazy" alt="" class="triangle-vector">
                                </div>
                                <div class="assemble-main__item-description is--fourth">
                                    <h3 class="subtitle is--assemble">Highly customizable</h3>
                                    <p>Over 12 combinations for your Qudrix.</p>
                                </div>
                            </div>
                        </div>
                        <div class="assemble-content__main-item is--third">
                            <div id="w-node-_691d027c-5473-4da1-0212-277ee64a118f-1be57e30"
                                class="assemble-main__item is--fifth">
                                <div class="assets-1x1 is--fifth text-color-white"><a data-sidebar="slider"
                                        href="#" class="card-link__wrapper w-inline-block">
                                        <div class="card-cursor">
                                            <div class="card-cursor__content">
                                                <div class="subtitle text-transform-none">Selengkapnya</div><img
                                                    src="assets/img/6524136739dd6805b38908ff_Icon.svg" loading="lazy"
                                                    alt="" class="card-cursor__icon">
                                            </div>
                                        </div>
                                    </a>
                                    <div class="video-embed w-embed"><video width="100%" playsinline=""
                                            muted="" preload="metadata" loop="true" class="js-video lazy"
                                            poster="assets/img/65ddf7cfff5a21447fcc7058_frame.webp">
                                            <source data-src="https://qudrix-assets.netlify.app/videos/Frame_opt2.mp4"
                                                type="video/mp4">
                                        </video></div><img src="assets/img/654b816c36c9b5bbbc202fbb_Triangle.svg"
                                        loading="lazy" alt="" class="triangle-vector">
                                </div>
                                <div class="assemble-main__item-description is--fifth">
                                    <div class="assemble-item__description-fifth">
                                        <h3 class="subtitle is--assemble">Long lasting</h3>
                                        <p>Thick aluminum frame, European details and fittings, plus the possibility to
                                            replace any module
                                            just in case you change your mind in a year or two.</p>
                                    </div>
                                </div>
                            </div>
                            <div id="w-node-_7e96b660-4f8b-80b5-f147-2ad3fdaf3c7a-1be57e30"
                                class="assemble-main__item-description is--sixth">
                                <div class="assemble-item__description-sixth is--top">
                                    <p>all systems assembled in one</p>
                                </div>
                                <div class="assemble-item__description-sixth is--bottom">
                                    <p>the place for air conditioner or heating could be included for your needs</p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </section>
            <section class="section">
                <div class="customize-padding">
                    <div class="customize-content__top">
                        <h2 from-bottom="" class="h3-primary">Ayoo <span class="h3-secondary">daftar</span> Sekarang!
                        </h2>
                    </div><img src="assets/img/654b816c36c9b5bbbc202fbb_Triangle.svg" loading="lazy" alt=""
                        class="triangle-vector">
                    <div class="customize-content__main">
                        <div class="customize-content__main-link"><img src="assets/img/logo-white.png" loading="lazy"
                                sizes="(max-width: 479px) 100vw, 75vw"
                                srcset="assets/img/65a92fc13db19979f7b3da47_qudrix-customize-p-500.png 500w, assets/img/65a92fc13db19979f7b3da47_qudrix-customize-p-800.png 800w, assets/img/65a92fc13db19979f7b3da47_qudrix-customize-p-1080.png 1080w, assets/img/65a92fc13db19979f7b3da47_qudrix-customize-p-1600.png 1600w, assets/img/65a92fc13db19979f7b3da47_qudrix-customize-p-2000.png 2000w, assets/img/65a92fc13db19979f7b3da47_qudrix-customize-p-2600.png 2600w, assets/img/65a92fc13db19979f7b3da47_qudrix-customize-p-3200.png 3200w, assets/img/65a92fc13db19979f7b3da47_qudrix-customize-1.png 4600w"
                                alt="" class="customize-content__image"></div>
                    </div>
                </div>
            </section>

            <!-- <section class="section is--hidden">
        <div class="cta-padding">
          <div class="cta-content__top">
            <h2 from-bottom="" class="h3-primary">Not <span class="h3-secondary">sure</span> yet?</h2>
          </div>
          <div class="cta-content__main">
            <h3 from-bottom="" class="subtitle is--request">Leave a request and <br>we’ll call you.</h3>
            <div class="cta-form__wrapper w-form">
              <form id="email-form" name="email-form" data-name="Email Form" method="get" data-wt-fv-form="2"
                class="cta-from__block" data-wf-page-id="averroes651fba54cf5533331"
                data-wf-element-id="e9912cec-0c1e-5178-d4f2-fc8f0194f567">
                <div class="cta-form__inputs">
                  <div class="input-wrapper"><input class="input-field placeholder-hidden is-green w-input"
                      maxlength="256" name="Name" data-name="Name" placeholder="first and last name" type="text"
                      id="Name" required=""><label for="Email-3" class="label-text c-error-message">full name</label>
                    <div wr-type="error" class="error-message">Please fill this information</div>
                  </div>
                  <div class="input-wrapper"><input class="input-field placeholder-hidden is-green w-input"
                      maxlength="256" name="Phone-Number" data-name="Phone Number" placeholder="+1 123 123 1234"
                      type="tel" id="Phone-Number-2" required=""><label for="Email-2"
                      class="label-text c-error-message">Phone Number *</label>
                    <div wr-type="error" class="error-message">Please fill this information</div>
                  </div>
                  <div class="input-wrapper"><input class="input-field placeholder-hidden is-green w-input"
                      maxlength="256" name="Email" wr-type="required-field" data-name="Email"
                      placeholder="personal or corporate" type="email" id="Email-2" required=""><label for="Email-2"
                      class="label-text c-error-message">Email *</label>
                    <div wr-type="error" class="error-message">Please fill this information</div>
                  </div>
                </div>
                <div class="cta-form__button"><a href="#" class="submit-button w-inline-block">
                    <div class="submit-button__text">Leave a request</div>
                    <div class="span is--green"></div>
                  </a><input type="submit" data-wait="Please wait..." class="input-submit w-button" value="Submit">
                </div>
              </form>
              <div class="w-form-done">
                <div>Thank you! Your submission has been received!</div>
              </div>
              <div class="w-form-fail">
                <div>Oops! Something went wrong while submitting the form.</div>
              </div>
            </div>
          </div><img src="assets/img/654b816c36c9b5bbbc202fbb_Triangle.svg" loading="lazy" alt=""
            class="triangle-vector is--bottom">
        </div>
      </section> -->
            <section class="section">
                <div class="people-padding">
                    <div class="people-content__top">
                        <h2 from-bottom="" class="h3-primary">Guru dan Ustadz kami.</h2>
                    </div>
                    <div class="people-content__main">
                        <div class="people-content__main-first">
                            <div class="assets-1x1 without-margin"><img
                                    src="assets/img/654dcfdcfe72ac539a1cdeac_1734e399fb7c69c7bac49c26caad7149-min.webp"
                                    loading="lazy" alt="" class="image-full is--grayscale"><img
                                    src="assets/img/654b816c36c9b5bbbc202fbb_Triangle.svg" loading="lazy"
                                    alt="" class="triangle-vector"></div>
                        </div>
                        <div class="people-content__main-flex">
                            <div class="people-content__main-second">
                                <div class="assets-1x1 people-content"><img
                                        src="assets/img/654dcfdc16c68ced7a6b7c68_61f072de9cfaba6a5e2ec3f40cd7a2d6-min.webp"
                                        loading="lazy" alt=""
                                        sizes="(max-width: 479px) 75vw, (max-width: 767px) 73vw, (max-width: 991px) 52vw, 43vw"
                                        srcset="assets/img/654dcfdc16c68ced7a6b7c68_61f072de9cfaba6a5e2ec3f40cd7a2d6-min-p-500.webp 500w, assets/img/654dcfdc16c68ced7a6b7c68_61f072de9cfaba6a5e2ec3f40cd7a2d6-min.webp 797w"
                                        class="image-full"><img src="assets/img/654b816c36c9b5bbbc202fbb_Triangle.svg"
                                        loading="lazy" alt="" class="triangle-vector is--bottom"></div>
                            </div>
                            <div class="people-description__wrapper">
                                <div class="people-content__main-third">
                                    <p class="subtitle text-transform-none people-main__third-text">Averroes Digital
                                        Islamic School
                                        merupakan sebuah lembaga pendidikan pesantren formal setara SMA/SMK yang
                                        dirancang untuk melahirkan
                                        genarasi Qur’ani yang ahli di bidang IT. Averroes Digital Islamic School
                                        memiliki moto yaitu
                                        “Jiwanya Santri, Skillnya IT”</p>
                                    <p>Rujian Khairi</p>
                                    <p>Kepala sekolah</p>
                                </div>
                            </div>
                            <!-- <div class="people-content__main-fourth"><a href="about.html" class="underlined-link">read about us</a>
              </div> -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- <section id="testimonials" class="section">
        <div class="testimonials-padding">
          <div class="testimonials-content__main">
            <div data-bottom="" class="testimonials-content__main-grid is--header">
              <div data-animate="" id="w-node-_9278e250-a5c6-6861-bf96-a3f58ab3dd47-1be57e30"
                class="testimonials-grid__column-first char">
                <div>Name</div>
              </div>
              <div id="w-node-_64feff43-fb31-0de3-714d-dfa0f5ddf220-1be57e30" class="testimonials-grid__column-second">
                <div class="testimonials-column__second-child">
                  <div data-animate="">pesan</div>
                </div>
                <div class="testimonials-column__second-child is--second">
                  <div data-animate="" class="testimonials-column__small">
                    <div>lulusan</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="testimonials-content__collection w-dyn-list">
              <div role="list" class="testimonials-content__collection-list w-dyn-items">
                <div data-bottom="" role="listitem" class="testimonials-content__main-grid w-dyn-item">
                  <div class="testimonials-grid__column-first">
                    <div data-animate="" class="testimonials-name">
                      <p>Emily Carte</p>
                    </div>
                    <div data-animate="" class="testimonials-wrapper__photo"><img loading="lazy" alt="Emily Carte"
                        src="assets/img/6528da825ec19109e26568b0_3e0d4e3eabeddf471665758440613c24.jpeg"
                        sizes="(max-width: 479px) 111.99653625488281px, (max-width: 767px) 16vw, 87.99479675292969px"
                        srcset="assets/img/6528da825ec19109e26568b0_3e0d4e3eabeddf471665758440613c24-p-500.jpeg 500w, assets/img/6528da825ec19109e26568b0_3e0d4e3eabeddf471665758440613c24-p-800.jpeg 800w, assets/img/6528da825ec19109e26568b0_3e0d4e3eabeddf471665758440613c24-p-1080.jpeg 1080w, assets/img/6528da825ec19109e26568b0_3e0d4e3eabeddf471665758440613c24-p-1600.jpeg 1600w, assets/img/6528da825ec19109e26568b0_3e0d4e3eabeddf471665758440613c24-p-2000.jpeg 2000w, assets/img/6528da825ec19109e26568b0_3e0d4e3eabeddf471665758440613c24.jpeg 2560w"
                        class="image-full testimonials-photo"></div>
                  </div>
                  <div class="testimonials-grid__column-second">
                    <div data-animate="" class="testimonials-column__second-child">
                      <blockquote class="testimonials-text">I couldn&#x27;t be happier with my decision to choose the
                        Qudrix cube. The design and quality exceeded my expectations, and the whole process was
                        seamless. The Qudrix team was incredibly responsive, guiding me through every step.</blockquote>
                    </div>
                    <div class="testimonials-column__second-child is--second">
                      <div data-animate="" class="testimonials-column__small">
                        <p>Real Estate Broker</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="testimonials-content__main-grid is--footer">
              <div id="w-node-_3fb12bbb-1462-ead9-26b0-57eb263f5253-1be57e30" class="testimonials-grid__column-first">
              </div>
              <div id="w-node-_3fb12bbb-1462-ead9-26b0-57eb263f5256-1be57e30" class="testimonials-grid__column-second">
                <div class="testimonials-column__second-child is--link"><a href="#" class="underlined-link">Show
                    more</a></div>
              </div>
            </div>
          </div>
        </div>
      </section> -->
            <!-- <section class="section">
        <div class="faq-padding">
          <div class="faq-content__container">
            <div class="faq-content__top">
              <h2 from-bottom="" class="h3-primary">Go on, <span class="h3-secondary">ask</span> us</h2>
            </div>
            <div class="faq-content__main w-dyn-list">
              <div role="list" class="w-dyn-items">
                <div role="listitem" class="faq-content__main-item w-dyn-item">
                  <p class="faq-content__main-number">1</p>
                  <div data-hover="false" data-delay="0" data-w-id="d4476052-db6c-d664-04eb-85a9c5176349"
                    class="dropdown w-dropdown">
                    <div class="dropdown-toggle w-dropdown-toggle">
                      <div>Does Qudrix have a bathroom?</div>
                      <div class="dropdown-icon">
                        <div class="dropdown-icon__line w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="2" viewbox="0 0 18 2" fill="none">
                            <path d="M1 1H17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="square"></path>
                          </svg></div>
                        <div
                          style="-webkit-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);-moz-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);-ms-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0)"
                          class="dropdown-icon__line-top w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="2" viewbox="0 0 18 2" fill="none">
                            <path d="M1 1H17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="square"></path>
                          </svg></div>
                      </div>
                    </div>
                    <nav style="width:100%;height:0rem;display:none" class="dropdown-list w-dropdown-list">
                      <div class="dropdown-list__content">
                        <p class="subtitle is--faq">No, Qudrix does not have a water supply. We made this decision to
                          get rid of obtaining time-consuming regulatory permits. Perhaps in the future, we will
                          consider this design option.</p>
                      </div>
                    </nav>
                  </div>
                </div>
                <div role="listitem" class="faq-content__main-item w-dyn-item">
                  <p class="faq-content__main-number">1</p>
                  <div data-hover="false" data-delay="0" data-w-id="d4476052-db6c-d664-04eb-85a9c5176349"
                    class="dropdown w-dropdown">
                    <div class="dropdown-toggle w-dropdown-toggle">
                      <div>Do I need a building permit?</div>
                      <div class="dropdown-icon">
                        <div class="dropdown-icon__line w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="2" viewbox="0 0 18 2" fill="none">
                            <path d="M1 1H17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="square"></path>
                          </svg></div>
                        <div
                          style="-webkit-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);-moz-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);-ms-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0)"
                          class="dropdown-icon__line-top w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="2" viewbox="0 0 18 2" fill="none">
                            <path d="M1 1H17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="square"></path>
                          </svg></div>
                      </div>
                    </div>
                    <nav style="width:100%;height:0rem;display:none" class="dropdown-list w-dropdown-list">
                      <div class="dropdown-list__content">
                        <p class="subtitle is--faq">No, Qudrix does not have a water supply. We made this decision to
                          get rid of obtaining time-consuming regulatory permits. Perhaps in the future, we will
                          consider this design option.</p>
                      </div>
                    </nav>
                  </div>
                </div>
                <div role="listitem" class="faq-content__main-item w-dyn-item">
                  <p class="faq-content__main-number">1</p>
                  <div data-hover="false" data-delay="0" data-w-id="d4476052-db6c-d664-04eb-85a9c5176349"
                    class="dropdown w-dropdown">
                    <div class="dropdown-toggle w-dropdown-toggle">
                      <div>Is there a pre-furnished option?</div>
                      <div class="dropdown-icon">
                        <div class="dropdown-icon__line w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="2" viewbox="0 0 18 2" fill="none">
                            <path d="M1 1H17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="square"></path>
                          </svg></div>
                        <div
                          style="-webkit-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);-moz-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);-ms-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0)"
                          class="dropdown-icon__line-top w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="2" viewbox="0 0 18 2" fill="none">
                            <path d="M1 1H17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="square"></path>
                          </svg></div>
                      </div>
                    </div>
                    <nav style="width:100%;height:0rem;display:none" class="dropdown-list w-dropdown-list">
                      <div class="dropdown-list__content">
                        <p class="subtitle is--faq">No, Qudrix does not have a water supply. We made this decision to
                          get rid of obtaining time-consuming regulatory permits. Perhaps in the future, we will
                          consider this design option.</p>
                      </div>
                    </nav>
                  </div>
                </div>
                <div role="listitem" class="faq-content__main-item w-dyn-item">
                  <p class="faq-content__main-number">1</p>
                  <div data-hover="false" data-delay="0" data-w-id="d4476052-db6c-d664-04eb-85a9c5176349"
                    class="dropdown w-dropdown">
                    <div class="dropdown-toggle w-dropdown-toggle">
                      <div>Are Qudrixes weatherproof?</div>
                      <div class="dropdown-icon">
                        <div class="dropdown-icon__line w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="2" viewbox="0 0 18 2" fill="none">
                            <path d="M1 1H17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="square"></path>
                          </svg></div>
                        <div
                          style="-webkit-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);-moz-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);-ms-transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0);transform:translate3d(0, 0, 0) scale3d(1, 1, 1) rotateX(0) rotateY(0) rotateZ(90deg) skew(0, 0)"
                          class="dropdown-icon__line-top w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="18"
                            height="2" viewbox="0 0 18 2" fill="none">
                            <path d="M1 1H17" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                              stroke-linecap="square"></path>
                          </svg></div>
                      </div>
                    </div>
                    <nav style="width:100%;height:0rem;display:none" class="dropdown-list w-dropdown-list">
                      <div class="dropdown-list__content">
                        <p class="subtitle is--faq">No, Qudrix does not have a water supply. We made this decision to
                          get rid of obtaining time-consuming regulatory permits. Perhaps in the future, we will
                          consider this design option.</p>
                      </div>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
            <div class="testimonials-content__main-grid is--footer">
              <div id="w-node-_493dd293-c387-7caa-21f8-2c3f5efe87c0-1be57e30" class="testimonials-grid__column-first">
              </div>
              <div id="w-node-_493dd293-c387-7caa-21f8-2c3f5efe87c1-1be57e30" class="testimonials-grid__column-second">
                <div class="testimonials-column__second-child"><a href="#" class="underlined-link">Show more</a></div>
              </div>
            </div>
          </div>
          <div class="faq-full__asset is--faq">
            <div class="content-full__asset"><img src="assets/img/65ddf9f0b83e56cd75e97fe1_section_ask.webp"
                loading="lazy" alt="" class="content-full__asset-image is--desktop"><img
                src="assets/img/65a961ee3dc7d10fd92bef21_qudrix-prefooter-mob.webp" loading="lazy" alt="" sizes="100vw"
                srcset="assets/img/65a961ee3dc7d10fd92bef21_qudrix-prefooter-mob-p-500.webp 500w, assets/img/65a961ee3dc7d10fd92bef21_qudrix-prefooter-mob-p-800.webp 800w, assets/img/65a961ee3dc7d10fd92bef21_qudrix-prefooter-mob.webp 1125w"
                class="content-full__asset-image is--mob">
              <div class="triangle-wrapper">
                <div class="triangle-vector w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
                    viewbox="0 0 111 110" fill="none">
                    <path
                      d="M103.79 3.82669L3.23095 104.222C1.79552 105.796 1 110.005 1 110.005H0V0.00472293C34.6811 -0.00858413 92.5189 0.0111679 110.123 0.00441336V1.00425C110.123 1.02016 110.11 1.03305 110.094 1.0331C107.694 1.04116 105.407 2.05438 103.79 3.82669Z"
                      fill="#D2D2D2"></path>
                  </svg></div>
              </div>
              <div class="triangle-vector is--bottom w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="100%"
                  height="100%" viewbox="0 0 111 110" fill="none">
                  <path
                    d="M103.79 3.82669L3.23095 104.222C1.79552 105.796 1 110.005 1 110.005H0V0.00472293C34.6811 -0.00858413 92.5189 0.0111679 110.123 0.00441336V1.00425C110.123 1.02016 110.11 1.03305 110.094 1.0331C107.694 1.04116 105.407 2.05438 103.79 3.82669Z"
                    fill="#D2D2D2"></path>
                </svg></div>
              <div class="image-mask mask--vertical-full"></div>
              <div class="image-mask mask--horizontal-full"></div>
            </div>
          </div>
          <div class="faq-content__container is--footer">
            <div class="testimonials-content__main-grid is--footer is--prefooter">
              <div id="w-node-_60213515-9df7-6133-bba1-6fc7b352d7a3-1be57e30" class="testimonials-grid__column-second">
                <div class="testimonials-column__second-child">
                  <p from-bottom="">Personal space to meet <br>all your needs</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->
        </main>

        <footer id="contact" class="footer"
            style="background-color: var(--colors-averroes ) !important; margin-top: 20vh;">
            <div class="customize-padding" style="padding-bottom: 0;">
                <img src="{{ asset('assets/img/Triangle.svg') }}" loading="lazy" alt=""
                    class="triangle-vector">
                <div class="footer-padding">
                    <div class="footer-content">
                        <div class="footer-content__block is--first">
                            <div id="w-node-_41e708c2-ba4f-1934-8e0c-5543c272bc7e-c272bc6e"
                                class="footer-column__first">
                                <p class="footer-title">Follow kami di</p>
                                <ul role="list" class="footer-social__list w-list-unstyled">
                                    <li class="footer-social__list-item"><a
                                            href="https://www.instagram.com/averroes.is/" target="_blank"
                                            class="subtitle text-transform-none hover-underline">Instagram</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="w-node-_41e708c2-ba4f-1934-8e0c-5543c272bc83-c272bc6e"
                                class="footer-column__second">
                                <p class="footer-title">Senin - Sabtu, 7AM – 4PM</p><a
                                    href="mailto:islamicschoolaverroes@gmail.com"
                                    class="subtitle text-transform-none hover-underline is--email">islamicschoolaverroes@gmail.com</a>
                                <p class="footer-title">Kami jawab secepat mungkin</p><a href="tel:6288999999744"
                                    class="subtitle text-transform-none is--footer-link hover-underline">0889 9999
                                    9744</a>
                                <p>Perumahan Permata Jingga <br> Blok Pinang No.5, Tunggulwulung, <br> Kec. Lowokwaru,
                                    Kota Malang, Jawa
                                    Timur 65141</p>
                            </div>
                        </div>

                        <div class="footer-content__bottom">
                            <div class="footer-content__block is--third">
                                <p id="w-node-_41e708c2-ba4f-1934-8e0c-5543c272bcb8-c272bc6e" class="copyright"></p>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const yearElement = document.querySelector('.copyright');
                                        const currentYear = new Date().getFullYear();
                                        yearElement.innerHTML = `Averroes © ${currentYear}`;
                                    });
                                </script>

                                <a href="https://kenn.my.id" target="_blank" class="hover-underline">Crafted
                                    by kenn</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    </footer>

    <div data-w-id="19e18c06-0d40-c989-6765-4b959b5ed3fb" class="preloader-wrapper">
        <div class="preloader-bg">
            <div data-w-id="19e18c06-0d40-c989-6765-4b959b5ed3fd" class="preloader-block"></div>
            <div data-w-id="19e18c06-0d40-c989-6765-4b959b5ed3fe" class="preloader-text__full"><span
                    class="preloader-text">100</span>%</div>
        </div>
    </div>
    <div class="popup is--slider-popup">
        <div data-sidebar="slider-close" class="popup-overlay"></div>
        <div class="popup-content">
            <div data-sidebar="slider-close" class="popup-close__button is--slider">
                <div class="popup-close__button-arrow w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" viewbox="0 0 16 16" fill="none">
                        <path d="M1.33333 8H14.6667M1.33333 8L5.36 12M1.33333 8L5.36 4" stroke="#161616"
                            stroke-width="1.2" stroke-linecap="square"></path>
                    </svg></div>
                <p class="popup-close__button-text">Kembali</p>
            </div>
            <div class="swiper w-dyn-list">
                <div role="list" class="swiper-wrapper w-dyn-items">
                    <div role="listitem" class="swiper-slide w-dyn-item">
                        <div class="popup-slider__content">
                            <div class="poput-slider__text">
                                <div class="text-transfrom-uppercase">Tempat tinggal yang nyaman</div>
                                <div class="popup-slider__richtext w-richtext">
                                    <p>Qudrix comes fully installed with essential amenities and features, from
                                        top-quality base and
                                        frame  to efficient windows. The Q manager schedules convenient installation
                                        dates right after the
                                        delivery of components. Next, our service team installs ready-to-move-in cube.
                                    </p>
                                    <p>And the cherry on top is the warranty service for 5 years.</p>
                                </div>
                            </div>
                            <div class="popup-slider__image">
                                <div class="video-embed w-embed"><video width="100%" playsinline="" autoplay=""
                                        muted="" preload="metadata" loop="true" class="js-video lazy">
                                        <source data-src="https://qudrix-assets.netlify.app/videos/Roof_opt2.mp4"
                                            type="video/mp4">
                                    </video></div>
                            </div>
                        </div>
                    </div>
                    <div role="listitem" class="swiper-slide w-dyn-item">
                        <div class="popup-slider__content">
                            <div class="poput-slider__text">
                                <div class="text-transfrom-uppercase">Sustainable and safe</div>
                                <div class="popup-slider__richtext w-richtext">
                                    <p>Our materials and components utilized in production have undergone rigorous
                                        scrutiny and have
                                        successfully passed all the requisite checks mandated by the United States
                                        Environmental
                                        Protection Agency (EPA).</p>
                                    <p>This assurance reflects a commitment to environmental responsibility and
                                        sustainability
                                        throughout the manufacturing process.</p>
                                </div>
                            </div>
                            <div class="popup-slider__image">
                                <div class="video-embed w-embed"><video width="100%" playsinline="" autoplay=""
                                        muted="" preload="metadata" loop="true" class="js-video lazy">
                                        <source data-src="https://qudrix-assets.netlify.app/videos/Profile_opt2.mp4"
                                            type="video/mp4">
                                    </video></div>
                            </div>
                        </div>
                    </div>
                    <div role="listitem" class="swiper-slide w-dyn-item">
                        <div class="popup-slider__content">
                            <div class="poput-slider__text">
                                <div class="text-transfrom-uppercase">Highly customizable</div>
                                <div class="popup-slider__richtext w-richtext">
                                    <p>Qudrix customization options perfectly align with your preferences and needs.
                                        First and foremost,
                                        the cube can be customized to suit your personal lifestyle, with choices ranging
                                        from open-view
                                        designs to segmented living area.</p>
                                    <p>Roof, walls, windows and doors are also highly customizable, enabling residents
                                        to achieve your
                                        desired aesthetic.</p>
                                </div>
                            </div>
                            <div class="popup-slider__image">
                                <div class="video-embed w-embed"><video width="100%" playsinline="" autoplay=""
                                        muted="" preload="metadata" loop="true" class="js-video lazy">
                                        <source data-src="https://qudrix-assets.netlify.app/videos/Cube_opt2.mp4"
                                            type="video/mp4">
                                    </video></div>
                            </div>
                        </div>
                    </div>
                    <div role="listitem" class="swiper-slide w-dyn-item">
                        <div class="popup-slider__content">
                            <div class="poput-slider__text">
                                <div class="text-transfrom-uppercase">Durable components</div>
                                <div class="popup-slider__richtext w-richtext">
                                    <p>The incorporation of a robust, thick aluminium frame enhances the structural
                                        integrity of the
                                        house, providing resilience against various environmental challenges.</p>
                                    <p>Further underlining the practical design, Qudrix feature gutters capable of
                                        efficiently managing
                                        even the most torrential  downpours. In addition to their practicality,
                                        floor-to-ceiling windows
                                        are strategically positioned to maximize natural light, creating an open,
                                        inviting atmosphere.</p>
                                </div>
                            </div>
                            <div class="popup-slider__image">
                                <div class="video-embed w-embed"><video width="100%" playsinline="" autoplay=""
                                        muted="" preload="metadata" loop="true" class="js-video lazy">
                                        <source data-src="https://qudrix-assets.netlify.app/videos/Frame_opt2.mp4"
                                            type="video/mp4">
                                    </video></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-arrows__wrapper w-embed"><button class="popup-arrow slider-button__prev"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewbox="0 0 16 10"
                        fill="none">
                        <path d="M1.33333 5H14.6667M1.33333 5L5.36 9M1.33333 5L5.36 1" stroke="currentColor"
                            stroke-width="1.2" stroke-linecap="square"></path>
                    </svg>
                </button>
                <button class="popup-arrow slider-button__next" type="button" aria-label="Next slide"
                    aria-controls="splide01-track">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewbox="0 0 16 16"
                        fill="none">
                        <path d="M14.6667 8H1.33334M14.6667 8L10.64 4M14.6667 8L10.64 12" stroke="currentColor"
                            stroke-width="1.2" stroke-linecap="square"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    {{-- <div class="popup is--form-popup">
        <div data-sidebar="form-close" class="popup-overlay"></div>
        <div data-lenis-prevent="" class="popup-content">
            <div data-sidebar="form-close" class="popup-close__button is--slider">
                <div class="popup-close__button-arrow w-embed"><svg xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" viewbox="0 0 16 16" fill="none">
                        <path d="M1.33333 8H14.6667M1.33333 8L5.36 12M1.33333 8L5.36 4" stroke="#161616"
                            stroke-width="1.2" stroke-linecap="square"></path>
                    </svg></div>
                <p class="popup-close__button-text">Kembali</p>
            </div>
            <div class="popup-form__grid">
                <div id="w-node-d971a977-ff51-9741-e182-8c7e4094bc3f-1be57e30" class="popup-grid__first-item">
                    <h2 id="w-node-f0c30a42-ac9c-0b14-17ba-491da9d15102-1be57e30" class="text-size-large">Please
                        fill the form
                        and one of our local representatives will get back to you with details.</h2>
                </div>
                <div id="w-node-_7910d9c6-fab2-0265-ab97-9ee730e0e8b0-1be57e30" class="popup-form__wrapper w-form">
                    <form id="wf-form-Request-From" name="wf-form-Request-From" data-name="Request From"
                        method="get" data-wt-fv-form="4" class="popup-form"
                        data-wf-page-id="averroes651fba54cf5533331"
                        data-wf-element-id="7910d9c6-fab2-0265-ab97-9ee730e0e8b1">
                        <div class="popup-from__inputs">
                            <div class="input-wrapper is--full-width"><input
                                    class="input-field placeholder-hidden w-input" maxlength="256" name="Name"
                                    wr-type="required-field" data-name="Name" placeholder="Name" type="text"
                                    id="Name-3" required=""><label for="Email-4"
                                    class="label-text c-error-message">full name *</label>
                                <div wr-type="error" class="error-message">Please fill this information</div>
                            </div>
                            <div class="input-wrapper is--full-width"><input
                                    class="input-field placeholder-hidden w-input" maxlength="256" name="Company"
                                    wr-type="required-field" data-name="Company" placeholder="Company"
                                    type="text" id="Company" required=""><label for="Email-4"
                                    class="label-text c-error-message">Company
                                    *</label>
                                <div wr-type="error" class="error-message">Please fill this information</div>
                            </div>
                            <div class="input-wrapper is--full-width"><input
                                    class="input-field placeholder-hidden w-input" maxlength="256" name="City"
                                    wr-type="required-field" data-name="City" placeholder="City" type="text"
                                    id="City" required=""><label for="Email-4"
                                    class="label-text c-error-message">City *</label>
                                <div wr-type="error" class="error-message">Please fill this information</div>
                            </div>
                            <div class="input-wrapper is--full-width"><input
                                    class="input-field placeholder-hidden w-input" maxlength="256"
                                    name="Email-Address" wr-type="required-field" data-name="Email Address"
                                    placeholder="Email Address" type="email" id="Email-Address"
                                    required=""><label for="Email-4" class="label-text c-error-message">Email
                                    Address *</label>
                                <div wr-type="error" class="error-message">Please fill this information</div>
                            </div>
                            <div class="input-wrapper is--full-width"><input
                                    class="input-field placeholder-hidden w-input" maxlength="256"
                                    name="Phone-Number" wr-type="required-field" data-name="Phone Number"
                                    placeholder="Phone Number" type="tel" id="Phone-Number-4"
                                    required=""><label for="Email-4" class="label-text c-error-message">Phone
                                    Number</label>
                                <div wr-type="error" class="error-message">Please fill this information</div>
                            </div>
                            <div class="input-wrapper is--full-width">
                                <textarea id="field" name="field" maxlength="5000" data-name="Field"
                                    placeholder="Start to write your message" class="input-field placeholder-hidden is--textarea w-input"></textarea><label for="Email-4"
                                    class="label-text c-error-message">text message <span class="is--label-span">
                                        (optional)</span></label>
                            </div>
                        </div>
                        <div class="popup-from__bottom-content">
                            <div class="popup-from__checkboxes"><label class="w-checkbox checkox-field">
                                    <div class="w-checkbox-input w-checkbox-input--inputType-custom checkbox"></div>
                                    <input id="Newslatters" type="checkbox" name="Newslatters"
                                        data-name="Newslatters" style="opacity:0;position:absolute;z-index:-1"><span
                                        class="checkbox-label c-error-message w-form-label" for="Newslatters">Yes, I
                                        want to learn more
                                        about workplace wellbeing, acoustics and Mute products and I&#x27;m joining Mute
                                        newsletter.
                                        I&#x27;m aware my personal information is kept in accordance with Mute <a
                                            href="#" class="underline-link">Privacy Policy</a>.</span>
                                </label><label class="w-checkbox checkox-field">
                                    <div class="w-checkbox-input w-checkbox-input--inputType-custom checkbox"></div>
                                    <input id="Privacy-policy" type="checkbox" name="Privacy-policy"
                                        data-name="Privacy policy" required="" wr-type="required-field"
                                        style="opacity:0;position:absolute;z-index:-1"><span
                                        class="checkbox-label c-error-message w-form-label" for="Privacy-policy">I
                                        agree that my data will
                                        be processed directly by qudrix or shared with a sales agent located in my area
                                        in accordance with
                                        qudrix <a href="#" class="underline-link">Privacy Policy.</a></span>
                                    <div wr-type="error" class="error-message">Check this if you want to continue
                                    </div>
                                </label></div>
                            <div class="popup-from__buttons"><a data-sidebar="form-close" href="#"
                                    class="cancel-button-hover w-inline-block">
                                    <div class="submit-button__text">cancel</div>
                                    <div class="span"></div>
                                </a><a href="#" class="submit-button w-inline-block">
                                    <div class="submit-button__text">Leave a request</div>
                                    <div class="span"></div>
                                </a><input type="submit" data-wait="Please wait..." class="input-submit w-button"
                                    value="Leave a request"></div>
                        </div>
                    </form>
                    <div class="success-message w-form-done">
                        <h2 class="text-size-large is--popup-cta__title is--success">Thank you! We’ll call you back as
                            soon as
                            possible</h2>
                    </div>
                    <div class="w-form-fail">
                        <div>Oops! Something went wrong while submitting the form.</div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    </div>

    <script src="assets/vendor/jquery/jquery.js?site=averroes651fba54cf5533331" type="text/javascript"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <script src="assets/vendor/form-validator/bundle.v1.0.0.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/main.js"></script>
    <script>
        $('.preloader-text').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 1000,
                easing: 'linear',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
        const cardWrappers = document.querySelectorAll('.card-link__wrapper');
        const cardCursors = document.querySelectorAll('.card-cursor');
        let timeout;

        let mouseX = 0;
        let mouseY = 0;

        window.addEventListener('load', () => {
            if (isDesktop()) {
                cardCursors.forEach((cursor, index) => {
                    updateCursorPosition({
                        clientX: mouseX,
                        clientY: mouseY
                    }, cursor);
                });
            }
        });

        window.addEventListener('resize', () => {
            if (isDesktop()) {
                cardCursors.forEach((cursor, index) => {
                    updateCursorPosition({
                        clientX: mouseX,
                        clientY: mouseY
                    }, cursor);
                });
            }
        });

        window.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        window.addEventListener('scroll', () => {
            if (isDesktop()) {
                cardCursors.forEach((cursor, index) => {
                    updateCursorPosition({
                        clientX: mouseX,
                        clientY: mouseY
                    }, cursor);
                });
            }
        });

        cardWrappers.forEach((card, index) => {
            card.addEventListener('mouseenter', (e) => {
                if (isDesktop()) {
                    const cursor = cardCursors[index];
                    cursor.classList.add('cursor--showing');
                    updateCursorPosition(e, cursor);
                }
            });

            card.addEventListener('mousemove', (e) => {
                if (isDesktop()) {
                    const cursor = cardCursors[index];
                    updateCursorPosition(e, cursor);
                }
            });

            card.addEventListener('mouseleave', (e) => {
                if (isDesktop()) {
                    const cursor = cardCursors[index];
                    cursor.classList.remove('cursor--showing');
                }
            });

            card.addEventListener('mouseenter', (e) => {
                const cursor = cardCursors[index];
            });
        });

        function updateCursorPosition(event, cursor) {
            const xOffset = event.clientX - cursor.clientWidth / 2;
            const yOffset = event.clientY - cursor.clientHeight / 2 - (cursor.clientHeight / 2);

            const cardRect = cursor.closest('.card-link__wrapper').getBoundingClientRect();

            const xInCard = Math.max(0, Math.min(cardRect.width - cursor.clientWidth, xOffset - cardRect.left));
            const yInCard = Math.max(0, Math.min(cardRect.height - cursor.clientHeight, yOffset - cardRect.top));

            cursor.style.transform = `translate(${xInCard}px, ${yInCard}px)`;
        }

        function isDesktop() {
            return window.innerWidth >= 1024;
        }
    </script>
    <script>
        // Get all checkbox elements
        const checkboxes = document.querySelectorAll('.w-checkbox-input--inputType-custom');

        function handleClassListChange(mutationsList) {
            mutationsList.forEach(mutation => {
                if (mutation.type === "attributes" && mutation.attributeName === "class") {
                    const targetElement = mutation.target;

                    if (targetElement.classList.contains("cc-error")) {
                        const parentElement = targetElement.parentElement;
                        if (parentElement) {
                            parentElement.classList.add("cc-error");
                        }
                    } else {
                        const parentElement = targetElement.parentElement;
                        if (parentElement) {
                            parentElement.classList.remove("cc-error");
                        }
                    }
                }
            });
        }

        checkboxes.forEach(div => {
            const observer = new MutationObserver(handleClassListChange);

            const config = {
                attributes: true,
                attributeFilter: ["class"]
            };
            observer.observe(div, config);
        });

        // Button ripple
        const Button = {
            init: () => {
                Button.rippleEffectMovement();
            },

            rippleEffectMovement: () => {
                const buttonsNodeList = document.querySelectorAll(".submit-button, .cancel-button-hover");
                buttonsNodeList.forEach((btn) => {
                    const rEffect = btn.querySelector('.span');

                    btn.addEventListener("mousemove", function(e) {
                        const buttonRect = btn.getBoundingClientRect();
                        const x = e.clientX - buttonRect.left;
                        const y = e.clientY - buttonRect.top;

                        rEffect.style.left = `${x}px`;
                        rEffect.style.top = `${y}px`;
                    });
                });
            },
        };

        Button.init();

        // handling form submit

        var submitButtons = document.querySelectorAll('.submit-button');

        if (submitButtons.length > 0) {
            submitButtons.forEach(function(submitButton) {
                submitButton.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the default form submission
                    var parentForm = submitButton.nextElementSibling; // Find the parent form element

                    if (parentForm) {
                        parentForm.click(); // Submit the form
                    } else {
                        console.error('Parent form not found');
                    }
                });
            });
        }

        // Get all elements with the class 'nav-link'
        const navLinks = document.querySelectorAll('.nav-link, a.is--nav');

        // Function to trigger the click event of 'navbar-menu__open-button'
        const triggerOpenButtonClick = () => {
            const openButton = document.querySelector('.navbar-menu__open-button');
            openButton.click();
        };

        // Add click event listener to each 'nav-link' element
        navLinks.forEach(navLink => {
            navLink.addEventListener('click', triggerOpenButtonClick);
        });

        // Navbar
        const navButton = document.getElementById('nav-button');

        navButton.addEventListener('click', () => {
            checkForClass(navButton)
        });

        function checkForClass(navButton) {
            const navButtonText = navButton.querySelector('.text-size-0-625');
            if (!navButton.classList.contains("w--open")) {
                document.querySelector('body').classList.add('overflow-hidden');
                lenis.stop();
            } else {
                document.querySelector('body').classList.remove('overflow-hidden');
                lenis.start();
            }
        }


        const items = document.querySelectorAll('.faq-content__main-number');

        items.forEach(function(item, index) {
            const currentIndex = index + 1;
            item.textContent = currentIndex;
        });

        const images = document.querySelectorAll('img');

        images.forEach((image) => {
            image.removeAttribute('srcset');
        });
        const swiper = new Swiper(".swiper", {
            spaceBetween: 20,
            navigation: {
                nextEl: '.slider-button__next',
                prevEl: '.slider-button__prev',
            },
        });

        // get data-sidebar="slider" elems
        const sidebarSliders = document.querySelectorAll('[data-sidebar="slider"]');

        // loop through all elems
        sidebarSliders.forEach((item, i) => {
            // on click on item slideTo swiper slide with index i
            item.addEventListener('click', () => {
                swiper.slideTo(i);
            })
        });
    </script>
</body>

</html>
