<h1>{{modedsc}}</h1>
<section class="row">
    <form action="index.php?page=Mnt_Cliente&mode={{mode}}&clientid={{clientid}}" method="POST"
        class="col-6 col-3-offset">
        <section class="row">
            <label for="clientid" class="col-4">Código</label>
            <input type="hidden" id="clientid" name="clientid" value="{{clientid}}" />
            <input type="hidden" id="mode" name="mode" value="{{mode}}" />
            <input type="hidden" name="xssToken" value="{{xssToken}}" />
            <input type="text" readonly name="clientiddummy" value="{{clientid}}" />
        </section>
        <section class="row">
            <label for="clientname" class="col-4">Cliente</label>
            <input type="text" {{readonly}} name="clientname" value="{{clientname}}" maxlength="45"
                placeholder="Nombre del Cliente" />
            {{if clientname_error}}
            <span class="error col-12">{{clientname_error}}</span>
            {{endif clientname_error}}
        </section>

        <section class="row">
            <label for="clientgender" class="col-4">Género</label>
            <select id="clientgender" name="clientgender" {{if readonly}}disabled{{endif readonly}}>
                <option value="MAL" {{clientgender_MAL}}>Masculino</option>
                <option value="FEM" {{clientgender_FEM}}>Femenino</option>
            </select>
        </section>

        <section class="row">
            <label for="clientphone1" class="col-4">Teléfono 1</label>
            <input type="text" {{readonly}} name="clientphone1" value="{{clientphone1}}" maxlength="45"
                placeholder="Teléfono Principal del Cliente" />
        </section>
        <section class="row">
            <label for="clientphone2" class="col-4">Teléfono 2</label>
            <input type="text" {{readonly}} name="clientphone2" value="{{clientphone2}}" maxlength="45"
                placeholder="Teléfono Secundario del Cliente" />
        </section>

        <section class="row">
            <label for="clientemail" class="col-4">Correo</label>
            <input type="email" {{readonly}} name="clientemail" value="{{clientemail}}" maxlength="45"
                placeholder="Correo electronico del Cliente" />
            {{if clientemail_error}}
            <span class="error col-12">{{clientemail_error}}</span>
            {{endif clientemail_error}}
        </section>

        <section class="row">
            <label for="clientIdnumber" class="col-4">Identidad</label>
            <input type="text" {{readonly}} name="clientIdnumber" value="{{clientIdnumber}}" maxlength="45"
                placeholder="ID del Cliente" />
        </section>

        <section class="row">
            <label for="clientbio" class="col-4">Biografía</label>
            <input type="text" {{readonly}} name="clientbio" value="{{clientbio}}" maxlength="5000"
                placeholder="Biografía del Cliente" />
            {{if clientbio_error}}
            <span class="error col-12">{{clientbio_error}}</span>
            {{endif clientbio_error}}
        </section>

        <section class="row">
            <label for="clientstatus" class="col-4">Estado</label>
            <select id="clientstatus" name="clientstatus" {{if readonly}}disabled{{endif readonly}}>
                <option value="ACT" {{clientstatus_ACT}}>Activo</option>
                <option value="INA" {{clientstatus_INA}}>Inactivo</option>
            </select>
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
            window.location.assign("index.php?page=Mnt_Clientes");
        });
    });
</script>