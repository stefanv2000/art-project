var globalTimeout = 200;

function dialogMaxHeight(){
	return $(window).height()-80;
}

function addHtmlEditor(selector){
	$(selector).ckeditor({
		toolbar: [
			{ name: 'groupdefault', items: [ 'Link', 'addImage' , 'Source'] }
		],
		enterMode : CKEDITOR.ENTER_BR,
		shiftEnterMode : CKEDITOR.ENTER_P,
		path:'/js/ckeditor/',
		width:'100%',
		filebrowserUploadUrl: '/ckuploader/uploadmail.php',

	});
}
$.fn.sectionline = function(options){
	var sectionid = 0;

	function initsection(sectionelement){
		sectionid = parseInt(sectionelement.attr('id').substr(17));
		initDelete();
		initChangeStatus();
		initEditSection();
		initMoveSection();
	}

	//link delete section
	function initDelete(){
		$('#deletesectionlink_'+sectionid).click(function(e){
			e.preventDefault();
			$('body').append('<div id="dialogmodal_'+sectionid+'" title="Delete section">Are you sure you want to delete section "'+$('#sectionname_'+sectionid).html()+'"? All the contents and all the subsections will be deleted.<div id="deleteresult" class="deleteresult"></div></div>');
			$("#dialogmodal_"+sectionid).dialog({
				modal : true,
				minWidth:500,
				position: {my:'top',at:'top+60'},
				buttons:{
					'Confirm' : function(){
						$.get('/admin/section/delete/'+sectionid,{
						},function(result){
							if (result['code'] == 'success'){
								$('#deleteresult').html('<div class="alert alert-success">Section deleted</div>');
								setTimeout(function(){
									$('#sectioncontainer_'+sectionid).remove();
									$("#dialogmodal_"+sectionid).dialog('close');
									$('#dialogmodal_'+sectionid).remove();},globalTimeout);
							} else {
								$('#deleteresult').html('<div class="alert alert-danger">An error occurred</div>');
							}
						});
					},
					'Cancel' :	function(){
						$('#dialogmodal_'+sectionid).remove();
					},
				},
			});

		});
	}

	//change status of the section
	function initChangeStatus(){
		$('#changestatuslink_'+sectionid).click(function(e){
			e.preventDefault();
			var status = 0;
			if ($(this).html() == 'Enable section') status=1;
			$.get('/admin/section/changestatus',{
				sectionid:sectionid,
				status:status
			},function(result){
				if (result['code']!='success') return;
				if (status==1) {
					$('#changestatuslink_'+sectionid).html('Disable section');
					$('#sectioncontainer_'+sectionid).removeClass('sectiondisabled');
				}
				else {
					$('#changestatuslink_'+sectionid).html('Enable section');
					$('#sectioncontainer_'+sectionid).addClass('sectiondisabled');
				}
			});
		});
	}
	//edit section
	function initEditSection(){
		$('#editsectionlink_'+sectionid).click(function(e){
			e.preventDefault();
			$('body').append('<div id="dialogmodal_'+sectionid+'" title="Edit section"><div id="dialogcontent_'+sectionid+'"></div></div>');
			console.log($('#tcontainer'));
			$("#dialogmodal_"+sectionid).dialog({
				modal : true,
				minWidth:800,
				maxHeight:dialogMaxHeight(),
				position: {my:'top',at:'top+60'},
				close: function(){
					$('#dialogmodal_'+sectionid).remove();
				},
				show: function(){

				}
			});
			$.get('/admin/section/edit/'+sectionid,{
			},function(data){
				$('#dialogcontent_'+sectionid).html(data);
				console.log('edit section');
				addHtmlEditor("#formeditsection #descriptionsection");
				$('#formeditsection').submit(function(e){
					e.preventDefault();
					$.post('/admin/section/sendedit',
						$('#formeditsection').serialize(),
						function(result){
							if (result['code'] == 'success'){
								$('#editformresult').html('<div class="alert alert-success">'+result['message']+'</div>');
								setTimeout(function(){$("#dialogmodal_"+sectionid).dialog('close');
									$('#dialogmodal_'+sectionid).remove();},globalTimeout);

								$.get('/admin/section/getsectionhtml/'+sectionid,{},
									function(data){
										var elem = $(data);
										$('#sectioncontainer_'+sectionid).replaceWith(elem);
										elem.sectionline();
										$('#subsections').mySortable();
									});

							} else {
								$('#editformresult').html('<div class="alert alert-danger">'+result['message']+'</div>');
							}
						});
				});
			});
		});
	}

	function initMoveSection(){
		var that = this;
		$('#movesectionlink_'+sectionid).click(function(e){
			e.preventDefault();
			$('body').append('<div id="dialogmodal_'+sectionid+'" title="Move section"><div id="dialogcontent_'+sectionid+'"></div></div>');

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
			$.get('/admin/section/sectionslist',{
			},function(data){
				$('#dialogcontent_'+sectionid).html(data);
				$('#formmovesection').submit(function(e){
					e.preventDefault();
					$.post('/admin/section/sendmove',
						{
							sectionid : sectionid,
							newsectionid : $('#newsection').val()
						},
						function(result){
							if (result['code'] == 'success'){
								$('#moveformresult').html('<div class="alert alert-success">'+result['message']+'</div>');
								setTimeout(function(){
									$('#sectioncontainer_'+sectionid).remove();
									$("#dialogmodal_"+sectionid).dialog('close');
									$('#dialogmodal_'+sectionid).remove();},globalTimeout);
							} else {
								$('#moveformresult').html('<div class="alert alert-danger">'+result['message']+'</div>');
							}
						});
				});
			});
		});
	}
	initsection(this);
	return this;
};

