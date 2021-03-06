<!-- Page header -->

<div class="page-header">

	<div class="page-title">

		<h3>

			<?=$this->lang->line('invoice')?>
			
			<?=format_id($item->invoice_id)?>

			<span class="pull-right"><?=$item->account_title?></span>

		</h3>

	</div>

</div>

<!-- /page header -->


<div class="row">

	<div class="form-horizontal col-sm-8 col-xs-12">

		<?if($item->invoice_recurrency_id){?>
			<div class="form-group">

				<label class="col-sm-5 control-label">

					<?=$this->lang->line('invoice_recurrency_id')?>

				</label>

				<div class="col-sm-7">

					<p class="form-control-static">
					
						<a class="" href="<?=base_url()?>recurrencies/view/<?=$item->invoice_recurrency_id;?>">
							<?=format_id($item->invoice_recurrency_id)?>
							-
							<?=$item->recurrency_description?>
						</a>
						


					</p>

				</div>

			</div>
		<?}?>	
	
		<div class="form-group">

			<label class="col-sm-5 control-label">

				<?=$this->lang->line('account_title')?>

			</label>

			<div class="col-sm-7">

				<p class="form-control-static">
				
					<?=$item->account_title?>
					<div class="small"><?=$item->account_email?></div>

				</p>

			</div>

		</div>
	
			
		<div class="form-group">

			<label class="col-sm-5 control-label">

				<?=$this->lang->line('invoice_amount')?>

			</label>

			<div class="col-sm-7">

				<p class="form-control-static">
				
					<?=format_currency($item->invoice_amount)?>

				</p>

			</div>

		</div>
	
		<div class="form-group">

			<label class="col-sm-5 control-label">

				<?=$this->lang->line('invoice_status')?>

			</label>

			<div class="col-sm-7">

				<p class="form-control-static">
				
					<? $item_status = $this->Invoice->get_invoice_status($item);  ?>
					<?if($item->invoice_status==2){?>
						<span class="text-danger bold"><?=$this->lang->line($notification_types[2]);?></span>
					<?}elseif($item->invoice_status==1){?>
						<span class="text-success bold"><?=$this->lang->line($notification_types[1]);?></span>
					<?}elseif($item->invoice_status==0){?>		
						<span class="text-warning bold"><?=$this->lang->line($notification_types[0]);?></span>
					<?}?>		

				</p>

			</div>

		</div>	
	
		<div class="form-group">

			<label class="col-sm-5 control-label">

				<?=$this->lang->line('invoice_description')?>

			</label>

			<div class="col-sm-7">

				<p class="form-control-static">
				
					<?=$item->invoice_description?>

				</p>

			</div>

		</div>
		
		<div class="form-group">

			<label class="col-sm-5 control-label">

				<?=$this->lang->line('invoice_due_date')?>

			</label>

			<div class="col-sm-7">

				<p class="form-control-static">
				
					<?=human_date($item->invoice_due_date);?>

				</p>

			</div>

		</div>
	
		<div class="form-group">

			<label class="col-sm-5 control-label">

				<?=$this->lang->line('invoice_paid_date')?>

			</label>

			<div class="col-sm-7">

				<div class="form-control-static">
				
					<?=human_date($item->invoice_paid_date);?>
					
				</div>

			</div>

		</div>
		
		<div class="form-group">

			<label class="col-sm-5 control-label">

				<?=$this->lang->line('invoice_created_date')?>

			</label>

			<div class="col-sm-7">

				<p class="form-control-static">
				
					<?=human_date($item->invoice_created_date);?>

				</p>

			</div>

		</div>
		
		
	</div>   

	
	<div class="col-sm-4 col-xs-12">
	
			<h4>
				<?=$this->lang->line('invoice_status_updates')?> (<?=count($item->status_updates)?>)
				<a class="btn btn-xs btn-default pull-right" href="invoice_status_updates/create/<?=$item->invoice_id?>"><?=$this->lang->line('create')?></a>
			</h4>

			
		<?if(count($item->status_updates)>0){?>		
		
			<?foreach($item->status_updates as $status_update){?>
			
				<p>
				
					<a href="javasvcript:void(0);" onclick="$('#status_update_info_<?=$status_update->invoice_status_update_id?>').toggle(200)"><i class="fa fa-info-circle"></i></a>
				
					<a href="invoice_status_updates/view/<?=$status_update->invoice_status_update_id?>"><?=human_date($status_update->invoice_status_update_datetime)?></a>
				
					<span class="label label-<?=$status_update->invoice_status_update_status_code==1?'success':'default'?>"><?=$statuses[$status_update->invoice_status_update_status_code]?></span>
					
					<div class="small" style="display:none;" id="status_update_info_<?=$status_update->invoice_status_update_id?>">
					
						<b><?=$this->lang->line('invoice_status_update_gateway')?>:</b> <?=$gateways[$status_update->invoice_status_update_gateway]?> 
						
						<br>
						
						<b><?=$this->lang->line('invoice_status_update_transaction')?>:</b> <?=$status_update->invoice_status_update_transaction?>
						
					</div>
					
				</p>
				
			<?}?>
									
		<?}elseif(!$item->invoice_paid_date){?>
		
			<?if($this->System_settings->settings->activate_pagseguro){?>
			
				<p><a href="invoices/payment_pagseguro/<?=$item->invoice_id?>" class="btn btn-block btn-success"/><?=$this->lang->line('pay_with_pagseguro')?></a></p>
			
			<?}?>	
			
			<?if($this->System_settings->settings->activate_bank_transfer){?>
			
			<p><a href="javascript:void(0);" onclick="$('.bank_transfer_instructions').toggle(200);" class="btn btn-block btn-success"/><?=$this->lang->line('pay_with_bank_transfer')?></a></p>
			
			
				<div class="well bank_transfer_instructions" style="display:none;">
				
					<?=$this->System_settings->settings->bank_transfer_instructions_template;?>
					
				</div>
				
			<?}?>						
			
		<?}?>	
	
		<!--
		<a class="btn btn-block btn-default view-option-link" href="<?=base_url()?>invoice_status_updates/index/<?=$item->invoice_id?> " >

			<?=$this->lang->line('invoice_status_updates')?>
		
		</a>
		-->
	
		<hr>
	
		<h4>
			<?=$this->lang->line('invoice_notifications')?> (<?=count($item->notifications)?>)
			<a class="btn btn-xs btn-default pull-right" href="invoice_notifications/create/<?=$item->invoice_id?>"><?=$this->lang->line('create')?></a>
		</h4>

		
		<?if(count($item->notifications)>0){?>		
							
				<?foreach($item->notifications as $notification){?>
				
					<p>
					
						<a href="javasvcript:void(0);" onclick="$('#notifications_info_<?=$notification->invoice_notification_id?>').toggle(200)"><i class="fa fa-info-circle"></i></a>
					
						<a href="invoice_notifications/view/<?=$notification->invoice_notification_id?>"><?=human_date($notification->invoice_notification_sent)?></a>
					
						<span class="label label-<?=$notification->invoice_notification_type==2?'danger':'default'?>"><?=$this->lang->line($notification_types[$notification->invoice_notification_type])?></span>
					
						<div class="small" style="display:<?=$notification->invoice_notification_read?'block':'none'?>;" id="notifications_info_<?=$notification->invoice_notification_id?>">
						
							<b><?=$this->lang->line('invoice_notification_read')?>:</b> <?=human_date($notification->invoice_notification_read)?> 
							
							<?if($notification->invoice_notification_read){?>
								<br>
								<b><?=$this->lang->line('invoice_notification_read_ip')?>:</b> <?=$notification->invoice_notification_read_ip?>
							<?}?>
							
						</div>
						
					</p>
					
				<?}?>						
			
		<?}?>			
		<!--
		<a class="btn btn-block btn-default view-option-link" href="<?=base_url()?>invoice_notifications/index/<?=$item->invoice_id?> " >

			<?=$this->lang->line('invoice_notifications')?>
		
		</a>			
		-->

		<hr>
		<div class="row">

			<div class="col-xs-12">
		
				<a class="btn btn-block btn-default view-option-link" target="_blank" href="<?=$item->invoice_public_url?>" >

					<?=$this->lang->line('invoice_public_url')?>
				
				</a>	
			</div>

			<div class="col-xs-8">
		
				<a class="btn btn-block btn-default view-option-link" href="<?=base_url()?>invoices/update/<?=$item->invoice_id?> " >

					<?=$this->lang->line('update')?>
					<?=$this->lang->line('invoice')?>
				
				</a>	
			</div>
			<div class="col-xs-4">
				<a class="btn btn-block btn-danger" href="<?=base_url()?>invoices/remove/<?=$item->invoice_id?> " >
				
					<?=$this->lang->line('remove')?>
					
				</a>		
			</div>
		</div>							
		

	</div>

</div>