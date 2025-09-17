<?php
#Nome do arquivo: login/login.php
#Objetivo: interface para logar no sistema
$pagina = 'login';

require_once(__DIR__ . "/../include/header.php");
?>
<div class="container d-flex justify-content-center" style="padding-top: 50px; max-height: 600px;">
    <div class="row w-100" style="max-width: 800px;">
        <!-- CARD DO FORMULÁRIO -->
        <div class="col-md-6">
            <div class="card shadow p-1 rounded-lg" style="width: 700px; height: 750px; background-color: rgba(255, 255, 255, 0.33); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
                <img src="<?= BASEURL . '/view/img/Logo.png'?>" style="display: block; margin: 0 auto 10px auto; height: 400px; width: 400px;">

                <h3 class="mb-3"  style="text-align: center;" ><B>LOGIN</B></h3>
                <!-- MENSAGENS DE ERRO AO LADO -->
                <div class=" align-items-center" style="max-width: 600px; padding-left: 85px ;">
                    <h11  style="text-align: center;"><?php include_once(__DIR__ . "/../include/msg.php") ?></h11>
                </div>
                <form id="frmLogin" action="./LoginController.php?action=logon" method="POST">
                    <div class="mb-3" style="max-width: 600px; padding-left: 85px ;" >
                        <!--<label class="form-label" for="txtEmail">Login:</label>-->
                        <input type="text" class="form-control" name="email" id="txtEmail"
                            maxlength="255" placeholder="Email"
                            value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" />        
                    </div>

                    <div class="mb-3" style="max-width: 600px; padding-left: 85px ;">
                        <!--<label class="form-label" for="txtSenha">Senha:</label>-->
                        <input type="password" class="form-control" name="senha" id="txtSenha"
                            maxlength="255" placeholder="Senha"
                            value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />        
                    </div>
                    
                    <div class="mb-3" style="padding-left: 85px;">

                        <button type="submit" class="btn btn-success mt-3">Acessar</button>
                        <a href="<?= BASEURL . '/controller/CadUserController.php?action=create' ?>" class="btn btn-primary mt-3">Cadastrar</a>
                        </div>
                        
                    <h6 class="mb-4" style="padding-left: 85px; padding-top: 30px">Bora construi um futuro melhor 💪🎓📚</h6>
                </form>
                
            </div>
        </div>

    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
