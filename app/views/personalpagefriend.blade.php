@extends("layout.main-mobile")

@section("content")

	<div data-role="page" data-title="Profile">

	    <div role="main" class="ui-content jqm-content jqm-fullwidth">
			
			<div id="cabecalho"> 
			
				<div class="box">
					
						<div id="profile_picture">	
							{{ HTML::image('imgs/'.$person->photo, '') }}							
						</div>
					
				</div>
			
			
			</div>
			
			
			<h3>Posts Compartilhados por {{$person->name_first}}</h3>
			<div class="conteudo" id="Feed" style="">
		

			@if(isset($posts))
				@if(!empty($posts))
					@foreach($posts as $p)
						<div class="post" >
							<div class="headPost">
								<div class="imgPost" >
									{{ HTML::image(Session::get('profilePicture'), '') }}
								</div>
							</div>
							
							<div class="contentPost"> 
								<div class="namePost">
								{{Session::get('fullName');}}
								</div>
								
								<div class="textPost">

										<p>{{$p->texto}}</p>
										@if(strcmp($p->imagem, ' ') != 0)
											{{ HTML::image('imgs/'.$p->imagem, '') }}
										@endif


								</div>
								
								<div class="divBottom">
									<ul class="bottom">
										<a id="alikep" onclick="like('{{url('app/likep?id='.$p->id.'&from='.Confide::user()->person->id)}}');mudaFundoLikep('{{$p->id}}');" href="#"><li id="likep{{$p->id}}" class="bottomli"><img src="{{url('/imgs/ok.png')}}" /></li></a>
										<a id="aulikep" onclick="unlike('{{url('app/unlikep?id='.$p->id.'&from='.Confide::user()->person->id)}}');mudaFundoUnLikep('{{$p->id}}');" href="#"><li id="unlikep{{$p->id}}" class="bottomli" ><img src="{{url('/imgs/naoOK.png')}}" /></li></a>
										
									</ul>
								</div>
							</div>
						</div>
				@endforeach
			@else
				{{$person->name_first}} não publicou nada ainda<br>
			@endif
		@else
			
		@endif


			
			@if(isset($contents))
				@if(!empty($contents))
					@foreach($contents as $con)
						<div class="post" >
							<div class="headPost">
								<div class="imgPost" >
									{{ HTML::image(Session::get('profilePicture'), '') }}
								</div>
							</div>
							
							<div class="contentPost"> 
								<div class="namePost">
								{{Session::get('fullName');}}
								</div>
								
								<div class="textPost">
									@if(!empty($con->thumburl))
										<div class="video">
											<span class="thumbnail" >
												<a href="{{url("/app/video/" . $con->vid)}}" target="new">
												<img src="{{$con->thumburl}}" align="left" />
												<p class="title">{{Str::limit($con->title,40)}}</p>
												<p class="desc">{{ Str::limit($con->description, 120) }}</p>
												</a>
											</span>
										</div>
								
									@else
								
										<p>{{$con->title}}</p>
										<img src="{{$con->thumburl}}" align="left" />
										<p>
											<a href="app/url?a={{$con->url_online}}" target="new">{{$con->description}}</a>
												
										</p>
									
									@endif
								</div>
								
								<div class="divBottom">
									<ul class="bottom">
										<a id="alike" onclick="like('{{url('app/likec?id='.$con->id.'&from='.Confide::user()->person->id)}}');mudaFundoLike('{{$con->id}}');" href="#"><li id="like{{$con->id}}" class="bottomli"><img src="{{url('/imgs/ok.png')}}" /></li></a>
										<a id="aulike" onclick="unlike('{{url('app/unlikec?id='.$con->id.'&from='.Confide::user()->person->id)}}');mudaFundoUnLike('{{$con->id}}');" href="#"><li id="unlike{{$con->id}}" class="bottomli" ><img src="{{url('/imgs/naoOK.png')}}" /></li></a>
										
									</ul>
								</div>
							</div>
						</div>
				@endforeach
			@else
				{{$person->name_first}} não compoartilhou nada ainda
			@endif
		@else
			
		@endif
		
		
		
		
		
		
		
		
		
				
				<br style="clear:both" /> 
		</div>
			
			
			

		</div><!-- /content -->


	</div><!-- /page -->

@stop
	
	
	
	
	
@section("script")


function like(link){

	
	$.ajax({
				url: link,
				type: "GET",
				data: { sim: link},
				dataType: "html",
				success: function(sucesso){
					
					$('#retornodoresultado').html(sucesso);
					
				},
				beforeSend: function () {
					$('#carregando').css({display: "block"});
				},
				complete: function () {
					$('#carregando').css({display: "none"});
				},
				error: function(){

					$('#retornodoresultado').html('Desculpe pelo transtorno, houve um erro, tente novamente.');
				}
		});
		return false;
			

}



