<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    
    // Verifique se a URL é válida
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        // Comando para executar yt-dlp
        $command = "yt-dlp -o '%(title)s.%(ext)s' " . escapeshellarg($url);
        
        // Execute o comando
        exec($command, $output, $return_var);
        
        if ($return_var === 0) {
            // Sucesso, redirecionar para o arquivo baixado
            $filename = end($output); // O último item do output deve ser o nome do arquivo
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
        } else {
            echo "Erro ao baixar o vídeo.";
        }
    } else {
        echo "URL inválida.";
    }
} else {
    echo "Nenhuma URL fornecida.";
}
?>
