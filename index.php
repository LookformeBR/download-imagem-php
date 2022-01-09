<?php
// se o botão de download for clicado
if(isset($_POST['downloadBtn'])){
  // obtendo o usuário img url do campo de entrada
    $imgURL = $_POST['file']; // armazenando na variável
    $regPattern = '/\.(jpe?g|png|gif|bmp)$/i';// padrão para validar a extensão img
    if(preg_match($regPattern, $imgURL)){ // se o padrão corresponder ao url img do usuário
        $initCURL = curl_init($imgURL); // inicializando o curl
        curl_setopt($initCURL, CURLOPT_RETURNTRANSFER, true);
        $downloadImgLink = curl_exec($initCURL); //executing curl
        curl_close($initCURL); // executando curl
       // agora convertemos o formato de base 64 para jpg para fazer o download
        header('Content-type: image/jpg'); // em qual extensão você deseja salvar img
        header('Content-Disposition: attachment;filename="image.jpg"');// em qual nome você deseja salvar img
        echo $downloadImgLink;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Download da imagem em PHP | Lucas Hilario Santos</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="preview-box">
            <div class="cancel-icon"><i class="fas fa-times"></i></div>
            <div class="img-preview"></div>
            <div class="content">
                <div class="img-icon"><i class="far fa-image"></i></div>
                <div class="text">Cole o url da imagem abaixo, <br/>para ver uma prévia ou baixar!</div>
            </div>
        </div>
        <form action="index.php" method="POST" class="input-data">
            <input id="field" type="text" name="file" placeholder="Cole o url da imagem para fazer o download ..." autocomplete="off">
            <input id="button" name="downloadBtn" type="submit" value="Download">
        </form>
    </div>

    <script>
        $(document).ready(function(){
           // se o usuário focar fora do campo de entrada
            $("#field").on("focusout", function(){
             // obtendo o URL img inserido pelo usuário
                var imgURL = $("#field").val();
                if(imgURL != ""){ // se o campo de entrada não estiver em branco
                    var regPattern = /\.(jpe?g|png|gif|bmp)$/i; // padrão para validar a extensão img
                    if(regPattern.test(imgURL)){ // se o padrão corresponder ao url da imagem
                        var imgTag = '<img src="'+ imgURL +'" alt="">'; // criando uma nova tag img para mostrar img
                        $(".img-preview").append(imgTag);// anexando a tag img ao url img inserido pelo usuário
                        // adicionando uma nova classe que criei em css
                        $(".preview-box").addClass("imgActive");
                        $("#button").addClass("active");
                        $("#field").addClass("disabled");
                        $(".cancel-icon").on("click", function(){
                         // removeremos todas as novas classes adicionadas ao clicar no ícone de cancelamento
                            $(".preview-box").removeClass("imgActive");
                            $("#button").removeClass("active");
                            $("#field").removeClass("disabled");
                            $(".img-preview img").remove();
                          // está tudo em javascript / jquery agora a parte principal é PHP
                        });
                    }else{
                        alert("Invalid img URL - " + imgURL);
                        $("#field").val('');// se o padrão não corresponder, vamos deixar o campo de entrada em branco
                    }
                }
            });
        });
    </script>
    
</body>
</html>