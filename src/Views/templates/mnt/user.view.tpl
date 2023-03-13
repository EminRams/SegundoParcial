<h1>{{modedsc}}</h1>
<section class="row">
    <form action="index.php?page=Mnt_User&mode={{mode}}&usercod={{usercod}}" method="post" class="col-6 col-3-offset">
        <section class="row">
            <label for="usercod" class="col-4">Código</label>
            <input type="hidden" id="usercod" name="usercod" value="{{usercod}}" />
            <input type="hidden" id="mode" name="mode" value="{{mode}}" />
            <input type="hidden" name="xssToken" value="{{xssToken}}" />
            <input type="text" readonly name="usercoddummy" value="{{usercod}}" />
        </section>
        <section class="row">
            <label for="username" class="col-4">Usuario</label>
            <input type="text" {{readonly}} name="username" value="{{username}}" maxlength="45"
                placeholder="Nombre del Usuario" />
            {{if username_error}}
            <span class="error col-12">{{username_error}}</span>
            {{endif username_error}}
        </section>

        <section class="row">
            <label for="useremail" class="col-4">Correo</label>
            <input type="email" {{readonly}} name="useremail" value="{{useremail}}" maxlength="45"
                placeholder="Correo electronico del Usuario" />
            {{if useremail_error}}
            <span class="error col-12">{{useremail_error}}</span>
            {{endif useremail_error}}
        </section>

        <section class="row">
            <label for="usertipo" class="col-4">Tipo de Usuario</label>
            <select id="usertipo" name="usertipo" {{if readonly}}disabled{{endif readonly}}>
                <option value="NOR" {{usertipo_NOR}}>Normal</option>
                <option value="CON" {{usertipo_CON}}>Consultor</option>
                <option value="CLI" {{usertipo_CLI}}>Cliente</option>
            </select>
        </section>

        <section class="row">
            <label for="userest" class="col-4">Estado del Usuario</label>
            <select id="userest" name="userest" {{if readonly}}disabled{{endif readonly}}>
                <option value="ACT" {{userest_ACT}}>Activo</option>
                <option value="INA" {{userest_ACT}}>Inactivo</option>
            </select>
        </section>

        <section class="row">
            <label for="useractcod" class="col-4">Identidad Activa</label>
            <input type="text" {{readonly}} name="useractcod" value="{{useractcod}}" maxlength="45"
                placeholder="Identidad Activo del Usuario" />
        </section>

        <section class="row">
            <label for="userpswd" class="col-4">Contraseña</label>
            <input type="text" {{readonly}} name="userpswd" value="{{userpswd}}" maxlength="45"
                placeholder="Contraseña del Usuario" />
            {{if userpswd_error}}
            <span class="error col-12">{{userpswd_error}}</span>
            {{endif userpswd_error}}
        </section>

        <section class="row">
            <label for="userpswdest" class="col-4">Estado de la Contraseña</label>
            <select id="userpswdest" name="userpswdest" {{if readonly}}disabled{{endif readonly}}>
                <option value="ACT" {{userpswdest_ACT}}>Activo</option>
                <option value="INA" {{userpswdest_INA}}>Inactivo</option>
            </select>
        </section>

        <section class="row">
            <label for="userpswdexp" class="col-4">Expiración Contraseña</label>
            <input type="text" {{readonly}} name="userpswdexp" value="{{userpswdexp}}" maxlength="45"
                placeholder="Expiración de la Contraseña" />
        </section>

        <section class="row">
            <label for="userpswdchg" class="col-4">Contraseña Nueva</label>
            <input type="text" {{readonly}} name="userpswdchg" value="{{userpswdchg}}" maxlength="45"
                placeholder="Contraseña Cambiada del Usuario" />
        </section>


        {{if has_errors}}
        <section>
            <ul>
                {{foreach general_errors}}
                <li>{{this}}</li>
                {{endfor general_errors}}
            </ul>
        </section>
        {{endif has_errors}}
        <section>
            {{if show_action}}
            <button type="submit" name="btnGuardar" value="G">Guardar</button>
            {{endif show_action}}
            <button type="button" id="btnCancelar">Cancelar</button>
        </section>
    </form>
</section>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("btnCancelar").addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Mnt_Users");
        });
    });
</script>