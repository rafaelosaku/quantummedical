<section class="full-width" id="contato">
    <div class="contato-form">
        <h1 class="fontzero"><?= $pg_title; ?></h1>
        <?php
        $Contato = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if($Contato && $Contato['EnviarFormContato']):
            unset($Contato['EnviarFormContato']);
            $Contato['Assunto'] = 'Contato via site! (Página contato)';
            $Contato['DestinoNome'] = 'Contato';
            $Contato['DestinoEmail'] = MAILUSER;
            
            $SendMail = new Email;
            $SendMail->Enviar($Contato);
            
            if($SendMail->getError()):
                WSErro($SendMail->getError()[0], $SendMail->getError()[1]);
            endif;
        endif;
        ?>
        <form name="contato" action="#contato" method="post" enctype="">
            <fieldset>
                <label>
                    <span>Nome:</span>
                    <input class="text" type="text" name="RemetenteNome" required/>
                </label>
                <label>
                    <span>E-mail:</span>
                    <input class="text" type="text" name="RemetenteEmail" required/>
                </label>
                <label class="phone">
                    <span>Telefone fixo:</span>
                    <input class="text" type="text" name="RemetenteFixo" />
                </label>
                <label class="phone">
                    <span>Telefone celular:</span>
                    <input class="text" type="text" name="RemetenteCelular" required/>
                </label>
                <label>
                    <span>Mensagem:</span>
                    <textarea class="text" rows="10" name="Mensagem" required></textarea>
                </label>
            </fieldset>
            <input class="btn btn-primary" type="submit" name="EnviarFormContato" value="Enviar"/>
        </form>
    </div>
</section>
