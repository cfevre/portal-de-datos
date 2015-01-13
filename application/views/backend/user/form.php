<form action="<?php echo $formAction; ?>" class="form-horizontal" method="POST" id="fromUsuario">
    <fieldset>
        <legend><?php echo $userForm->getId()?'Edición usuario ['.$userForm->getFullName().']':'Nuevo usuario'; ?></legend>
        <div class="control-group">
            <div class="control-label">
                <label for="fullname">Nombre Completo</label>
            </div>
            <div class="controls">
                <input type="text" name="fullname" id="fullname" autocomplete="off" class="input-xlarge" value="<?php echo $userForm->getFullName(); ?>">
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="email">E-Mail</label>
            </div>
            <div class="controls">
                <?php if ($user->hasRol('mantencion')): ?>
                    <input type="text" name="email" id="email" class="input-xlarge" value="<?php echo $userForm->getEmail(); ?>">
                <?php else: ?>
                    <span><?php echo $userForm->getEmail(); ?></span>
                <?php endif ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="password">Clave</label>
            </div>
            <div class="controls">
                <input type="password" name="password" id="password" autocomplete="off" class="input-xlarge">
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <label for="password-confirm">Confirmar Clave</label>
            </div>
            <div class="controls">
                <input type="password" name="password-confirm" autocomplete="off" id="password-confirm" class="input-xlarge">
            </div>
        </div>
        <?php if ($user->hasRol('mantencion')): ?>
            <div class="control-group">
                <div class="control-label">
                    <label>Roles</label>
                </div>
                <div class="controls">
                    <?php foreach ($rols as $key => $rol){ ?>
                        <label for="<?php echo $rol->getId(); ?>">
                            <?php echo $rol->getNombre(); ?>
                            <input <?php echo $userForm->hasRol($rol->getId())?'checked="checked"':''; ?> type="checkbox" value="<?php echo $rol->getId(); ?>" name="rols[]" id="<?php echo $rol->getId(); ?>">
                        </label>
                    <?php } ?>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label for="servicio">Servicio</label>
                </div>
                <div class="controls">
                <?php 
                    $data = file_get_contents ('https://apis.modernizacion.cl/instituciones/api/instituciones');
                    $json = json_decode($data, TRUE);
                 ?>
                    <select name="servicio" id="servicio" class="input-xxlarge">
                        <option value=""> - Seleccione - </option>
                    <?php foreach ($json['items'] as $key => $servicio){ ?>
                        <option <?php echo $servicio['codigo']==$userForm->getServicio()->getCodigo()?'selected="selected"':''; ?> value="<?php echo $servicio['codigo'] ?>"><?php echo $servicio['nombre'] ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label>Nivel</label>
                </div>
                <div class="controls">
                    <label for="ministerial">
                        <input type="checkbox" <?php echo $userForm->getMinisterial()?'checked="checked"':''; ?> value="1" id="ministerial" name="ministerial">
                        Ministerial
                    </label>
                    <label for="interministerial">
                        <input type="checkbox" <?php echo $userForm->getInterministerial()?'checked="checked"':''; ?> value="1" id="interministerial" name="interministerial">
                        Interministerial
                    </label>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label>Api Token</label>
                </div>
                <div class="controls">
                    <span class="alert alert-success api-toke-container"><?php echo $userForm->getApiToken() ? $userForm->getApiToken() : 'No se ha generado un token.'; ?></span>
                    <button data-ajax-command="generateApiToken/<?php echo $userForm->getId(); ?>" data-ajax-controller="user" class="btn btn-small btn-success"><i class="icon-repeat icon-white"></i> Generar</button>
                    <input type="hidden" name="api_token" id="api_token" class="input-xlarge" value="<?php echo $userForm->getApiToken(); ?>">
                </div>
            </div>
        <?php else: ?>
            <div class="control-group">
                <div class="control-label">
                    <label>Roles</label>
                </div>
                <div class="controls">
                    <p>
                    <?php
                        foreach ($rols as $key => $rol){
                            if($userForm->hasRol($rol->getId()))
                                $a_rols[] = $rol->getNombre();
                        }
                        echo isset($a_rols)?implode(', ', $a_rols):'No hay roles asociados al Usuario';
                    ?>
                    </p>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label for="servicio">Servicio</label>
                </div>
                <div class="controls">
                    <p>
                        <?php echo $userForm->getServicio()->getNombre(); ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <div class="form-actions">
            <button class="btn btn-primary">Guardar</button>
            <?php if ($user->hasRol('mantencion')): ?>
                <a class="btn" href="<?php echo site_url('backend/user'); ?>">Cancelar</a>
            <?php else: ?>
                <a class="btn" href="<?php echo site_url('backend'); ?>">Cancelar</a>
            <?php endif ?>
        </div>
        <input type="hidden" name="id" id="id" value="<?php echo $userForm->getId(); ?>">
    </fieldset>
</form>
<?php if ($user->hasRol('mantencion')): ?>
    <hr>
    <h3>Datasets Asociados al Usuario</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Titulo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($datasets): ?>
                <?php foreach ($datasets as $key => $dataset){ ?>
                    <tr>
                        <td><?php echo $dataset->getId(); ?></td>
                        <td><a href="<?php echo site_url('backend/dataset/view/'.$dataset->getId()); ?>"><?php echo $dataset->getTitulo(); ?></a></td>
                        <td>
                            <?php if(!$dataset->getPublicado()){ ?>
                                <span class="label label-mini label-warning">
                                    <i class="icon-ban-circle"></i>
                                    <span>No Publicado</span>
                                </span>
                            <?php }else{ ?>
                                <span class="label label-mini label-success">
                                    <i class="icon-ok-circle"></i>
                                    <span>Publicado</span>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr>
                    <td colspan="3"><strong>No hay datasets asociados al usuario</strong></td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>   
<?php endif ?>
