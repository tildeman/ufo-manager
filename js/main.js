// Xử lý xâu chế biến tại nhà :)
var latin_vietnamese = [
	"à", "á", "ả", "ã", "ạ", "â", "ầ", "ấ", "ẩ", "ẫ", "ậ", "ă", "ằ", "ắ", "ẳ", "ẵ", "ặ",
	"đ", "è", "é", "ẻ", "ẽ", "ẹ", "ê", "ề", "ế", "ể", "ễ", "ệ", "ò", "ó", "ỏ", "õ", "ọ",
	"ô", "ồ", "ố", "ổ", "ỗ", "ộ", "ơ", "ờ", "ớ", "ở", "ỡ", "ợ", "ù", "ú", "ủ", "ũ", "ụ",
	"ư", "ừ", "ứ", "ử", "ữ", "ự", "ì", "í", "ỉ", "ĩ", "ị", "ỳ", "ý", "ỷ", "ỹ", "ỵ",
	"À", "Á", "Ả", "Ã", "Ạ", "Â", "Ầ", "Ấ", "Ẩ", "Ẫ", "Ậ", "Ă", "Ằ", "Ắ", "Ẳ", "Ẵ", "Ặ",
	"Đ", "È", "É", "Ẻ", "Ẽ", "Ẹ", "Ê", "Ề", "Ế", "Ể", "Ễ", "Ệ", "Ò", "Ó", "Ỏ", "Õ", "Ọ",
	"Ô", "Ồ", "Ố", "Ổ", "Ỗ", "Ộ", "Ơ", "Ờ", "Ớ", "Ở", "Ỡ", "Ợ", "Ù", "Ú", "Ủ", "Ũ", "Ụ",
	"Ư", "Ừ", "Ứ", "Ử", "Ữ", "Ự", "Ì", "Í", "Ỉ", "Ĩ", "Ị", "Ỳ", "Ý", "Ỷ", "Ỹ", "Ỵ"
];

var latin_basic = [
	"a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
	"d", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "o", "o", "o", "o", "o",
	"o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u",
	"u", "u", "u", "u", "u", "u", "i", "i", "i", "i", "i", "y", "y", "y", "y", "y",
	"A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A",
	"D", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
	"O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U",
	"U", "U", "U", "U", "U", "U", "I", "I", "I", "I", "I", "Y", "Y", "Y", "Y", "Y"
];

function str_replace(search,replace,subject){
	let result="";
	for (let i=0;i<subject.length;i++){
		if (subject[i]==search) result+=replace;
		else result+=subject[i];
	}
	return result;
}

function modifyuri(){
	let uri=document.getElementById("name").value;
	for (let i=0;i<134;i++){
		uri=str_replace(latin_vietnamese[i],latin_basic[i],uri);
	}
	uri=uri.toLowerCase().replace(/^\s+|\s+$/g, "").replace(/[_|\s]+/g, "-").replace(/[^a-z\u0400-\u04FF0-9-]+/g, "").replace(/[\!\@\#\$\%\^\&\*\(\)\~\`\{\}\[\]\.\,\<\>\/\?\;\'\:\"\=\\\+\|]+/g, "").replace(/[-]+/g, "-").replace(/^-+|-+$/g, "").replace(/[-]+/g, "_");
	document.getElementById("uri").value=uri;
}
