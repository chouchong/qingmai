
//上傳文件
// var filetypes = ["gif","jpg","png","jpeg"];
function getUploadFilename(sfilename,srcpath,thumbpath,fname){
	if(srcpath!="fail"){
		$("#s_"+sfilename).val(srcpath);
		$("#"+fname).val(srcpath);
		if(fname=="goodsImg"){
			$("#goodsThumbs").val(thumbpath);
		}
		$("#preview_"+sfilename).html("<img width='100%' height='216' src='"+ThinkPHP.ROOT+"/"+thumbpath+"'/>");
	}else{
		$("#s_"+sfilename).val("");
		$("#"+fname).val("");
	}
}

function updfile(filename){
	var filetypes = ["gif","jpg","png","jpeg"];
	var filepath = jQuery("#"+filename).val();
	var patharr = filepath.split("\\");
	var fnames = patharr[patharr.length-1].split(".");
	var ext = (fnames[fnames.length-1]);
		ext = ext.toLocaleLowerCase();	
	var flag = false;
	for(var i=0;i<filetypes.length;i++){
		if(filetypes[i]==ext){
			flag = true;
			break;
		}
	}
	if(flag){
		jQuery("#uploadform_"+filename).submit();
	}else{
		alert("上传文件类型错误 (文档支持格式："+filetypes.join(",")+")");
		jQuery('#uploadform_'+filename)[0].reset();
		return;
	}
}
function updfiles(filename,formname){
	var filetypes = ["gif","jpg","png","jpeg"];
	var patharr=$(".inputstyle"+formname+filename).val().split('\\');
	var fileImgSize = $(".inputstyle"+formname+filename)[0].files[0].size;
	var fnames=patharr[patharr.length-1].split(".");
	var ext=fnames[fnames.length-1];
	    ext = ext.toLocaleLowerCase();
	var flag = false;
	for (var i=0;i<filetypes.length;i++) {
		if (filetypes[i]==ext) {
           flag = true;
           break;
		}
	}
	if(flag){
		if(fileImgSize>1024*1024){
			layer.msg("上传图片不能超过1M");
		}else{
			$("#uploadform_"+formname+filename).submit();
		}
	}else{
		layer.msg("上传文件类型错误 (文档支持格式："+filetypes.join(",")+")");
		jQuery('#uploadform_'+formname)[0].reset();
		return;
	}
}
function getUploadFilenames(savename,savepath,len,type){
	$("#preview_"+type+len).html('<img src="/Upload/'+savepath+'/'+savename+'" width="100%" height="240px"/>');
    $("#pic"+type+len).val('Upload'+'/'+savepath+savename);
}
