<h1>{{modedsc}}</h1>
<section class="row">
    <form action="index.php?page=Mnt_Journal&mode={{mode}}&journal_id={{journal_id}}" method="post"
        class="col-6 col-3-offset">
        <section class="row">
            <label for="journal_id" class="col-4">Código</label>
            <input type="hidden" id="journal_id" name="journal_id" value="{{journal_id}}" />
            <input type="hidden" id="mode" name="mode" value="{{mode}}" />
            <input type="hidden" name="xssToken" value="{{xssToken}}" />
            <input type="text" readonly name="journal_iddummy" value="{{journal_id}}" />
        </section>


        <section class="row">
            <label for="journal_date" class="col-4">Fecha Publicación</label>
            <input type="date" {{readonly}} name="journal_date" value="{{journal_date}}" maxlength="45"
                placeholder="Fecha del Diario" />
            {{if journal_date_error}}
            <span class="error col-12">{{journal_date_error}}</span>
            {{endif journal_date_error}}
        </section>

        <section class="row">
            <label for="journal_type" class="col-4">Tipo de Diario</label>
            <select id="journal_type" name="journal_type" {{if readonly}}disabled{{endif readonly}}>
                <option value="1" {{journal_type_DEB}}>Débito</option>
                <option value="2" {{journal_type_CRE}}>Crédito</option>
            </select>
        </section>

        <section class="row">
            <label for="journal_description" class="col-4">Descrición</label>
            <input type="text" {{readonly}} name="journal_description" value="{{journal_description}}" maxlength="45"
                placeholder="Descripción del Diario" />
            {{if journal_description_error}}
            <span class="error col-12">{{journal_description_error}}</span>
            {{endif journal_description_error}}
        </section>

        <section class="row">
            <label for="journal_amount" class="col-4">Monto</label>
            <input type="number" step="0.01" {{readonly}} name="journal_amount" value="{{journal_amount}}" maxlength="45"
                placeholder="Monto del Diario $" />
            {{if journal_amount_error}}
            <span class="error col-12">{{journal_amount_error}}</span>
            {{endif journal_amount_error}}
        </section>

        <section class="row">
            <label for="created_at" class="col-4">Fecha de Creación del Registro</label>
            <input type="datetime-local" {{readonly}} {{created_readonly}} name="created_at" value="{{created_at}}" maxlength="45" />
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
            window.location.assign("index.php?page=Mnt_Journals");
        });
    });
</script>