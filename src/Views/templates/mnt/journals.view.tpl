<h1>Gestión de Diarios</h1>
<section class="WWFilter">

</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Descrición</th>
                <th>Costo</th>
                <th>Fecha Creación</th>
                <th>
                    {{if new_enabled}}
                    <button id="btnAdd">Nuevo</button>
                    {{endif new_enabled}}
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach journals}}
            <tr>
                <td>{{journal_id}}</td>
                <td><a href="index.php?page=mnt_journal&mode=DSP&journal_id={{journal_id}}">{{journal_date}}</a></td>
                <td>{{journal_type}}</td>
                <td>{{journal_description}}</td>
                <td>{{journal_amount}}</td>
                <td>{{created_at}}</td>
                <td>
                    {{if ~edit_enabled}}
                    <form action="index.php" method="get">
                        <input type="hidden" name="page" value="mnt_journal" />
                        <input type="hidden" name="mode" value="UPD" />
                        <input type="hidden" name="journal_id" value={{journal_id}} />
                        <button type="submit">Editar</button>
                    </form>
                    {{endif ~edit_enabled}}
                    {{if ~delete_enabled}}
                    <form action="index.php" method="get">
                        <input type="hidden" name="page" value="mnt_journal" />
                        <input type="hidden" name="mode" value="DEL" />
                        <input type="hidden" name="journal_id" value={{journal_id}} />
                        <button type="submit">Eliminar</button>
                    </form>
                    {{endif ~delete_enabled}}
                </td>
            </tr>
            {{endfor journals}}
        </tbody>
    </table>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("btnAdd").addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=mnt_journal&mode=INS&journal_id=0");
        });
    });
</script>