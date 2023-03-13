<h1>Gestión de Usuarios</h1>
<section class="WWFilter">

</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Fecha Creación</th>
                <th>Contraseña</th>
                <th>Estado Contraseña</th>
                <th>Expiración Contraseña</th>
                <th>Contraseña Nueva</th>
                <th>Estado user</th>
                <th>Identidad Activa</th>
                <th>Tipo user</th>
                <th>
                    {{if new_enabled}}
                    <button id="btnAdd">Nuevo</button>
                    {{endif new_enabled}}
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach users}}
            <tr>
                <td>{{usercod}}</td>
                <td><a href="index.php?page=mnt_user&mode=DSP&usercod={{usercod}}">{{username}}</a></td>
                <td>{{useremail}}</td>
                <td>{{userfching}}</td>
                <td>{{userpswd}}</td>
                <td>{{userpswdest}}</td>
                <td>{{userpswdexp}}</td>
                <td>{{userpswdchg}}</td>
                <td>{{userest}}</td>
                <td>{{useractcod}}</td>
                <td>{{usertipo}}</td>
                <td>
                    {{if ~edit_enabled}}
                    <form action="index.php" method="get">
                        <input type="hidden" name="page" value="mnt_user" />
                        <input type="hidden" name="mode" value="UPD" />
                        <input type="hidden" name="usercod" value={{usercod}} />
                        <button type="submit">Editar</button>
                    </form>
                    {{endif ~edit_enabled}}
                    {{if ~delete_enabled}}
                    <form action="index.php" method="get">
                        <input type="hidden" name="page" value="mnt_user" />
                        <input type="hidden" name="mode" value="DEL" />
                        <input type="hidden" name="usercod" value={{usercod}} />
                        <button type="submit">Eliminar</button>
                    </form>
                    {{endif ~delete_enabled}}
                </td>
            </tr>
            {{endfor users}}
        </tbody>
    </table>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("btnAdd").addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=mnt_user&mode=INS&usercod=0");
        });
    });
</script>