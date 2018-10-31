<?php

require '_app/Library/PHPMailer/class.phpmailer.php';

/**
 * Email [ MODEL ]
 * Responsável por configurar a PHPMailer, validar os dados e displarar e-mails do sistema! 
 * @copyright (c) 2016, Rafael Osaku Desenvolvimento
 */
class Email {

    /** @var PHPMailer */
    private $Mail;

    /** EMAIL DATA */
    private $Data;

    /** CORPO DO EMAIL */
    private $Assunto;
    private $Mensagem;

    /** REMTENTE */
    private $RemetenteNome;
    private $RemetenteEmail;

    /** DESTINO */
    private $DestinoNome;
    private $DestinoEmail;

    /** CONTROLE */
    private $Error;
    private $Result;

    function __construct() {
        $this->Mail = new PHPMailer;
        $this->Mail->Host = MAILHOST;
        $this->Mail->Port = MAILPORT;
        $this->Mail->Username = MAILUSER;
        $this->Mail->Password = MAILPASS;
        $this->Mail->CharSet = 'UTF-8';
    }

    /**
     * <b>Enviar E-mail SMTP:</b> Envelope os dados em um array atribuítivo para povoar o método.
     * Com isso execute este método para ter toda a validação de envio feita automaticamente;
     * 
     * <b>REQUER DADOS ESPECÍFICOS:</b> Para enviar o e-mail você deve montar um array atribuítivo com os 
     * seguintes índices corretamente povoados:<br><br>
     * <i>
     * &raquo; Assunto<br>
     * &raquo; Mensagem<br>
     * &raquo; RemetenteNome<br>
     * &raquo; RemetenteEmail<br>
     * &raquo; DestinoNome<br>
     * &raquo; DestinoEmail
     * </i>
     * @param ARRAY $Data
     */
    public function Enviar(array $Data) {
        $this->Data = $Data;
        $this->Clear();

        if (in_array('', $this->Data)):
            $this->Error = ['<b>Erro ao enviar mensagem:</b> Para enviar a mensagem preencha todos os campos!', WS_ERROR];
            $this->Result = FALSE;
        elseif (!Check::Email($this->Data['RemetenteEmail'])):
            $this->Error = ['<b>Erro ao enviar mensagem:</b> Para enviar a mensagem informe um e-mail válido!', WS_ERROR];
            $this->Result = FALSE;
        else:
            $this->setMail();
            $this->Config();
            $this->sendMail();
        endif;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com o erro e o tipo de erro.
     * @return ARRAY $Error = Array associatiVo com o erro
     */
    function getError() {
        return $this->Error;
    }

    /**
     * <b>Verificar Envio:</b> Executando um getResult é possível verificar se foi ou não efetuado 
     * o envio do e-mail. Para mensagens execute o getError();
     * @return BOOL $Result = TRUE or FALSE
     */
    function getResult() {
        return $this->Result;
    }

    // ***************************************
    // *********** PRIVATE METHODS ***********
    // ***************************************
    //LIMPA CÓDIGOS E ESPAÇOS
    private function Clear() {
        array_map('strip_tags', $this->Data);
        array_map('trim', $this->Data);
    }

    //PREPARA O E-MAIL PARA ENVIO
    private function setMail() {
        $this->Assunto = $this->Data['Assunto'];
        $this->Mensagem = $this->Data['Mensagem'];
        $this->RemetenteNome = $this->Data['RemetenteNome'];
        $this->RemetenteEmail = $this->Data['RemetenteEmail'];
        $this->DestinoNome = $this->Data['DestinoNome'];
        $this->DestinoEmail = $this->Data['DestinoEmail'];

        $this->Data = NULL;
        $this->setMsg();
    }

    //PERSONALIZA MENSAGEM
    private function setMsg() {
        $this->Mensagem = "{$this->Mensagem}<hr><small>Recebida em:" . date('d/m/Y H:i') . "</small>";
    }

    //CONFIGURA O PHP MAILER
    private function Config() {
        //SMTP AUTH
        $this->Mail->IsSMTP();
        $this->Mail->SMTPAuth = TRUE;
        $this->Mail->SMTPSecure = "ssl";
        $this->Mail->IsHTML();

        //REMETENTE E RETORNO
        $this->Mail->From = MAILUSER;
        $this->Mail->FromName = $this->RemetenteNome;
        $this->Mail->AddReplyTo($this->RemetenteEmail, $this->RemetenteNome);

        //ASSUNTO, MENSAGEM E DESTINO
        $this->Mail->Subject = $this->Assunto;
        $this->Mail->Body = $this->Mensagem;
        $this->Mail->AddAddress($this->DestinoEmail, $this->DestinoNome);
    }

    private function sendMail() {
        if ($this->Mail->Send()):
            $this->Error = ['Obrigado por entrar em contato! Recebemos sua mensagem, e logo retornaremos!', WS_ACCEPT];
            $this->Result = TRUE;
        else:
            $this->Error = ["<b>Erro ao enviar:</b> Entre em contato com o admin. ( {$this->Mail->ErrorInfo} )", WS_ERROR];
            $this->Result = FALSE;
        endif;
    }

}
