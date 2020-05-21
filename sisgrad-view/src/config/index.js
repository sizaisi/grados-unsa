const config = {
    API_URL: '//localhost/grados-unsa/sisgrad-ws',    
    FILE_URL: '//localhost/grados-unsa/sisgrad-ws/utils/show_file.php',    
    //para asignacion de colores a los movimientos o rutas de salida de los procedimientos
    color_acciones: { enviar:"success", derivar:"success", 
                      devolver:"danger", denegar:"danger",
                      observar:"warning", rechazar:"danger", 
                      aceptar:"success", aprobar:"success", 
                      anular: "danger", cambiar: "warning"
                    },
    //para asignacion de colores a los estados del listado de expedientes
    color_estados: { enviado:"success", derivado:"success", 
                      devuelto:"danger", denegado:"danger",
                      observado:"warning", rechazado:"danger", 
                      aceptado:"success", aprobado:"success", 
                      anulado: "danger", cambiado: "warning"
                    },
    //para movimientos de ingreso a un procedimiento
    estados: { enviar:"enviado", derivar:"derivado", 
                devolver:"devuelto", denegar:"denegado",
                observar:"observado", rechazar:"rechazado", 
                aceptar:"aceptado", aprobar:"aprobado", 
                anular: "anulado", cambiar: "cambiado"
              },
}

export default config