function unlike(link){
	
	$.ajax({
				url: link,
				type: "GET",
				data: { sim: link},
				dataType: "html",
				success: function(sucesso){
					
					$('#retornodoresultado').html(sucesso);
					
				},
				beforeSend: function () {
					$('#carregando').css({display: "block"});
				},
				complete: function () {
					$('#carregando').css({display: "none"});
				},
				error: function(){
					$('#retornodoresultado').html('Desculpe pelo transtorno, houve um erro, tente novamente.');
				}
		});
		return false;
			

}

function comp(link){
	
	$.ajax({
				url: link,
				type: "GET",
				data: { sim: link},
				dataType: "html",
				success: function(sucesso){
					
					alert("Você compartilhou esse conteúdo");
					
				},
				beforeSend: function () {
					$('#carregando').css({display: "block"});
				},
				complete: function () {
					$('#carregando').css({display: "none"});
				},
				error: function(){
					$('#retornodoresultado').html('Desculpe pelo transtorno, houve um erro, tente novamente.');
				}
		});
		return false;
			

}

function mudaFundoLike(div){
	
	$("#like"+div).css('border', 'solid 2px blue');
	$("#unlike"+div).css('border', 'solid 1px gray');
	
}


function mudaFundoUnLike(div){
	
	$("#unlike"+div).css('border', 'solid 2px blue');
	$("#like"+div).css('border', 'solid 1px gray');
	
}

function mudaFundoComp(div){
	
	$("#comp"+div).css('border', 'solid 2px blue');

	
}	


    $('#save').click(function(){
        $('#form').submit();
});	
	
	
	
	
	

@stop


@section("style")

#like {
        background: #7B7;
}

#bootom {
        background: #9D9;
}

#bootom:hover {
        background: #CFC;
}


.cabecalho{
	border-top: solid 1px green;
	padding-top: 10px;
	color: black;
	clear:both;
	
}

.box{
	
	width: auto;
	padding: 10px;
	height: auto;
	overflow: auto;
	padding-left: 40%;
	
	

	
	
	
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#00e1ff+0,ffffff+100&0.9+36,0.69+66 */
background: -moz-linear-gradient(top,  rgba(0,225,255,0.9) 0%, rgba(92,236,255,0.9) 36%, rgba(168,245,255,0.69) 66%, rgba(255,255,255,0.69) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  rgba(0,225,255,0.9) 0%,rgba(92,236,255,0.9) 36%,rgba(168,245,255,0.69) 66%,rgba(255,255,255,0.69) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  rgba(0,225,255,0.9) 0%,rgba(92,236,255,0.9) 36%,rgba(168,245,255,0.69) 66%,rgba(255,255,255,0.69) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e600e1ff', endColorstr='#b0ffffff',GradientType=0 ); /* IE6-9 */

	
	
	
	
}

.boxName{
	
	clear:both;
	
}


#possiblefriends {
	
	width: auto;
	height: 180px;
	overflow-y: scroll;
    -webkit-box-shadow: -1px -1px 40px 10px rgba(0,0,0,0.3);
	-moz-box-shadow: -1px -1px 40px 10px rgba(0,0,0,0.3);
	box-shadow: -1px -1px 40px 10px rgba(0,0,0,0.3);
	margin-bottom: 10px;
	clear:both;
	
}


.imgPost {
		display:block;
		height: 80px;
		width: 80px;
		
}

.imgPost img {
		height: 80px;
		width: 80px;
		
}


.namePost {
		
		font-weight:bold;
		margin: 15px;
		
}


.contentPost{
		
	border-left: solid 2px gray;
	border-top: solid 2px gray;
	border-radius:5px 0 0 0;
	margin: 15px;
	float:left;
	display:block;
	width: 100%;
	height: auto;
		
		
}
	
.textPost{
	margin: 5px;
	clear: both;
		
}
	
.divBottom{
		
	padding: 0;
	margin: 0;
		
}
	
.bottom {
	margin:0;
	padding:0;
	display:block;
	overflow: auto;
}

.bottom li{
	margin:0;
	padding:0;
	display:block;
	list-style-type: none;
	border: solid 1px gray;
	float: left;
	width: 25%;
	text-align: center;
	border-radius:5px 5px 0 0;
		
}
	
.bottom li img{
		
	width: 15px;
		
}


@stop


