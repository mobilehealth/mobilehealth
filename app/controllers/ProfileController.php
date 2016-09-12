<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;


class ProfileController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /profile
	 *
	 * @return Response
	 */
	public function getIndex()
	{

		$user   = Confide::user();

		$pid    = $user->person_id;

		$person = $user->person;
		
		$tempodoenca = $user->tempodoenca;
		
		$afinidade = $user->afinidade;
		
		//dd($user);

		$title = 'Profile';
		return View::make('profile',compact('title','pid','person', 'tempodoenca', 'afinidade'));
		
	}

	public function getPersonalpage() {
		
			$pid = Confide::user()->person->id;
		
		//************************************ Recupera os amigos recomendados ******************************************
		//******************************************************************************************************************
			
			$possiblefriends = DB::connection("public")->select(DB::raw("select  p.id, p.name_first, p.name_last, u.photo from app.users as u inner join public.person as p on u.person_id in (select possiblefriend from app.possiblefriends where friendTo = ".$pid.") and u.person_id = p.id"));

			//dd($possiblefriends);
		//************************************ [FIM] Recupera os amigos recomendados ******************************************
		//******************************************************************************************************************
		
		
		//********************************* REUPERA os posts do usuario **************************************************
		//*****************************************************************************************************************
		
		$posts = DB::connection("public")->select(DB::raw("select * from app.posts where person = ".$pid . " order by create_at desc"));
		
		//********************************* [FIM] REUPERA os posts do usuario **************************************************
		//*****************************************************************************************************************
		
		//************************************ Recupera os post do FEED **********************************************************
		//******************************************************************************************************************
		
			$contents = DB::connection("public")->select(DB::raw("select c.* from public.relatepersoncontent as rpc inner join public.content as c on (rpc.id_content = c.id) and (".$pid." = rpc.id_person) and (rpc.liked = 2)"));	
			//$contents = DB::connection("public")->select(DB::raw("select p.id as id_person, p.name_first, u.photo, c.*  from public.person as p inner join app.users as u on p.id = u.person_id and p.id in (select rpc.person_from from public.relatepersoncontent as rpc where liked = 2 and id_person = ".$pid.") or p.id inner join public.content as c on c.id in (select rpc.id_content from public.relatepersoncontent as rpc where liked = 2 and person_from = p.id)"));	
		
		//************************************ [FIM] Recupera os post do FEED **********************************************************
		//******************************************************************************************************************

			$title = "Página Pessoal";			
			return View::make('personalpage',compact('possiblefriends', 'title', 'contents', 'posts', 'pid'));
		
	}
	
	
	
	
	public function getPersonalpagefriend($pid) {
		
		$person = DB::connection("public")->select(DB::raw("select * from app.users as u inner join public.person as p on u.person_id = p.id and p.id = ".$pid));
		
		//********************************* REUPERA os posts do usuario **************************************************
		//*****************************************************************************************************************
		
		$posts = DB::connection("public")->select(DB::raw("select * from app.posts where person = ".$pid . " order by create_at desc"));
		
		//********************************* [FIM] REUPERA os posts do usuario **************************************************
		//*****************************************************************************************************************
		
		//************************************ Recupera os post do FEED **********************************************************
		//******************************************************************************************************************
		
		$contents = DB::connection("public")->select(DB::raw("select c.* from public.relatepersoncontent as rpc inner join public.content as c on (rpc.id_content = c.id) and (".$pid." = rpc.id_person) and (rpc.liked = 2)"));	
			//$contents = DB::connection("public")->select(DB::raw("select p.id as id_person, p.name_first, u.photo, c.*  from public.person as p inner join app.users as u on p.id = u.person_id and p.id in (select rpc.person_from from public.relatepersoncontent as rpc where liked = 2 and id_person = ".$pid.") or p.id inner join public.content as c on c.id in (select rpc.id_content from public.relatepersoncontent as rpc where liked = 2 and person_from = p.id)"));	
		
		//************************************ [FIM] Recupera os post do FEED **********************************************************
		//******************************************************************************************************************

		$person = $person[0];
		$title = "Página Pessoal: ". $person->name_first;	
			
			
		
		
		return View::make('personalpagefriend',compact('person', 'title', 'contents', 'posts'));
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * Display a listing of the resource.
	 * GET /profile
	 *
	 * @return Response
	 
	 
	 
	 
	 
	 
	 public function postIndex()
	{
		$input = Input::all();

		$pid = $input["pid"];

		$p                  = Person::find($pid);
		$p->name_last        = $input["lname"];
		$p->name_first       = $input["fname"];
		$p->date_birth       = $input["birthdate"];
		$p->gender           = $input["gender"];

		if (isset($input["disease"]))
			$p->disease         = $input["disease"];

		$p->save();

		return Redirect::intended("/profile");
	}
	 */
	 
	public function postIndex()
	{
		$input = Input::all();

		$pid = Confide::user()->person->id;

		$p                  = Person::find($pid);
		$p->date_birth       = $input["birthdate"];
		
		if(isset($input["lname"])){
			$p->name_last        = $input["lname"];

		} else {
			$p->name_last        = null;
		}

		if(isset($input["fname"])){
			$p->name_first       = $input["fname"];
		} else {
			$p->name_first        = null;
		}

		if(isset($input["gender"])){
			$p->gender           = $input["gender"];
		} else {
			$p->gender        = null;
		}

		
		if (isset($input["disease"])){
			$p->disease         = $input["disease"];
		} else {
			$p->disease         = null;
			
		}
		
		
		
		
		if(Input::hasFile('imagem')){
			
			$imagem = Input::file('imagem');	
			$extensao = $imagem->getClientMimeType();
			
			if($extensao != 'image/jpeg' && $extensao != 'image/png'){
				
				echo "Estensão errada";
				
			} else {
				
				//File::move($imagem, public_path()."imgs/".$pid."_1.");
				echo $imagem->getFilename();
				Input::file('imagem')->move(public_path()."/imgs/", $imagem);
				
				DB::connection("app")->select(DB::raw("update users set photo='".$imagem->getFilename()."' where person_id=".$pid));
			}
			
		}
		
		
		
		
		
		$p->save();

		return Redirect::intended("/profile");
	}


}