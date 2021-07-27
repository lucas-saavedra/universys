 /*   $.post(
            '/universys/jornada/backend/horarios.php', {
            },
            function (response) {
                let jornadas = JSON.parse(response);
               
               let template = " "
                if (jornadas == '') {
                    template = "Nada por aquí..."
                }else{
                   

                jornadas.forEach(jornada => {
                    if (tipo_agente == 'docente') {

                        template += ` 
                                <tr jornada_id=${jornada.jornada_id} jornada_agente_id=${jornada.jornada_agente_id}> 
                                <td> ${jornada.jornada_agente_id}  </td>
                                <td>   ${jornada.docente} </td>
                                <td>   ${jornada.catedra} </td>
                                <td>   ${jornada.fecha_inicio} </td>
                                <td>   ${jornada.fecha_fin} </td>
                                <td>   ${jornada.tipo_jornada} </td>
                                <td>   ${jornada.descripcion} </td>
                                <tr>


            <td colspan="4">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">Dia</th>
                            <th scope="col">Hora Inicio</th>
                            <th scope="col">Hora Fin</th>
                            <th scope="col">Descripcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach (get_jornadas_horarios($conexion, ${jornada.jornada_id}) as $horarios) : ?>
                            <tr>
                            <th scope="row">  <?= $horarios['det_jorn_id'] ?> </th>
                           
                            <td>  <?= $horarios['nombre'] ?> </td>
                         <!--    <td>  <?= $horarios['jornada_id'] ?> </td> -->
                            <td>  <?= $horarios['hora_inicio'] ?> </td>
                            <td>  <?= $horarios['hora_fin'] ?> </td>
                            <td>  <?= $horarios['descripcion'] ?> </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
                                
                                `;
                        if (agente_id == undefined) {
                            template += `   
                                <td> <button class="jornada-item btn btn-info"><i class="fas fa-pen"></i></button>
                                <button class="jornada_borrar btn btn-danger"><i class="fas fa-trash"></i></button></td>
                                 
                            </tr>`;

                        } else {
                            template += `<td> <button type="button" class=" jornada-item  btn btn-success" data-toggle="collapse" data-target=".multi-collapse"  aria-controls="toggle_jornadas agente_tabla search_agente" role="button" type="button" "><i class="fas fa-check-circle"></i></button></td>
                                </tr>`;

                        }

                    } else {
                        template += ` 
                        <tr jornada_id='${jornada.jornada_id}' jornada_agente_id='${jornada.jornada_agente_id}'>  
                        <td>   ${jornada.jornada_agente_id}  </td>   
                        <td>   ${jornada.no_docente}  </td>
                        <td>   ${jornada.area}  </td>  
                        <td>   ${jornada.fecha_inicio}  </td>   
                        <td>   ${jornada.fecha_fin}  </td>   
                        <td>   ${jornada.tipo_jornada}  </td>   
                        <td>   ${jornada.descripcion}  </td>   
                    
                        <td> <button class=" jornada-item btn btn-info"><i class="fas fa-pen"></i></button>
                        <button class=" jornada_borrar btn btn-danger"><i class="fas fa-trash"></i></button></td>
                        
                            
                        </tr>
                
                        `;

                    }


                })
            }*/