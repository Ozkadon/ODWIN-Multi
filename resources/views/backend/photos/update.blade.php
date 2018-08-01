<?php
	$breadcrumb = [];
	$breadcrumb[0]['title'] = 'Dashboard';
	$breadcrumb[0]['url'] = url('backend/dashboard');
	$breadcrumb[1]['title'] = 'Photos';
	$breadcrumb[1]['url'] = url('backend/photos');	
	$breadcrumb[2]['title'] = 'Add';
	$breadcrumb[2]['url'] = url('backend/photos/create');
	if (isset($data)){
		$breadcrumb[2]['title'] = 'Edit';
		$breadcrumb[2]['url'] = url('backend/photos/'.$data[0]->id.'/edit');
	}
?>

<!-- LAYOUT -->
@extends('backend.layouts.main')

<!-- TITLE -->
@section('title')
	<?php
		$mode = "Create";
		if (isset($data)){
			$mode = "Edit";
		}
	?>
    Photos - <?=$mode;?>
@endsection

<!-- CONTENT -->
@section('content')
	<?php
		$active = 1;
		$method = "POST";
		$mode = "Create";
		$url = "backend/photos/";
		if (isset($data)){
			$active = $data[0]->active;
			$method = "PUT";
			$mode = "Edit";
			$url = "backend/photos/".$data[0]->id;
		}
	?>
	<div class="page-title">
		<div class="title_left">
			<h3>Photos - <?=$mode;?></h3>
		</div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 col-xs-8 form-group pull-right top_search">
                @include('backend.elements.back_button',array('url' => '/backend/photos'))
			</div>
        </div>
        <div class="clearfix"></div>
		@include('backend.elements.breadcrumb',array('breadcrumb' => $breadcrumb))
	</div>
	<div class="clearfix"></div>
    <br/><br/>
    {{ Form::open(['url' => $url, 'method' => $method,'class' => 'form-horizontal form-label-left']) }}
    {!! csrf_field() !!}
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
                <div class="x_title">
                    <h2>Album</h2>
                    <div class="clearfix"></div>
                </div>
				<div class="x_content">
                    <div class="form-group">
                        <label class="control-label col-sm-3 col-xs-12">Status: </label>
                        <div class="col-sm-5 col-xs-12">
                            {{
                            Form::select(
                                'active',
                                ['1' => 'Active', '2' => 'Deactive'],
                                $active,
                                array(
                                    'class' => 'form-control',
                                ))
                            }}								
                        </div>
                    </div>
                    <br/>
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <?php
                                $default_language = Session::get('default_language');
                                $active_language = Session::get('active_language');
                                foreach ($active_language as $language):
                                    $active = "";
                                    if ($default_language->code == $language->code){
                                        $active = "active";
                                    }
                            ?>
                                <li role="presentation" class="<?=$active;?>"><a href="#tab-<?=$language->code;?>" id="<?=$language->code;?>" role="tab" data-toggle="tab" aria-expanded="true"><?=$language->name;?></a></li>
                            <?php
                                endforeach;
                            ?>
                        </ul>
                        <div id="content-language" class="tab-content">
                            <?php
                                $judul = "";
                                foreach ($active_language as $language):
                                    $active = "";
                                    if ($default_language->code == $language->code){
                                        $active = "active in";
                                    }
                                    if (isset($data)){
                                        $judul = "";
                                        foreach ($data_language as $data_language_single):
                                            if ($data_language_single->language_code == $language->code){
                                                $judul = $data_language_single->judul;
                                            }
                                        endforeach;
                                    }

                            ?>
                                <div role="tabpanel" class="tab-pane fade <?=$active;?>" id="tab-<?=$language->code;?>" aria-labelledby="<?=$language->code;?>">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 col-xs-12">Title <span class="required">*</span></label>
                                        <div class="col-sm-7 col-xs-12">
                                            <input type="text" name="judul_<?=$language->code;?>" required="required" class="form-control" value="<?=$judul;?>">
                                        </div>
                                    </div>
                                </div>
                            <?php
                                endforeach;
                            ?>
                        </div>
                    </div>
				</div>
			</div>
		</div>
    </div>
    <div class="clearfix"></div>
	<div class="row">
		<div class="col-xs-12">
			<div class="x_panel">
                <div class="x_title">
                    <h2>Photo Gallery</h2>
                    <div class="clearfix"></div>
                </div>
				<div class="x_content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3">
                            <a href="<?=url('/backend/media-library/popup-media-gallery/');?>" id="popup_media_gallery" class="btn btn-info btn-block">Add Picture</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12"><br/>
                            <div class="gallery-env gallery_detail">
                                <div class="row sortable" id="gallery_detail">
                                    <?php
                                        foreach ($detail as $detail):
                                    ?>
                                        <div class="col-md-55 wrapper-gallery">
                                            <div class="thumbnail">
                                                <input name="gallery_detail_id[]" type="hidden" class="media-id" value="<?=$detail->image_id;?>">
                                                <div class="image view view-first">
                                                    <?php
                                                        $src = "";
                                                        $name = "";
                                                        if (isset($detail->media_image_1)){
                                                            $src = url($detail->media_image_1->url);
                                                            $name = $detail->media_image_1->name;
                                                        }
                                                    ?>
                                                    <img style="width: 100%; display: block;" src="<?=$src;?>" alt="">
                                                    <div class="mask">
                                                        <p>Click X to remove</p>
                                                        <div class="tools tools-bottom">
                                                            <a class="delete" href="#"><i class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="caption">
                                                    <p><?=$name;?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                        endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-sm-6 col-xs-12 col-sm-offset-3">
                            <a href="<?=url('/backend/photos')?>" class="btn btn-warning">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit </button>
                        </div>
                    </div>
				</div>
			</div>
		</div>
    </div>
    {{ Form::close() }}    
@endsection

<!-- CSS -->
@section('css')
    <style>
        .wrapper-gallery{
            cursor : move;
        }
    </style>
@endsection

<!-- JAVASCRIPT -->
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#popup_media_gallery").colorbox({
                'width'				: '75%',
                'height'			: '90%',
                'maxWidth'			: '75%',
                'maxHeight'			: '90%',
                'transition'		: 'elastic',
                'scrolling'			: false,
                
                onComplete			: function() { 
                                                    $( "#pop-up.tab-content" ).height(0.75 * $( "#cboxLoadedContent" ).height());
                                                    $( ".table-content" ).height($( "#pop-up.tab-content" ).height()-60);
                                                    $( ".fancybox-inner" ).css('overflow','hidden');
                                                },
                
                onClosed			: function() { 
                                                    $.ajax({
                                                        type: "GET",
                                                        url: '<?=url('backend/media-library/trash');?>',
                                                        success: function(){}
                                                    });
                                    },
                
            });
        })

		$('div.gallery-env').on("click", 'a.delete', function(e){
			e.preventDefault();
			$(this).closest('.wrapper-gallery').remove();
		});	

        $( ".sortable" ).sortable({
            cursor : 'move',
            opacity: 0.6
        });
        $( ".sortable" ).disableSelection();
    </script>
@endsection