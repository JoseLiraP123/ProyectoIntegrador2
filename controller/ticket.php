<?php
    /* TODO:Cadena de Conexion */
    require_once("../config/conexion.php");
    /* TODO:Clases Necesarias */
    require_once("../models/Ticket.php");
    $ticket = new Ticket();

    require_once("../models/Usuario.php");
    $usuario = new Usuario();

    require_once("../models/Documento.php");
    $documento = new Documento();

    $key="mi_key_secret";
    $cipher="aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    /*TODO: opciones del controlador Ticket*/
    switch($_GET["op"]){

        /* TODO: Insertar nuevo Ticket */
        case "insert":
            $datos=$ticket->insert_ticket($_POST["usu_id"],$_POST["cat_id"],$_POST["cats_id"],$_POST["tick_titulo"],$_POST["tick_descrip"],$_POST["prio_id"]);
            /* TODO: Obtener el ID del ultimo registro insertado */
            if (is_array($datos)==true and count($datos)>0){
                foreach ($datos as $row){
                    $output["tick_id"] = $row["tick_id"];

                    /* TODO: Validamos si vienen archivos desde la Vista */
                    if (empty($_FILES['files']['name'])){

                    }else{
                        /* TODO:Contar Cantidad de Archivos desde la Vista */
                        $countfiles = count($_FILES['files']['name']);
                        /* TODO: Generamos ruta segun el ID del ultimo registro insertado */
                        $ruta = "../public/document/".$output["tick_id"]."/";
                        $files_arr = array();

                        /* TODO: Preguntamos si la ruta existe, en caso no exista la creamos */
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        /* TODO:Recorremos los archivos, y insertamos tantos detalles como documentos vinieron desde la vista */
                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            /* TODO: Insertamos Documentos */
                            $documento->insert_documento( $output["tick_id"],$_FILES['files']['name'][$index]);

                            /* TODO: Movemos los archivos hacia la carpeta creada */
                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
            break;

        /* TODO: Actualizamos el ticket a cerrado y adicionamos una linea adicional */
        case "update":
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $ticket->update_ticket($decifrado);
            $ticket->insert_ticketdetalle_cerrar($decifrado,$_POST["usu_id"]);
            break;

        /* TODO: Reabrimos el ticket y adicionamos una linea adicional */
        case "reabrir":
            $ticket->reabrir_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_reabrir($_POST["tick_id"],$_POST["usu_id"]);
            break;

        /* TODO: Asignamos el ticket  */
        case "asignar":
            $ticket->update_ticket_asignacion($_POST["tick_id"],$_POST["usu_asig"]);
            break;

        /* TODO: Listado de tickets segun usuario,formato json para Datatable JS */
        case "listar_x_usu":
            $datos=$ticket->listar_ticket_x_usu($_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                $sub_array[] = $row["prio_nom"];

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Cerrado</span></a>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["fech_cierre"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-warning">Sin Asignar</span>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $cifrado = openssl_encrypt($row["tick_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                $sub_array[] = '<button type="button" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        /* TODO: Listado de tickets,formato json para Datatable JS */
        case "listar":
            $datos=$ticket->listar_ticket();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                $sub_array[] = $row["prio_nom"];

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Cerrado</span><a>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["fech_cierre"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        /* TODO: Listado de tickets,formato json para Datatable JS, filtro avanzado*/
        case "listar_filtro":
            $datos=$ticket->filtrar_ticket($_POST["tick_titulo"],$_POST["cat_id"],$_POST["prio_id"]);
            $data= Array();
            foreach($datos as $row){

                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                $sub_array[] = $row["prio_nom"];

                if ($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                }else{
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">Cerrado</span><a>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));

                if($row["fech_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_asig"]));
                }

                if($row["fech_cierre"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Cerrar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"].'</span>';
                    }
                }

                $cifrado = openssl_encrypt($row["tick_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                $sub_array[] = '<button type="button" data-ciphertext="'.$textoCifrado.'" id="'.$textoCifrado.'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;

        /* TODO: Formato HTML para mostrar detalle de ticket con comentarios */
        case "listardetalle":

            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            /* TODO: Listar todo el detalle segun tick_id */
            $datos=$ticket->listar_ticketdetalle_x_ticket($decifrado);
            ?>
                <?php
                    /* TODO: Repetir tantas veces se obtenga de la varible datos$ */
                    foreach($datos as $row){
                        ?>
                            <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                    <!-- TODO: Formato de fecha creacion -->
                                    <?php echo date("d/m/Y", strtotime($row["fech_crea"]));?>
                                </div>
                                <header class="activity-line-item-header">
                                    <div class="activity-line-item-user">
                                        <div class="activity-line-item-user-photo">
                                            <a href="#">
                                                <img src="../../public/<?php echo $row['rol_id'] ?>.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"><?php echo $row['usu_nom'].' '.$row['usu_ape'];?></div>
                                        <div class="activity-line-item-user-status">
                                            <!-- TODO: Mostrar perfil del usuario segun rol -->
                                            <?php
                                                if ($row['rol_id']==1){
                                                    echo 'Usuario';
                                                }else{
                                                    echo 'Soporte';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                        <div class="time"><?php echo date("H:i:s", strtotime($row["fech_crea"]));?></div>
                                        <div class="cont">
                                            <div class="cont-in">
                                                <p>
                                                    <?php echo $row["tickd_descrip"];?>
                                                </p>

                                                <br>

                                                <!-- TODO: Mostrar documentos adjunto en el detalle de ticket -->
                                                <?php
                                                    $datos_det=$documento->get_documento_detalle_x_ticketd($row["tickd_id"]);
                                                    if(is_array($datos_det)==true and count($datos_det)>0){
                                                        ?>
                                                            <p><strong>Documentos Adicionales</strong></p>

                                                            <p>
                                                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 60%;"> Nombre</th>
                                                                        <th style="width: 40%;"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                        <!-- TODO: Mostrar tantos documentos tenga el ticket detalle -->
                                                                        <?php
                                                                            foreach ($datos_det as $row_det){ 
                                                                        ?>
                                                                            <tr>
                                                                                <td><?php echo $row_det["det_nom"]; ?></td>
                                                                                <td>
                                                                                    <a href="../../public/document_detalle/<?php echo $row_det["tickd_id"]; ?>/<?php echo $row_det["det_nom"]; ?>" target="_blank" class="btn btn-inline btn-primary btn-sm">Ver</a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                </tbody>
                                                            </table>

                                                            </p>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </article>
                        <?php
                    }
                ?>
            <?php
            break;

        /* TODO: Mostrar informacion de ticket en formato JSON para la vista */
        case "mostrar";
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $datos=$ticket->listar_ticket_x_id($decifrado);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];

                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["tick_descrip"] = $row["tick_descrip"];

                    if ($row["tick_estado"]=="Abierto"){
                        $output["tick_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $output["tick_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["tick_estado_texto"] = $row["tick_estado"];

                    $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    $output["fech_cierre"] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["cat_nom"] = $row["cat_nom"];
                    $output["cats_nom"] = $row["cats_nom"];
                    $output["tick_estre"] = $row["tick_estre"];
                    $output["tick_coment"] = $row["tick_coment"];
                    $output["prio_nom"] = $row["prio_nom"];
                }
                echo json_encode($output);
            }
            break;

        case "mostrar_noencry";
            $datos=$ticket->listar_ticket_x_id($_POST["tick_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];

                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["tick_descrip"] = $row["tick_descrip"];

                    if ($row["tick_estado"]=="Abierto"){
                        $output["tick_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $output["tick_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["tick_estado_texto"] = $row["tick_estado"];

                    $output["fech_crea"] = date("d/m/Y H:i:s", strtotime($row["fech_crea"]));
                    $output["fech_cierre"] = date("d/m/Y H:i:s", strtotime($row["fech_cierre"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["cat_nom"] = $row["cat_nom"];
                    $output["cats_nom"] = $row["cats_nom"];
                    $output["tick_estre"] = $row["tick_estre"];
                    $output["tick_coment"] = $row["tick_coment"];
                    $output["prio_nom"] = $row["prio_nom"];
                }
                echo json_encode($output);
            }
            break;

        case "insertdetalle":
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
            
            $datos=$ticket->insert_ticketdetalle($decifrado,$_POST["usu_id"],$_POST["tickd_descrip"]);
            if (is_array($datos)==true and count($datos)>0){
                foreach ($datos as $row){
                    /* TODO: Obtener tikd_id de $datos */
                    $output["tickd_id"] = $row["tickd_id"];
                    /* TODO: Consultamos si vienen archivos desde la vista */
                    if (empty($_FILES['files']['name'])){

                    }else{
                        /* TODO:Contar registros */
                        $countfiles = count($_FILES['files']['name']);
                        /* TODO:Ruta de los documentos */
                        $ruta = "../public/document_detalle/".$output["tickd_id"]."/";
                        /* TODO: Array de archivos */
                        $files_arr = array();
                        /* TODO: Consultar si la ruta existe en caso no exista la creamos */
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        /* TODO:recorrer todos los registros */
                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            $documento->insert_documento_detalle($output["tickd_id"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
            break;

        /* TODO: Total de ticket para vista de soporte */
        case "total";
            $datos=$ticket->get_ticket_total();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Total de ticket Abierto para vista de soporte */
        case "totalabierto";
            $datos=$ticket->get_ticket_totalabierto();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Total de ticket Cerrados para vista de soporte */
        case "totalcerrado";
            $datos=$ticket->get_ticket_totalcerrado();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }
            break;

        /* TODO: Formato Json para grafico de soporte */
        case "grafico";
            $datos=$ticket->get_ticket_grafico();  
            echo json_encode($datos);
            break;

        /* TODO: Insertar valor de encuesta,estrellas y comentarios */
        case "encuesta":
            $ticket->insert_encuesta($_POST["tick_id"],$_POST["tick_estre"],$_POST["tick_coment"]);
            break;

        case "all_calendar":
            $datos=$ticket->get_calendar_all();
            echo json_encode($datos);
            break;

        case "usu_calendar":
            $datos=$ticket->get_calendar_usu($_POST["usu_id"]);
            echo json_encode($datos);
            break;

    }
?>