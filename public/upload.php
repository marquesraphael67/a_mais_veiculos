<?php
echo "<h2>Resultado do Upload</h2>";
echo "<pre>";
print_r($_FILES);
echo "</pre>";

if(isset($_FILES['fotos']) && is_array($_FILES['fotos']['name'])) {
    $total = count(array_filter($_FILES['fotos']['name']));
    echo "<h3>Total de arquivos enviados: " . $total . "</h3>";
    
    for($i = 0; $i < count($_FILES['fotos']['name']); $i++) {
        if(!empty($_FILES['fotos']['name'][$i])) {
            echo "Foto " . ($i+1) . ": " . $_FILES['fotos']['name'][$i] . "<br>";
            echo "Erro: " . $_FILES['fotos']['error'][$i] . "<br>";
        }
    }
}
?>