var xhr = (function(){
	var modulo = {};

	modulo.init = function(){
		if(window.XMLHttpRequest){
			return new XMLHttpRequest();
		}
	};

	modulo.get = function(url, callback){
		var xmlrequest = modulo.init();
		xmlrequest.open('GET', url);
		xmlrequest.send();

		xmlrequest.onreadystatechange = function(){
			if(xmlrequest.status === 200 && xmlrequest.readyState === 4){
				callback(xmlrequest.responseText);
			}
		};
	};

	return {
		get : modulo.get
	};

})();