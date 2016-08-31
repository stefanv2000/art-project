/**
 * 
 */

$.fn.contentelem = function(options){
	var contentid = 0;
	
	function initContent(rootElem){
		contentid = rootElem.data('idelem');
		initDelete();
		initEditContent();
		initCover();
		//initLightbox();
	}
	
	//link delete content
	function initDelete(){
		$('#admindeletecontent_'+contentid).click(function(e){
			e.preventDefault();
			$('body').append('<div id="dialogmodal_'+contentid+'" title="Delete content">Are you sure you want to delete media? <div id="deleteresult" class="deleteresult"></div></div>');
			$("#dialogmodal_"+contentid).dialog({
												modal : true,
												position: {my:'top',at:'top+60'},
												minWidth:500,
												buttons:{
													'Confirm' : function(){
														$.get('/admin/content/delete/'+contentid,{
														},function(result){
															if (result['code'] == 'success'){
																$('#deleteresult').html('<div class="alert alert-success">Content deleted</div>');
																setTimeout(function(){
																	$('#mediaelementcontainer_'+contentid).remove();
																	$("#dialogmodal_"+contentid).dialog('close');
																$('#dialogmodal_'+contentid).remove();},globalTimeout);
															} else {
																$('#deleteresult').html('<div class="alert alert-danger">An error occurred</div>');
															}			
														});													
													},												
													'Cancel' :	function(){
														$('#dialogmodal_'+contentid).remove();
													},
												}, 
											});	

		});				
	}
	
	
	//edit content caption and description		
	function initEditContent(){
		$('#admineditcontent_'+contentid).click(function(e){
			e.preventDefault();
			$('body').append('<div id="dialogmodal_'+contentid+'" title="Edit content" ><div id="dialogcontent_'+contentid+'" ></div></div>');
			 $("#dialogmodal_"+contentid).dialog({
												modal : true,
												width:500,
												position: {my:'top',at:'top+60'},
												close: function(){
													$('#dialogmodal_'+contentid).remove();
												}
											});		
			$.get('/admin/content/edit/'+contentid,{
			},function(data){
				$('#dialogcontent_'+contentid).html(data);
				addHtmlEditor("#formeditmediacontent textarea.form-control");
				$('#formeditmediacontent').submit(function(e){
					e.preventDefault();
					$.post('/admin/content/sendedit',
							$('#formeditmediacontent').serialize(),
							function(result){
								if (result['code'] == 'success'){
									$('#editformresult').html('<div class="alert alert-success">'+result['message']+'</div>');
									setTimeout(function(){$("#dialogmodal_"+contentid).dialog('close');
									$('#dialogmodal_'+contentid).remove();},globalTimeout);
									
									newMediaElem(contentid,false);									
								} else {
									$('#editformresult').html('<div class="alert alert-danger">'+result['message']+'</div>');						
								}	
					});	
				});
			});
		});				
	}	
	
	function initLightbox(){
		$('#mediaelement_'+contentid).click(function(e){
			e.preventDefault();
			var elem = $(this);
			if (elem.data('mediatype') == 1){
				html5Lightbox.showLightbox(0, elem.data('mediasource'), '');
			} else
				if (elem.data('mediatype') == 2){
					//html5Lightbox.showLightbox(0, elem.data('mediasource'), 'Video lightbox',elem.data('mediawidth'),elem.data('mediaheight'),elem.data('mediasource'));
					html5Lightbox.showLightbox(2, elem.data('mediasource'), ' ', elem.data('mediawidth'),elem.data('mediaheight'), elem.data('mediasource'));					
				}
		});
	}
	
	function initCover(){
		$('#admincovercontent_'+contentid).click(function(e) {
			e.preventDefault();
			$('body').append('<div id="dialogmodal_'+contentid+'" title="Media content cover" ><div id="dialogcontent_'+contentid+'" ></div></div>');
			 $("#dialogmodal_"+contentid).dialog({
												modal : true,
												minWidth:500,
												position: {my:'top',at:'top+60'},
												autoResize:true,
												close: function(){
													$('#dialogmodal_'+contentid).remove();
												}
											});
			 $('#dialogcontent_'+contentid).append('<div id="deletecovercontainer"><img style="float:right" src="/img/deleteicon.png" id="deletecover" class="adminimgicons"/></div>');
			 $('#deletecovercontainer').hide();
			 $('#deletecover').click(function(e){
				$.get('/admin/content/removecover',{
					contentid:contentid
				},function(data){
					console.log(data);
					$('#deletecovercontainer').hide();
					$('#contentcovercontainer').html('');
					newMediaElem(contentid,false);
				});
			 });
			 $('#dialogcontent_'+contentid).append('<div id="contentcovercontainer" style="padding:10px;"></div>');
			 $.get('/admin/content/getcover',{
				 contentid:contentid
			 },function(data){
				if (data['code'] == 'success'){
					$('#deletecovercontainer').show();
					$('#contentcovercontainer').html('<img src="/media/images/previews/'+data['details']['hashcode']+'_w150_h150.'+data['details']['extension']+'" />');
				} 
			 });
			 $('#dialogcontent_'+contentid).append('<div id="dropzone2" class="dropzone" data-url="/admin/content/uploadcover" data-contentid="'+contentid+'">');
				$('#dropzone2').dropzone({ 
					url: $('#dropzone2').data('url'),
					//acceptedFiles: '.jpg,.jpeg,.svg,.png,.mp4,.avi,.mov,.mkv,.gif'
					});			 
			
		});
	}

	initContent(this);
	return this;
};


