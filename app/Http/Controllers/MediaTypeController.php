<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MediaType;

class MediaTypeController extends Controller
{
public function showmass(){
    return view("media-types.insert-mass");
}
public function storemass(Request $r){

 //Arreglo de mediaTypes repetidos en bd
 $repetidos=[];   

//Reglas de validacion
    $reglas = [
    'media-types' => 'required|mimes:csv,txt'
    ];

//Crear validador
    $validador = Validator::make($r->all() , $reglas);

//Validar
    if($validador->fails()){
//return $validador->errors()->first('media-types');
    //Enviar mensaje de error de validacion 
    return redirect('media-types/insert')->withErrors($validador);
    }else{
//Trasladar el archivo cargado a Storage
    $r->file('media-types')->storeAs('media-types' , $r->file('media-types')->getClientOriginalName());
// Ruta del archivo
   $ruta = base_path().'\storage\app\media-types\\'.$r->file('media-types')->getClientOriginalName();
//Abrir el archivo almacenado para lectura:   
   if(($puntero = fopen($ruta, 'r')) !==false){
//validar a contar las veces que se insertan
       $contadora = 0;
//Recorro cada linea del cvs: fgetcsv, utilizando el puntero que representa el archivo
    while(($linea = fgetcsv($puntero)) !==false ){
        var_dump($linea);
//Buscar el mediaType  en $linea [0];
     $conteo = MediaType::where('Name' , '=' , $linea[0])->get()->count();
     //Si no hay registros en mediaTypes que se llamen igual
     if($conteo == 0){
        //Crear objeto MediaType
        $m = new MediaType();
        //asigno el nombre del media-type
        $m->Name = $linea[0];
        //grabo en sqlite el nuevo media-type
        $m->save();
        //Aumentar en 1 el contador
        $contadora ++;
     }else{ //Hayy registros del mediaTypes
        //Agregar una casilla al arreglo
        $repetidos[] = $linea[0];

     }
    }

//TODO: poner mensaje de grabacion de carga masiva en la vista en la vista
  //Si hubieron repetidos
  if(count($repetidos)== 0){
    return redirect('media-types/insert')
  ->with('exito', "Carga masiva de medios realizada, Registros Ingresados: $contadora");

  }else{
    return redirect('media-types/insert')
    ->with('exito', "Carga masiva con las siguientes excepciones:" )
    ->with("repetidos" , $repetidos);
  
  }

$linea = fgetcsv($puntero);
    var_dump($linea);    
    $linea = fgetcsv($puntero);
    var_dump($linea);    
    $linea = fgetcsv($puntero);
    var_dump($linea);    
    $linea = fgetcsv($puntero);
    var_dump($linea);     $linea = fgetcsv($puntero);
    var_dump($linea);    
    $linea = fgetcsv($puntero);
    var_dump($linea);     $linea = fgetcsv($puntero);
    var_dump($linea);    
    $linea = fgetcsv($puntero);
    var_dump($linea);    
}   
    }



//Verificar el archivo cargado 
    echo "<pre>";
    var_dump( $r->file("media-types"));
    echo "</pre>";

//Trasladar el archivo al storage del proyecto
    $r->file("media-types")->storeAs('media-types' ,
    $r->file("media-types")->getClientOriginalName()
    );
       

}
}