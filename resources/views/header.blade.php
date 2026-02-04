<style>
    input[type=checkbox]{
    	height: 0;
    	width: 0;
    	visibility: hidden;
    }

    /*label {
    	cursor: pointer;
    	text-indent: -9999px;
    	width: 200px;
    	height: 100px;
    	background: grey;
    	display: block;
    	border-radius: 100px;
    	position: relative;
    }

    label:after {
    	content: '';
    	position: absolute;
    	top: 5px;
    	left: 5px;
    	width: 90px;
    	height: 90px;
    	background: #fff;
    	border-radius: 90px;
    	transition: 0.3s;
    }*/

    input:checked + label {
    	background: #bada55;
    }

    input:checked + label:after {
    	left: calc(100% - 5px);
    	transform: translateX(-100%);
    }

    label:active:after {
    	width: 130px;
    }

    // centering
    body {
    	display: flex;
    	justify-content: center;
    	align-items: center;
    	height: 100vh;
    }
</style>

<header class="transparent header-light header-float">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header-inner" style="background-color: #ffffff;">
                    <div class="de-flex">
                        <div class="de-flex-col">
                            <!-- logo begin -->
                            <div id="logo" style="padding:15px 0 15px 0;>
                                <a href="index.html">
                                    <img class="logo-main" src="" alt="" >
                                    <img class="logo-scroll" src="" alt="" >
                                    <img class="logo-mobile" src="" alt="" >
                                </a>
                            </div>
                            <!-- logo close -->
                        </div>
                        <div class="de-flex-col">
                            <div class="de-flex-col header-col-mid">
                                <ul id="mainmenu">
                                    @if(isset($asesor))
                                    <li><a class="menu-item" href="#">Asesor</a>{{ $asesor }}</li>
                                    @endif
                                    @if(isset($client))
                                    <li><a class="menu-item" href="#">Cliente</a>{{ $client }}</li>
                                    @endif
                                    @if(!empty($menu))
                                    <li class="just-phone"><a class="menu-item" href="{{ route('disponibilidad') }}">Disponibilidad</a></li>
                                    <li class="just-phone"><a class="menu-item" href="{{ route('torre') }}">Listado</a></li>
                                    <li class="just-phone"><a class="menu-item" href="{{ route('client-login') }}">
                                        @if(!empty($sender))
                                            Cambiar Cliente
                                        @else
                                            Registrar Cliente
                                        @endif
                                    </a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="de-flex-col">
                            @if(!empty($menu))
                            <a class="btn-main fx-slide w-100" style="background-color: #c5693b" href="{{ route('client-login') }}"><span>
                                @if(!empty($sender))
                                    Cambiar Cliente
                                @else
                                    Registrar Cliente
                                @endif
                            </span></a>
                            @endif
                            <div class="menu_side_area">
                                <span id="menu-btn"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section id="section-hero" class="text-light no-top no-bottom relative overflow-hidden z-1000">
    <div class="abs w-100 abs-centered z-2">
        <div class="container">
            <div class="spacer-double"></div>
            <div class="row g-4 align-items-center justify-content-between">
                <div class="col-md-5">
                    <img src="images/fluye.png" class="w-100 wow fadeInUp" data-wow-delay=".2s" alt="">
                </div>
                @if(!empty($menu))
                <div class="col-lg-4">
                    <a class="btn-main btn-line bg-blur fx-slide" href="{{ route('disponibilidad') }}"><span>Disponibilidad</span></a>&nbsp;
                    <a class="btn-main btn-line bg-blur fx-slide" href="{{ route('torre') }}"><span>Listado</span></a>&nbsp;
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="vertical-center">
        <div class="swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="swiper-inner" data-bgimage="url(images/torre-simona.jpg)">
                    <div class="sw-overlay op-4"></div>
                </div>
            </div>
          </div>
          
        </div>
    </div>
</section>