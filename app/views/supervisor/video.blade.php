@extends("layout.main-mobile")

@section("content")

	<div data-role="page" data-title="Search">

	    <div role="main" class="ui-content jqm-content jqm-fullwidth">


            <div id="video_player">
                <span class="thumbnail">
                    <iframe width="320" height="240" src="{{url('//www.youtube.com/embed/'.$vid)}}" frameborder="0" allowfullscreen></iframe>
                    <p class="title">{{$data["title"]}}</p>
                    <p class="desc">{{ $data["description"] }}</p>
                </span>

                <span id="controls" class="thumbnail" style="height: auto; ">

                    <div id="info" style="overflow: auto; witdh: 50px; ">
                        <span id="pub"><strong>Published:</strong> {{Str::limit($data["upload_date"],10,"")}}</span><br>
                        <span id="views"><strong>Views:</strong> {{$data["view_count"]}}</span>
						
                    </div>
					
					<div id="likes" data-role="controlgroup" data-type="horizontal" data-mini="true" style="witdh: auto;">
						<a id="like" href="{{url("supervisor/aprovarconteudo/".$id)}}" class="active ui-btn ui-corner-all ui-icon-delete fa fa-thumbs-up "> Aprovar Contéudo</a>						
						<a id="unlike" href="{{url("supervisor/reprovarconteudo/".$id)}}" class="ui-btn ui-corner-all ui-icon-delete fa fa-thumbs-down"> Reprovar Contéudo </a>
					</div>
					
                </span>

            </div>


		</div><!-- /content -->

	</div><!-- /page -->

@stop

@section("style")

    #like {
        background: #7B7;
    }
    #like:hover {
        background: #BEB;
    }

    #unlike {
        background: #E66;
    }
    #unlike:hover {
        background: #F88;
    }

    #video_player {
        margin: auto;
        width: 100%;
        text-align: center;
    }

    #video_player iframe {
        margin: auto;
    }
    .thumbnail .title {
        text-align: left;
        font-size: 0.8em;
        font-weight: bold;
        padding: 5px 10px 0;
    }
    .thumbnail .desc {
        font-size: 0.7em;
        padding: 2px 0;
        margin: 0;
        text-align: left;
        padding: 0 10px 5px;
    }
    #controls {
        text-align: left;
        height: 50px;
    }
    #info {
        left: 30px;
        font-size: 0.8em;
    }
    #info #pub {

    }
    #info #views {
        float: left;
    }


@stop