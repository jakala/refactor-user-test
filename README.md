# Prueba técnica empresa.com    
 El equipo de Empresa.com tiene un problema con el microservico de usuarios y necesita tu ayuda para solucionarlo.    
    
El número de usuarios crece muy rápido y el equipo de producto no hace nada más que pedir nuevas features.   
El problema es que el código es muy legacy y no se presta ni a escalar ni es capaz de aguantar el tráfico.    
    
Tú prueba consiste en hacer que este microservicio sea más escalable y más mantenible.    
    
**Índice**  
1. [Requisitos de la prueba](#requisitos-de-la-prueba)
2. [Instalación](#instalación)
3. [Documentación](#documentación)
4. [Testing](#testing)

<h2 id="requisitos-de-la-prueba">Requisitos de la prueba</h2>

**respeta la interfaz de la API** 

Puedes tirar por dos caminos 100% válidos:    
1. Tirarlo todo y hacerlo como más te guste    
2. Refactorizarlo y dejarlo a tu gusto    

<h2 id="instalacion">Instalación</h2>

1. Clónate el repositorio    
2. Ejecuta `make build` 

Después de ejecutar el último comando se te han levantado 2 contenedores:    
1. Un apache con php 7.4 que está corriendo en el _puerto 8000_ y el xdebug en el _puerto 9013_ (php-technical-test)    
2. Un mariadb 10.5 que está corriendo en el _puerto 3366 usuario: root password: admin_ (mariadb-technical-test)     
    
<h2 id="documentacion">Documentación</h2>

En el directorio doc tienes un fichero swagger.yaml con las especificación de la API https://editor.swagger.io/    
    
Tambien tienes un api.http con la llamada a los dos endpoints si trabajas con un editor de jetbrains.    
    
Si trabajas con otro editor tienes un .sh con los curl.    
    
Con todo y con eso aquí tienes un ejemplo de los 2 endpoints de la prueba:    
```
curl -d '{"name":"Pedro", "phone":"607112235"}' \  
 -H "Content-Type: application/json" \ -X PUT http://localhost:8000/users/9cec71c0-3906-45cc-b8a0-1bd50621c4d5 
``` 
``` 
curl http://localhost:8000/users/9cec71c0-3906-45cc-b8a0-1bd50621c4d5  
  # return {"id":"9cec71c0-3906-45cc-b8a0-1bd50621c4d5","name":"Pedro","phone":"607112235"} 
```    

<h2 id="testing">Testing</h2>

Para facilitar el testing hemos añadido unos test de behat que podrás usar siempre que necesites para verificar si tu   
la API esta funcionando correctamente. Para ejecutarlos:
``` 
make behat 
```

También hemos dejado los tests de php-unit ya configurados y con un test de prueba en `test/src/Unit`.
   
Para ejecutarlos simplemente debes ejecutar:
```
make unit
```
