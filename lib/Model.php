<?php

namespace lib;

use utl\Redirect;

class Model
{
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * sanitize
     * @param integer $tipo Descrição: 1 => usuario / 2 => senha / 3 => email / 4 => mixed (evite usar) / 5 => números inteiros / 6 => palavra / 7 => palavras / default => texto comum
     * @param string $name nome da entrada dentro de $_POST (se $_POST['bla'], então $name="bla")
     * @param string $local Destino para redirecionar em caso de erro ("" => index)
     * @return string $data Retorna variavel que estava em POST validada
     */
    public function sanitize($tipo, $name, $local)
    {
        try {
            $form = new Form();
            switch ($tipo) :
                case 1:
                    $form   ->post($name, 1)
                            ->val('alpha')
                            ->val('minLength', 4)
                            ->val('maxLength', 32)

                            ->submit();
                    $data = $form->fetch();
                    $dataFilter = filter_var(trim($data[$name]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if ($dataFilter != $data[$name]) :
                        throw new \Exception("Caracteres especiais não são permitidos");
                    endif;
                    break;
                case 2:
                    $form   ->post($name)
                            ->val('minLength', 6)
                            ->val('maxLength', 32)

                            ->submit();
                    $data = $form->fetch();
                    $dataFilter = filter_var(trim($data[$name]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if ($dataFilter != $data[$name]) :
                        throw new \Exception("Caracteres especiais não são permitidos");
                    endif;
                    break;
                case 3:
                    $form   ->post($name)
                            ->val('minLength', 3)

                            ->submit();
                    $data = $form->fetch();
                    $dataFilter = filter_var(trim($data[$name]), FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
                    if ($dataFilter != $data[$name]) :
                        throw new \Exception("Formato de email inválido");
                    endif;
                    break;
                case 4:
                    $form   ->post($name)
                            ->val('minLength', 1)

                            ->submit();
                    $data = $form->fetch();
                    $dataFilter = trim($data[$name]);
                    break;

                case 5:
                    $form   ->post($name)
                            ->val('minLength', 1)
                            ->val('digit')

                            ->submit();
                    $data = $form->fetch();
                    $dataFilter = filter_var(trim($data[$name]), FILTER_VALIDATE_INT);
                    if ($dataFilter != $data[$name]) :
                        throw new \Exception("Somente números são permitidos");
                    endif;
                    break;
                case 6:
                    $form   ->post($name, 1)
                            ->val('minLength', 1)
                            ->val('maxLength', 32)
                            ->val('alpha')

                            ->submit();
                    $data = $form->fetch();
                    $dataFilter = filter_var(trim($data[$name]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if ($dataFilter != $data[$name]) :
                        throw new \Exception("Caracteres especiais não permitidos");
                    endif;
                    break;
                case 7:
                    $form   ->post($name, 1)
                            ->val('minLength', 1)
                            ->val('maxLength', 32)
                            ->val('alphaPlusSpaces')

                            ->submit();
                    $data = $form->fetch();
                    $dataFilter = filter_var(trim($data[$name]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if ($dataFilter != $data[$name]) :
                        throw new \Exception("Caracteres especiais não permitidos");
                    endif;
                    break;
                default:
                    $form   ->post($name, 1)
                            ->val('minLength', 1)

                            ->submit();
                    $data = $form->fetch();
                    $dataFilter = filter_var(trim($data[$name]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    if ($dataFilter != $data[$name]) :
                        throw new \Exception("Caracteres especiais não permitidos");
                    endif;
            endswitch;
        } catch (\Exception $e) {
            $this->msg($e->getMessage(), "warning", $local);
        }
        return $dataFilter;
    }

    /**
     * error
     * @param string $text Mensagem de erro
     * @param string $tipo Nível do erro ("warning", "info", "danger", "success")
     */
    public function msg($text, $tipo, $local = "")
    {
        Session::init();
        Session::set('message', $text);
        Session::set('tipo', $tipo);
        Redirect::redirect(URL . $local);
    }

    /**
     * verifyImg Verifica se imagem existe e se respeita as restrições
     * @return string $target_file Retorna localização do arquivo ou '' caso as verificações falhem
     */
    public function verifyImg($file)
    {
        //Local de upload de arquivo
        $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($file["error"] == 0) :
            // Verifica se é mesmo uma imagem
            $check = getimagesize($file["tmp_name"]);
            if ($check !== false) :
                $uploadOk = 1;
            else :
                $uploadOk = 0;
            endif;

            // Verifica tamanho do arquivo
            if ($file["size"] > 1000000) :
                $uploadOk = 0;
            endif;
        else :
            $uploadOk = 0;
        endif;

        // Verifica se houve algum erro
        if ($uploadOk == 0) :
            $target_file = '';
        else :
            // Faz upload se nada deu errado
            if (move_uploaded_file($file["tmp_name"], $target_file)) :
            else :
                $target_file = '';
            endif;
        endif;

        return $target_file;
    }
}
