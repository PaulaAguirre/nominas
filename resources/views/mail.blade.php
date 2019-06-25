<table width="100%">
    <tr>
        <td>
            <img src="{{ $message->embed(public_path().'/bds_boc_logo.png') }}">
        </td>
        <td>
            <table>
                <tr>
                    <td colspan="2">
                        <font color="#87bdd8" size="6">
                            BDS-BOC Reporte Diario
                        </font>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <font color="#87bdd8" size="6">
                            Métricas Por Cantidad
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>
                        <font color="#667292" size="4">
                            Fecha Actualización:
                        </font>

                    </td>
                    <td>
                        <font color="#667292" size="4">
                            <strong>
                                {{ date("d/m/Y") }}
                            </strong>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>
                        <font color="#667292" size="4">
                            Business Unit / Canal:
                        </font>
                    </td>
                    <td>
                        <font color="#667292" size="4">
                            <strong>
                                Mobile / Tiendas
                            </strong>
                        </font>
                    </td>
                </tr>

            </table>
        </td>
        <td>
            <img height="130" width="130" src="{{ $message->embed(public_path().'/imagen.png') }}">
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <hr />
            <font color="#87bdd8" size="5">
                <a href="http://bds/boc/mpp/general/e8aSC2f92wyvExNQ/BDS-BOC Reporte Diario - MPQ  Tiendas GRAL-Junio-19.xlsm">Descargar Reporte junio</a>
            </font>
            <hr />
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <font color="red">
                <h2>Observaciones:</h2>

                <ul>
                    <li>Este envío corresponde al primer seguimiento del mes de Junio-19. Únicamente contiene la vista por Asesor y ventas detalles. </li>

                    <li>No están contempladas aún las configuraciones de:</li>
                    <ul>
                        <li> Down Grade de imparables a imparables</li>
                        <li>Revenue de migra usim , gross pre y porta pre. </li>
                        <li>% de Revenue para Gross Pos , debe sumar solo 50% del valor del plan.</li>
                        <li>Escenarios y Escalas referente a Calidad y CHURN y FMC</li>
                        <li>Proyección y Métrica Final </li>
                        <li>Vista de Especialistas de Retención </li>
                    </ul>
                    <li>En los siguientes reportes ya estarán incluidos.  </li>
                </ul>
            </font>
        </td>
    </tr>
</table>




