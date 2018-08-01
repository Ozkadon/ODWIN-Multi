<?php
	if (!empty($data)):
		$data = $data[0];
?>
	<div class="x_panel">
		<div class="x_content">
			<div class="form-group col-xs-12">
				<label class="control-label">ID :</label>
				<span class="form-control"><?=$data->id;?></span>
			</div>
			<div class="form-group col-xs-12">
				<label class="control-label">Name :</label>
				<span class="form-control"><?=$data->name;?></span>
            </div>
			<div class="form-group col-xs-12">
                <label class="control-label">Address :</label>
                <span class="form-control"><?=$data->address;?></span>
            </div>
			<div class="form-group col-xs-12">
                <label class="control-label">Email :</label>
                <span class="form-control"><?=$data->email;?></span>
            </div>
			<div class="form-group col-xs-12">
				<label class="control-label">Date :</label>
				<span class="form-control"><?=date('d M Y H:i:s', strtotime($data->created_at));?></span>
			</div>
			<div class="form-group col-xs-12">
                <label class="control-label">Subject :</label>
                <span class="form-control"><?=$data->subject;?></span>
            </div>
			<div class="form-group col-xs-12">
                <label class="control-label">Message :</label>
                <div class="detail-view"><?=nl2br($data->message);?></div>
            </div>
		</div>
	</div>
<?php
	endif;
?>