function bulkActions(){
	$('#selectallcontent').click(function(e){
		e.preventDefault();
		$('.admincheckboxcontent').each(function(index,elem){
			$(elem).prop('checked',true);
		});		
	});
	$('#clearselectioncontent').click(function(e){
		e.preventDefault();
		$('.admincheckboxcontent').each(function(index,elem){
			$(elem).prop('checked',false);
		});		
	});	
	
	function getSelectionSerialised(){
		var ckboxSerialized = '?x=1';
		$('.admincheckboxcontent:checked').each(function(index,elem){
			ckboxSerialized+='&mediaelement[]='+$(elem).attr('id').substr(21);
		});
		return ckboxSerialized;
	}
	
	function changeStatus(status){
		
		var ckboxSerialized = getSelectionSerialised();
		ckboxSerialized+='&status=';
		if (status) ckboxSerialized+='1'; else ckboxSerialized+='0';
		$.get('/admin/content/bulkchangestatus',ckboxSerialized
				,function(result){		
					if (result['code'] == 'success'){
						for ( var i in result['result']) {
							var id = result['result'][i];
							$('#admincheckboxcontent_'+id).prop('checked',false);
							var mielem = $('#mediaimage_'+id);
							if (status) mielem.data('opacity',1);
								else mielem.data('opacity',0.2);
							mielem.css('opacity',mielem.data('opacity'));
						};
					};	
				});				
	
	}
	
	

	
	$('#bulkenablecontent').click(function(e) {
		e.preventDefault();
		changeStatus(true);
	});
	
	$('#bulkdisablecontent').click(function(e) {
		e.preventDefault();
		changeStatus(false);
	});	
	
	$('#bulkdeletecontent').click(function(e) {
		e.preventDefault();
		var contentid = 'bulkdelete';
		var ckboxSerialized = getSelectionSerialised();
		$('body').append('<div id="dialogmodal_'+contentid+'" title="Delete content">Are you sure you want to delete selected media? <div id="deleteresult" class="deleteresult"></div></div>');
		$("#dialogmodal_"+contentid).dialog({
											modal : true,
											position: {my:'top',at:'top+60'},
											buttons:{
												'Confirm' : function(){
													$.get('/admin/content/bulkdelete',ckboxSerialized
													,function(result){														
														if (result['code'] == 'success'){
															$('#deleteresult').html('<div class="alert alert-success">Content deleted</div>');
															setTimeout(function(){						
																$("#dialogmodal_"+contentid).dialog('close');
															$('#dialogmodal_'+contentid).remove();},globalTimeout);
															
														} else {
															$('#deleteresult').html('<div class="alert alert-danger">Some content couldn\'t be deleted</div>');						
														}			
														for ( var i in result['result']) {
															var id = result['result'][i];
															$('#mediaelementcontainer_'+id).remove();
														}
														
													});													
												},												
												'Cancel' :	function(){
													$('#dialogmodal_'+contentid).remove();
												},
											}, 
										});			
	});
	
	
	$('#bulkmovecontent').click(function(e) {
		e.preventDefault();
		var contentid = 'bulkmovecontent';
		var ckboxSerialized = getSelectionSerialised();
		$('body').append('<div id="dialogmodal_'+contentid+'" title="Move content"><div id="dialogcontent_'+contentid+'"></div></div>');
		$.get('/admin/section/sectionslist',{
		},function(data){
			$('#dialogcontent_'+contentid).html(data);
			$('#formmovesection').submit(function(e){
				e.preventDefault();
				ckboxSerialized+="&newsectionid="+$('#newsection').val();
				$.get('/admin/content/bulkmove',
							ckboxSerialized,
						function(result){
							if (result['code'] == 'success'){
								$('#moveformresult').html('<div class="alert alert-success">'+result['message']+'</div>');
								setTimeout(function(){
									$('#sectioncontainer_'+contentid).remove();
									$("#dialogmodal_"+contentid).dialog('close');
								$('#dialogmodal_'+contentid).remove();},globalTimeout);
							} else {
								$('#moveformresult').html('<div class="alert alert-danger">'+result['message']+'</div>');						
							}	
							for ( var i in result['result']) {
								var id = result['result'][i];
								$('#mediaelementcontainer_'+id).remove();
							}							
				});	
			});
		});		
		$("#dialogmodal_"+contentid).dialog({
											modal : true,
											position: {my:'top',at:'top+60'},
											buttons:{
												'Cancel' :	function(){
													$('#dialogmodal_'+contentid).remove();
												},
											}, 
										});			
	});
	
	
	
}


