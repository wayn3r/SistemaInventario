# SistemaInventario
Para el correcto funcionamiento del proyecto se debe configurar el archivo php.ini del servidor.
En la seccion [Date] agregar la siguiente linea de codigo (asegurarse que este en todas la secciones con este nombre):

  date.timezone = America/Santo_Domingo

en la seccion [mail function] agregar la siguiente linea de codigo:

  sendmail_path ="{ruta del servidor}\lib\sendmail\sendmail.exe -t"

Listo. Con esta configuracion deberia obtener el funcionamiento esperado.
