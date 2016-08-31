	$.fn.textblockline = function(options){
		var textblockid = 0;
		
		function inittextblock(sectionelement){
			textblockid = parseInt(sectionelement.attr('id').substr(19));
			initDelete();					
			initChangeStatus();
			initEditTextBlock();
		}
		//link delete text block
		function initDelete(){
			$('#deletetextblocklink_'+textblockid).click(function(e){
				console.log('xxx');
				e.preventDefault();
				$('body').append('<div id="dialogmodal_'+textblockid+'" title="Delete text block">Are you sure you want to delete textblock "'+$('#textblockname_'+textblockid).html()+'"? <div id="deleteresult" class="deleteresult"></div></div>');
				$("#dialogmodal_"+textblockid).dialog({
													modal : true,
													minWidth:500,
													position: {my:'top',at:'top+60'},
													buttons:{
														'Confirm' : function(){
															$.get('/admin/textblock/delete/'+textblockid,{
															},function(result){
																if (result['code'] == 'success'){
																	$('#deleteresult').html('<div class="alert alert-success">Text block deleted</div>');
																	setTimeout(function(){
																		$('#textblockcontainer_'+textblockid).remove();
																		$("#dialogmodal_"+textblockid).dialog('close');
																	$('#dialogmodal_'+textblockid).remove();},globalTimeout);
																} else {
																	$('#deleteresult').html('<div class="alert alert-danger">An error occurred</div>');
																}			
															});													
														},												
														'Cancel' :	function(){
															$('#dialogmodal_'+textblockid).remove();
														},
													}, 
												});	

			});				
		}
		
		//change status of the text block
		function initChangeStatus(){			
			$('#textblockchangestatuslink_'+textblockid).click(function(e){
				e.preventDefault();
				var status = 0;		
				if ($(this).html() == 'Enable textblock') status=1;
				$.get('/admin/textblock/changestatus',{
					textblockid:textblockid,
					status:status
				},function(result){
					if (result['code']!='success') return;
					if (status==1) {
							$('#textblockchangestatuslink_'+textblockid).html('Disable textblock');
							$('#textblockcontainer_'+textblockid).removeClass('sectiondisabled');
						}
					else {
						$('#textblockchangestatuslink_'+textblockid).html('Enable textblock');
						$('#textblockcontainer_'+textblockid).addClass('sectiondisabled');
					}
				});
			});			
		}

		//edit section		
		function initEditTextBlock(){
			$('#edittextblocklink_'+textblockid).click(function(e){
				e.preventDefault();
				$('body').append('<div id="dialogmodal_'+textblockid+'" title="Edit text block"><div id="dialogcontent_'+textblockid+'"></div></div>');
				 $("#dialogmodal_"+textblockid).dialog({
													modal : true,
													minWidth:800,
													position: {my:'top',at:'top+60'},
													close: function(){
														$('#dialogmodal_'+textblockid).remove();
													}
												});		
				$.get('/admin/textblock/edit/'+textblockid,{
				},function(data){
					$('#dialogcontent_'+textblockid).html(data);
					addHtmlEditor("#formedittextblock textarea.form-control");
					$('#formedittextblock').submit(function(e){
						e.preventDefault();
						$.post('/admin/textblock/sendedit',
								$('#formedittextblock').serialize(),
								function(result){
									if (result['code'] == 'success'){
										$('#editformresult').html('<div class="alert alert-success">'+result['message']+'</div>');
										setTimeout(function(){$("#dialogmodal_"+textblockid).dialog('close');
										$('#dialogmodal_'+textblockid).remove();},globalTimeout);
										
										$.get('/admin/textblock/gettextblockhtml/'+textblockid,{},
												function(data){
													var elem = $(data);
													$('#textblockcontainer_'+textblockid).replaceWith(elem);								
													elem.textblockline();
													$('#textblocks').mySortable();
											});												
									} else {
										$('#editformresult').html('<div class="alert alert-danger">'+result['message']+'</div>');						
									}	
						});	
					});
				});
			});				
		}
		inittextblock(this);
		return this;		
	};


	function initAddNewTextBlock(parentSection)
	{
		var sectionid = "addnewtextblock";
		$('#showaddnewtextblock').click(function(e){
			e.preventDefault();
			$('body').append('<div id="dialogmodal_'+sectionid+'" title="Add new text content"><div id="dialogcontent_'+sectionid+'"></div></div>');

			$("#dialogmodal_"+sectionid).dialog({
				modal : true,
				minWidth:800,
				position: {my:'top',at:'top+60'},
				close: function(){
					$('#dialogmodal_'+sectionid).remove();
				},
				show: function(){

				}
			});

			$.get('/admin/textblock/addform/'+parentSection,{
			},function(data) {
				$('#dialogcontent_' + sectionid).html(data);
				addHtmlEditor("#formaddnewtextblock textarea.form-control");
				//on submit the add new text box form
				$('#formaddnewtextblock').submit(function(e){
					e.preventDefault();

					$('#resultnewshowaddnewtextblockform').html('<div class="alert alert-warning"><img src="/img/loading.gif" class="imageloading"></div>');
					$.post('/admin/textblock/sendadd',
						$('#formaddnewtextblock').serialize(),
						function(result){
							if (result['code'] == 'success'){
								$('#resultnewshowaddnewtextblockform').html('<div class="alert alert-success">'+result['message']+'</div>');
								setTimeout(function(){
									$("#dialogmodal_"+sectionid).dialog('close');
									$('#dialogmodal_'+sectionid).remove();
								},globalTimeout);

								$.get('/admin/textblock/gettextblockhtml/'+result['id'],{},
									function(data){

										var elem = $(data);
										$('#textblocks').append(elem);
										elem.textblockline();
										$('#textblocks').mySortable();
									});
							} else {
								$('#resultnewshowaddnewtextblockform').html('<div class="alert alert-danger">'+result['message']+'</div>');
							}

						}
					);
				});

			});
		});

	}

$(document).ready(function(){

	initAddNewTextBlock(currentSectionId);
	//slide down/up the form on click
	$('#containernewtextblockform').css('display','none');
/*	$('#showaddnewtextblock').click(function(e){
		e.preventDefault();
		if ($('#formaddnewtextblock').is(':hidden')) {
			$('#containernewtextblockform').slideDown();
			$(this).html('Hide');
		} else {
			$('#containernewtextblockform').slideUp();
			$(this).html('Add new text block');			
		}
	});*/
	
	//init sort list of sections
	$('#textblocks').mySortable({'tab':'textblocks'});
	
	$('.textblockcontainer').each(function(index,elem){
		$(elem).textblockline();
	});
	

	
});	