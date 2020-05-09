const config = {
    API_URL: '//localhost/grados-unsa/backend',    
    FILE_URL: '//localhost/grados-unsa/backend/utils/show_file.php',    
    //para asignacion de colores a los movimientos o rutas de salida de los procedimientos
    color_acciones: { enviar:"success", derivar:"success", 
                      devolver:"danger", denegar:"danger",
                      observar:"warning", rechazar:"danger", 
                      aceptar:"success", aprobar:"success", 
                      anular: "danger", cambiar: "warning"
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