var Utils = {
	scaleHeight:function(originalWidth,originalHeight,width){
		if (originalWidth<width) return [originalWidth,originalHeight];
		var ratio = width/originalWidth;
		return [width,originalHeight*ratio];
	},
	/**
	 * 
	 */
	scaleToFill:function(containerSize,originalSize){
		var ratiox = originalSize[0]/containerSize[0];
		var ratioy = originalSize[1]/containerSize[1];
		var returnvalue = {
				size : {width:containerSize[0],
						height:containerSize[1],
						},
				margins : {top:0,
						left:0,
					},				
		};
		
		if (ratiox > ratioy) {//resize width
			returnvalue.size.width = Math.floor(originalSize[0]/ratioy);
		} else { //resize height
			returnvalue.size.height = Math.floor(originalSize[1]/ratiox);
		}
		
		returnvalue.margins.left = (containerSize[0] -returnvalue.size.width)/2;
		returnvalue.margins.top = (containerSize[1] -returnvalue.size.height)/2;
		return returnvalue;
	},
	scaleToFillObject:function(containerSize,originalSize,object){
		var scaled = Utils.scaleToFill(containerSize, originalSize);
		object.css({
			width:scaled.size.width+"px",
			height:scaled.size.height+"px",
			top:scaled.margins.top+"px",
			left:scaled.margins.left+"px",
		});
	},
	
	/**
	 * 
	 */
	scaleToFit:function(containerSize,originalSize){
		var ratiox = originalSize[0]/containerSize[0];
		var ratioy = originalSize[1]/containerSize[1];
		var returnvalue = {
				size : {width:containerSize[0],
						height:containerSize[1],
						},
				margins : {top:0,
						left:0,
					},				
		};
		
		if ((ratiox<1)&&(ratioy<1)) {//don't scale up
			returnvalue.size ={width:originalSize[0],
					height:originalSize[1],
			};
		} else
		
		if (ratiox < ratioy) {//resize width
			returnvalue.size.width = Math.floor(originalSize[0]/ratioy);
		} else { //resize height
			returnvalue.size.height = Math.floor(originalSize[1]/ratiox);
		}
		
		returnvalue.margins.left = (containerSize[0] -returnvalue.size.width)/2;
		returnvalue.margins.top = (containerSize[1] -returnvalue.size.height)/2;
		return returnvalue;
	},
	scaleToFitObject:function(containerSize,originalSize,object){
		var scaled = Utils.scaleToFit(containerSize, originalSize);
		object.css({
			width:scaled.size.width+"px",
			height:scaled.size.height+"px",
			top:scaled.margins.top+"px",
			left:scaled.margins.left+"px",
		});
		return scaled;
	},	
	
	changeTitle: function(title){
		document.title = "Arthur Peterson | "+title;
	},
	trimToWords:function(stringToTrim,length){
		if (!stringToTrim) return stringToTrim;
		var cut= stringToTrim.indexOf(' ', length);
		if(cut== -1) return stringToTrim;
		return stringToTrim.substring(0, cut);
		//trim the string to the maximum length
		var trimmedString = stringToTrim.substr(0, length);

		//re-trim if we are in the middle of a word
		trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")));
		return trimmedString;
	},

};