$.fn.mySortable = function(options){
	var tab = 'section';
	if (options!=null){
		if ('tab' in options){
			tab = options['tab'];
		}
	}

	//return details as callback url for sort and current container for sortable
	function getTabDetails(tab){
		var details = new Array();
		switch (tab) {
			case 'media':
				details['url'] = '/admin/content/sortcontent';
				break;
			case 'textblocks':
				details['url'] = '/admin/textblock/sorttextblock';
				break;

			default:
				//default is section
				details['url'] = '/admin/section/sortsections';
				break;
		}
		return details;
	}
	function initSortable(sortablelem){
		var details = getTabDetails(tab);
		sortablelem.sortable({
			update: function( event, ui ) {
				$.get(
					details['url'],
					sortablelem.sortable( "serialize" ),
					function(result){
						console.log(result);
					}
				);
			}
		});
	}
	initSortable(this);
	return this;
};


//edit section
function initAddNewSection(parentSection){
	var sectionid = "addnewsection";
	$('#showaddnewsectionform').click(function(e){
		e.preventDefault();
		$('body').append('<div id="dialogmodal_'+sectionid+'" title="Add new section"><div id="dialogcontent_'+sectionid+'"></div></div>');

		$("#dialogmodal_"+sectionid).dialog({
			modal : true,
			minWidth:800,
			maxHeight:dialogMaxHeight(),
			position: {my:'top',at:'top+60'},
			close: function(){
				$('#dialogmodal_'+sectionid).remove();
			},
			show: function(){

			}
		});
		$.get('/admin/section/addform/'+parentSection,{
		},function(data){
			$('#dialogcontent_'+sectionid).html(data);


			addHtmlEditor("#formaddnewsection #descriptionsection");
			$('#formaddnewsection').submit(function(e){
				e.preventDefault();
				$.post('/admin/section/sendadd',
					$('#formaddnewsection').serialize(),
					function(result){

						if (result['code'] == 'success'){
							$('#resultnewsectionform').html('<div class="alert alert-success">'+result['message']+'</div>');
							setTimeout(function(){$("#dialogmodal_"+sectionid).dialog('close');
								$('#dialogmodal_'+sectionid).remove();},globalTimeout);
							$.get('/admin/section/getsectionhtml/'+result['id'],{},
								function(data){
									var elem = $(data);
									$('#subsections').append(elem);
									elem.sectionline();
									$('#subsections').mySortable();
								});
						} else {
							$('#resultnewsectionform').html('<div class="alert alert-danger">'+result['message']+'</div>');
						}


					});
			});
		});
	});
}

$(document).ready(function(){

	initAddNewSection(parentSectionId);
	//slide down/up the form on click
	$('#containernewsectionform').css('display','none');


	//init tabs sections,media,text contents
	$('#tabs').tabs({ active: 1 });

	//init sort list of sections
	$('#subsections').mySortable();

	$('.sectioncontainer').each(function(index,elem){
		$(elem).sectionline();
	});

	addHtmlEditor("#formaddnewsection #descriptionsection");

	$('.nav li a').each(function(index,elem){
		if ($(this).attr('href').indexOf("/admin/section")>=0) $(this).addClass("navlinkactive");
	});

});