<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pacientes;
use App\Models\Atendimentos;
use Illuminate\Support\Facades\DB;
use \LaravelLegends\PtBrValidator\Rules\FormatoCpf;

class Eventos extends Controller
{
    public function index(){
        $pacientes = Pacientes::all();
        return redirect('/painel');
    }
    public function pacientes(){
        $pacientes = Pacientes::all();
        return view('pacientes',
            [
                "pacientes" => $pacientes
            ]
        );
    }
    public function renderPatients(){
        $pacientes = Pacientes::all();
        return $pacientes;
    }
    public function salvar(Request $r){
        $event = new Pacientes;
        $cpf = $r->cpf;
        $event->nome = $r->nome;
        $event->cpf = $cpf;
        $event->wpp = $r->wpp;
        $event->nasc = $r->nasc;
        $event->estado = 3;
        if($r->hasFile("foto") && $r->file("foto")->isValid()){
            $permitidas = ["jpg","png","jfif"];
            $foto = $r->foto;
            $extensao = $foto->extension();
            if(in_array($extensao,$permitidas)){
                $nomeFoto = uniqid().".$extensao";
                $foto->move(public_path("img/pacientes"),$nomeFoto);
                $event->foto = $nomeFoto;
            }else{
                return redirect('/painel/pacientes')->with('alert2','Formato de Imagem Não Permitido!');
            }
        }
        $event->save();
        $select = $event->select('id','nome','nasc','cpf','wpp','foto','estado')->where('cpf',$cpf)->get();
        return response()->json($select);
    }
    public function editar(Request $r){
        $event = new Pacientes;
        $cpf = $r->cpf;
        $wpp = $r->wpp;
        $id = $r->id;
        $event->nome = $r->nome;
        $event->cpf = $cpf;
        $event->wpp = $wpp;
        $event->nasc = $r->nasc;
        if($r->hasFile("foto") && $r->file("foto")->isValid()){
            $permitidas = ["jpg","jpeg","png","jfif"];
            $foto = $r->foto;
            $extensao = $foto->extension();
            if(in_array($extensao,$permitidas)){
                $nomeFoto = uniqid().".$extensao";
                $foto->move(public_path("img/pacientes"),$nomeFoto);
            }else{
                return redirect('/painel/pacientes')->with('alert2','Formato de Imagem Não Permitido!');
            }
        }else{$nomeFoto="none.jpg";}
        $select = $event->where('id',$id)->update([
            "nome"=>$r->nome,
            "cpf"=>$cpf,
            "wpp"=>$wpp,
            "nasc"=>$r->nasc,
            "foto"=>$nomeFoto
        ]);
        return response()->json($select);
    }
    public function atender($id){
        $event = Pacientes::findOrFail($id);
        return view('atender',["event" => $event]);
    }
    public function atenda($id){
        $event = Pacientes::findOrFail($id);
        return response()->json($event);
    }
    public function concluir(Request $r){
        $event = new Atendimentos;
        $event->sintomas = $r->sintomas;
        $event->lista = "$r->lista";
        $event->resultado = $r->resultado;
        $event->idPaciente = $r->idPaciente;
        $paci = new Pacientes;
        if($event->where('idPaciente', $event->idPaciente)->count() == 0) {
            $event->save();
        }else{
            $event->where('idPaciente',$event->idPaciente)->update($r->all());
        }
        $paci->where('id',$event->idPaciente)->update(['estado'=>$event->resultado]);
        return response()->json(['Paciente Atendido']);
    }
    public function remover($id){
        $event = new Pacientes;
        $event->where('id',$id)->firstorfail()->delete();
        return redirect('/painel/pacientes')->with('alert4','Paciente Removido!');
    }
}