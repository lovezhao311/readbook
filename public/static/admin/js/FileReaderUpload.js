function FileReaderUpload(obj,options){
	this.target	=	$(obj);
	$.extend(true , this.options,options||{});
	this.init();
}

FileReaderUpload.prototype	=	{
	options:{
		UploadURL: "", 
		LoadingFile: "",
		ObjAttribut: {
			OldFile: "oFlie",
			FileType: 'type'			
		},
		data:{}
	},
	init: function(){
		this.initElements();
		this.initEvent();
	},
	//初始元素
	initElements: function(){

	},
	initEvent: function(){
		var Obj 	=	this;
		this.target.bind("change", function(){
			var _this	=	$(this);		
			this.readOnly = true;
			Obj.options.data.oldID = _this.data(Obj.ObjAttribut.OldFile);
			Obj.options.data.type   = _this.data(Obj.ObjAttribut.type);
			var reader = new FileReader();
			reader.onload = function(){
				Obj.options.data.result	=	this.result;
				
			}
		}
	}
};