function newMediaElem(contentid,append){
	$.get('/admin/content/getcontenthtml/'+contentid,{},
			function(data){
		
				var elem = $(data);
				if (append){
					$('#mediacontainer').append(elem);					
				} else $('#mediaelementcontainer_'+contentid).replaceWith(elem);								
				elem.contentelem();
				$('#mediacontainer').mySortable();
		});	
}
Dropzone.autoDiscover = false;
$(document).ready(function(){
	Dropzone.options.dropzone = {
			init:function(){
				console.log('called');
				this.on("sending",function(file,xhr,formData){
					formData.append('sectionid',$('#dropzone').data('sectionid'));
				});
				var mydropzone = this;
				this.on("success",function(file,data){					
					if (data['code'] == 'success'){
						newMediaElem(data['id'],true);
					this.removeFile(file);
					}
				});
			}	
		};
	
	
	Dropzone.options.dropzone2 = {
			init:function(){
				console.log('called2');
				this.on("sending",function(file,xhr,formData){
					formData.append('contentid',$('#dropzone2').data('contentid'));
				});
				var mydropzone = this;
				this.on("success",function(file,data){
					if (data['code'] == 'success'){
							$('#deletecovercontainer').show();
							$('#contentcovercontainer').html('<img src="/media/images/previews/'+data['details']['hashcode']+'_w150_h150.'+data['details']['extension']+'" />');
							var contentid= data['contentid'];
							newMediaElem(contentid,false);
							this.removeFile(file);
					}
				});
			}	
		};	
	
	
	
	bulkActions();
	
	//new Dropzone("div#dropzone", { url: $('#drpzone').attr('action')});
	
	$('#dropzone').dropzone({ 
		url: $('#dropzone').data('url'),
		//acceptedFiles: '.jpg,.jpeg,.svg,.png,.mp4,.avi,.mov,.mkv,.gif'
		});
	//$("#dropzone").dropzone({ url: $('.dropzone').attr('action') });
	$('#mediacontainer').mySortable({'tab' : 'media'});	
	
	$('.mediaelementcontainer').each(function(index,elem){
		$(elem).contentelem();
	});
	
	$('.mediaimage').each(function(index,elem){
		$(elem).css('opacity' , $(elem).data('opacity'));
	});
	
	$('.mediaimage').mouseenter(function(){
		$(this).css('opacity',1);
	}).mouseleave(function(){
		$(this).css('opacity',$(this).data('opacity'));
	});
	
	$('#submitformlinkvideo').click(function(event){
		event.preventDefault();
		$('#resultnewvideolinkform').html('Fetching. Please wait ... ');
		$.post('/admin/content/uploadvideolink',
				{ videolink : $('#formlinkvideosite').val(),
					sectionid : $('#videolinksectionid').val(),
					},
				function(data){
					if (data['code'] == 'success'){
						newMediaElem(data['id'],true);	
						$('#formlinkvideosite').val('');
						$('#resultnewvideolinkform').html('The video was successfully added');
					} else {
						$('#resultnewvideolinkform').html('An error occurred. Please try again.');
					}
				},
				'json');
	});
	
});