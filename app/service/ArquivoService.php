<?php 
//Classe service para salvar arquivos na base de dados

require_once(__DIR__ . "/../util/config.php");

class ArquivoService {

    //Salvar um arquivo
    public function salvarArquivo(array $arquivo) {
        //Verifica se o arquivo foi enviado pelo usuário
        if($arquivo['size'] <= 0) 
            return null;

        //Captura o nome e a extensão do arquivo
        $arquivoNome = explode('.', $arquivo['name']);
        $arquivoExtensao = $arquivoNome[count($arquivoNome)-1];
        
        //A partir da extensão, o ideal é gerar um nome único para o arquivo
        //A função uniqid gera um identificador único do tipo UUID (hexadecimal)
        $nomeUnico = uniqid('arquivo_');
        $nomeArquivoSalvar = $nomeUnico . "." . $arquivoExtensao;

        //Salva a foto no diretorio de arquivos
        if(move_uploaded_file($arquivo["tmp_name"], 
                            PATH_ARQUIVOS. "/" . $nomeArquivoSalvar)) { 
            //Se salvou, retorna o nome do arquivo
            return $nomeArquivoSalvar;
        }

        return null; //Não salvou, então retorna nulo
    }

    //Remover um arquivo
    public function removerArquivo($nomeArquivo) {
        $caminhoArquivo = PATH_ARQUIVOS . "/" . $nomeArquivo;

        if(file_exists($caminhoArquivo))
            unlink($caminhoArquivo);
    }

}