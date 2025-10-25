<!DOCTYPE html>
<html>
<head>
    @include('listing-utils::head')
    @stack('styles')
</head>
<style>

.container
{
    margin-top: 10%;
}

@media screen and (min-width: 768px) {
    .card{
    margin-top:60px;
    width: 33%;
    }
}

@media screen and (max-width: 768px) {
    .card{
    margin-top:60px;
    width: 90%;
    }
}

.card-footer
{
    background-color: rgb(0 0 0 / 33%);
}

.card-body
{
    padding: 36px;
}

.card-header
{
    background-color: rgb(0 0 0 / 0%);
    border: 0 solid transparent;
}

body
{
    background-image: url('Images/background');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-position: bottom;
}
.btn-form{
    background-color:#6c757d;
    border-style:none;
}
.btn-form:hover{
    background-color:#6c757d;
    border-style:none;
}
.content{
    display: flex;
    justify-content: center;
    align-items: center;
}
.info{
    text-align: center;
}
</style>

<body>
    <div class="wrapper wrapper-full-page ">
        <div class="content">
            <div class="card">
                <div class="card-header ">
                    <h3 class="header text-center"><img class="login-logo" src=""  width="60%" height="auto"></h3>
                </div>
                <div class=" card-body">
                    <p style="font-size:18px; text-align: center; ">Lamentamos informarle que la unidad en la que estaba interesado ya no está disponible. Le invitamos a ponerse en contacto con su asesor para conocer la disponibilidad actual o para cotizar otra unidad que se ajuste a sus necesidades.<br><br>Estamos a su disposición para cualquier consulta adicional.</p>
                </div>
                <div class="card-footer">
                    <div class="info">
                        <p class="footer-text" style="margin-top: 1%;">{{ $asesor->name }}</p>
                        <p class="footer-text">{{ $asesor->mail }}</p>
                        <p class="footer-text">{{ $asesor->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>