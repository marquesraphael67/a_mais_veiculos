<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h2>Arquivos Recebidos:</h2>";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    
    if(isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
        echo "<h3>Fotos enviadas com sucesso!</h3>";
        foreach($_FILES['fotos']['name'] as $key => $name) {
            if(!empty($name)) {
                echo "Foto " . ($key+1) . ": " . $name . "<br>";
            }
        }
    } else {
        echo "<h3 style='color:red'>Nenhuma foto foi selecionada!</h3>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teste Upload Múltiplo</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Teste de Upload de Múltiplas Fotos</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="fotos[]" multiple accept="image/*">
        <br><br>
        <button type="submit">Enviar Fotos</button>
    </form>
    
    <hr>
    <h3>Instruções:</h3>
    <ol>
        <li>Clique em "Escolher arquivos"</li>
        <li>Segure a tecla CTRL e selecione 2 ou mais fotos</li>
        <li>Clique em "Enviar Fotos"</li>
    </ol>
</body>
</html>