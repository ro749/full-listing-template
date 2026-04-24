<style>
    #footer-logos{
        justify-content: center; 
        align-items: center; 
    }
    @media (min-width: 768px) {
        #plan-div-personal{
            width: 50%;
        }
        #footer-logos{
            gap: 6rem;
        }
    }
    @media (max-width: 768px) {
        #footer-logos{
            gap: 1rem;
        }
    }
</style>
<footer class="section-dark" style="background-color:{{ $color }} !important;">
        <div class="container">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center">
                        <div id="footer-logos" class="responsive-row" style="">
                            @foreach ($logos as $key => $logo)
                                <img id="footer-logo-{{ $key }}" src="{{ $logo }}" class="footer-logo" alt="">
                            @endforeach
                        </div>
                        <div class="spacer-single"></div>
                        <div class="fs-16">
                            {!! $location !!}
                        </div>
                    </div>
                </div>                
            </div>

            <div class="spacer-double"></div>

            <div class="row g-4" style="justify-content: center;">
                @if(!empty($phone))
                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="d-flex justify-content-center" style="align-items: center; gap: 1rem;">
                        <i class="fs-30 icon_phone" style="height: auto; color: {{ $icon_color }};"></i>
                        <h4 class="mb-0">Llámanos</h4>      
                    </div>
                    <p style="text-align: center">{{ $phone }}</p>
                </div>
                @endif
                @if(!empty($schedule))
                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="d-flex justify-content-center" style="align-items: center; gap: 1rem;">
                        <i class="fs-30 icon_clock" style="height: auto; color: {{ $icon_color }};"></i>
                        <h4 class="mb-0">Horario</h4>      
                    </div>
                    <p style="text-align: center">{!! $schedule !!}</p>
                </div>
                @endif
                @if(!empty($email))
                <div class="col-lg-4 col-md-6 mb-sm-30">
                    <div class="d-flex justify-content-center" style="align-items: center; gap: 1rem;">
                        <i class="fs-30 icon_mail" style="height: auto; color: {{ $icon_color }};"></i>
                        <h4 class="mb-0">Email</h4>      
                    </div>
                    <p style="text-align: center">{{ $email }}</p>
                </div>  
                @endif            
            </div>

        </div>
        <div class="subfooter">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style="text-align:center;">
                        <a href="https://propstudios.mx/">Sistema Desarrollado por PropStudios</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>