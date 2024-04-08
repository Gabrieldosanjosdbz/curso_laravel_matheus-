<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        
        $search= request('search');

        if($search){        //se search for iniciado
            $events = Event::where([
                ['title', 'like', '%'. $search .'%']
            ])->get();

        } else{
            $events = Event::all(); 
        }
        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function create(){
        return view('events.create');
    }

    public function store(Request $request){    //o Request ele traz todos os dados daquela requisição do formulario para cá

        $event = new Event; //estou instanciando o Model (ORM para registros do laravel para salvar os dados na tabela)
        
        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        
        $event->items = $request->items;

        // image upload
        if($request->hasFile('image') && $request->file('image')->isValid()){   //lógica para falar caso tenha uma imagem
            $requestImage = $request->image;

            $extension = $requestImage->extension();    //a extensão dele

            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' .$extension;

            $request->image->move(public_path('img/events'), $imageName);   //vou salvar a imagem em um path dentro de img

            $event->image = $imageName; // este é dado que salva no banco de fato
        }

        // acessando a propriedade id do usuario logado e salvando no banco

        $user = auth()->user();
        $event->user_id = $user->id;    

        $event->save();     

        return redirect('/')->with('msg', 'Evento criado com sucesso!');   //Estou redirecionando para home depois que as ações a cima forem feitas

    } 

    public function show($id){

        $event = Event::findOrFail($id);    //serve para selecionar apenas um registro do seu banco pelo parametro

        $user = auth()->user();
        $hasUserJoined = false;

        if($user) {
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent){
                if($userEvent['id'] == $id){
                    $hasUserJoined = true;
                }
            }
        }

        $EventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'EventOwner' => $EventOwner, 'hasUserJoined' => $hasUserJoined ]);   //transformei de objeto para array  

    }

    // para pegar os dados do usuario que esta logado e levando a uma page com todos os seus registros  
    public function dashboard(){

        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventasparticipant' => $eventsAsParticipant]);
    }   

    public function destroy($id){

        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluido com sucesso!');
    }

    public function edit($id){

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if($user->id != $event->user->id){
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request){

        $data = $request->all();

        // image upload para o update
        if($request->hasFile('image') && $request->file('image')->isValid()){   //lógica para falar caso tenha uma imagem

            $requestImage = $request->image;

            $extension = $requestImage->extension();    //a extensão dele

            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' .$extension;

            $request->image->move(public_path('img/events'), $imageName);   //vou salvar a imagem em um path dentro de img

            $data['image'] = $imageName; // este é dado que salva no banco de fato
        }
        

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado  com sucesso!');
    }

    public function joinEvent($id) {

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id); //é usado para criar uma nova entrada em uma tabela pivot que associa dois modelos em uma relação many-to-many

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento');

    }

    public function leaveEvent($id){
        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id); //é faz o contrario do attach

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento: ' . $event->title );
    }
}
