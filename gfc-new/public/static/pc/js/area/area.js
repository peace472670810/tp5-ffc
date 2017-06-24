// JavaScript Document

function InitArea(ObjProvince , ObjCity , ObjCounty , ObjProvinceArray , ObjCityArray , ObjCountyArray , strProvince , strCity , strCounty)
{
	var thisProvince = document.getElementById(ObjProvince);
	var thisCity = document.getElementById(ObjCity);
    //去掉县级
	//var thisCounty = document.getElementById(ObjCounty);

	thisProvince.options[0] = new Option("请选择" , "");
	thisCity.options[0] = new Option("请选择" , "");
    //去掉县级
	//thisCounty.options[0] = new Option("不限" , "不限");

	for(var i = 0; i < ObjProvinceArray.length; i++)
	{
		thisProvince.options[i+1] = new Option(ObjProvinceArray[i] , ObjProvinceArray[i]);
		if(ObjProvinceArray[i] == strProvince)
			thisProvince.options[i+1].selected = true;
	}

	if(strProvince != "")
	{
		for(i = 0; i < ObjProvinceArray.length; i++)
		{
			if(ObjProvinceArray[i] == strProvince)
			{
				for(var j = 0; j < ObjCityArray[i].length; j++)
				{
					thisCity.options[j + 1] = new Option(ObjCityArray[i][j], ObjCityArray[i][j]);
					if(ObjCityArray[i][j] == strCity)
						thisCity.options[j + 1].selected = true;
				}
			}
		}

	}

//去掉县级
//	if(strCity != "")
//	{
//		for(i = 0; i < ObjCityArray.length; i++)
//		{
//			for(j = 0; j < ObjCityArray[i].length; j++)
//			{
//				if(ObjCityArray[i][j] == strCity)
//				{
//					for(var k = 0; k < ObjCountyArray[i][j].length; k++)
//					{
//						thisCounty.options[k + 1] = new Option(ObjCountyArray[i][j][k], ObjCountyArray[i][j][k]);
//						if(ObjCountyArray[i][j][k] == strCounty)
//							thisCounty.options[k + 1].selected = true;
//					}
//				}
//			}
//		}
//
//	}

}

function FzInitArea(ObjProvince , ObjCity , ObjCounty , ObjProvinceArray , ObjCityArray , ObjCountyArray , strProvince , strCity , strCounty)
{
	var thisProvince = document.getElementById(ObjProvince);
	var thisCity = document.getElementById(ObjCity);
	var thisCounty = document.getElementById(ObjCounty);

	//thisProvince.options[0] = new Option("请选择" , "");
	//thisCity.options[0] = new Option("请选择" , "");
	//thisCounty.options[0] = new Option("不限" , "不限");

	for(var i = 0; i < ObjProvinceArray.length; i++)
	{
		//thisProvince.options[i+1] = new Option(ObjProvinceArray[i] , ObjProvinceArray[i]);
		if(ObjProvinceArray[i] == strProvince)
		{
			thisProvince.options[0] = new Option(ObjProvinceArray[i] , ObjProvinceArray[i]);
			thisProvince.options[0].selected = true;
		}
	}

	if(strProvince != "")
	{
		for(i = 0; i < ObjProvinceArray.length; i++)
		{
			if(ObjProvinceArray[i] == strProvince)
			{
				if(strCity == "")
				{
					thisCity.options[0] = new Option("请选择" , "");
				}
				for(var j = 0; j < ObjCityArray[i].length; j++)
				{
					if(strCity == "")
					{
						thisCity.options[j + 1] = new Option(ObjCityArray[i][j], ObjCityArray[i][j]);
						if(ObjCityArray[i][j] == strCity)
						{
							thisCity.options[j + 1].selected = true;
						}
					}
					else
					{
						if(ObjCityArray[i][j] == strCity)
						{
							thisCity.options[0] = new Option(ObjCityArray[i][j], ObjCityArray[i][j]);
							thisCity.options[0].selected = true;
						}
					}
				}
			}
		}

	}

	if(strCity != "")
	{
		for(i = 0; i < ObjCityArray.length; i++)
		{
			for(j = 0; j < ObjCityArray[i].length; j++)
			{
				if(ObjCityArray[i][j] == strCity)
				{
					if(strCounty == "")
					{
						thisCounty.options[0] = new Option("不限" , "不限");
					}
					for(var k = 0; k < ObjCountyArray[i][j].length; k++)
					{
						if(strCounty == "" || strCounty == "不限")
						{
							thisCounty.options[k + 1] = new Option(ObjCountyArray[i][j][k], ObjCountyArray[i][j][k]);
							if(ObjCountyArray[i][j][k] == strCounty)
							{
								thisCounty.options[k + 1].selected = true;
							}
						}
						else
						{
							if(ObjCountyArray[i][j][k] == strCounty)
							{
								thisCounty.options[0] = new Option(ObjCountyArray[i][j][k], ObjCountyArray[i][j][k]);
								thisCounty.options[0].selected = true;
							}
						}
					}
				}
			}
		}
	}
}

function SelChgCity(ObjCityField , ProvinceValue , ObjProvinceArray , ObjCityArray , ObjCountyField)
{
	var thisCityField = document.getElementById(ObjCityField);
    //去掉县级
	//var thisCountyField = document.getElementById(ObjCountyField);
	for(var i = thisCityField.length; i > 0; i--)
	{
		thisCityField.remove(i);
	}
    //去掉县级
//	for(var i = thisCountyField.length; i > 0; i--)
//	{
//		thisCountyField.remove(i);
//	}
	thisCityField.options[0] = new Option("请选择" , "");
//	thisCountyField.options[0] = new Option("不限" , "不限");
	if(ProvinceValue != "")
	{
		for(i = 0; i < ObjProvinceArray.length; i++)
		{
			if(ObjProvinceArray[i] == ProvinceValue)
			{
				for(var j = 0; j < ObjCityArray[i].length; j++)
				{
					thisCityField.options[j + 1] = new Option(ObjCityArray[i][j], ObjCityArray[i][j]);
				}
			}
		}

	}
}

//去掉县级
//function SelChgCounty(ObjCountyField , CityValue , ObjCityArray , ObjCountyArray)
//{
//	var thisCountyField = document.getElementById(ObjCountyField);
//	for(var i = thisCountyField.length; i > 0; i--)
//	{
//		thisCountyField.remove(i);
//	}
//	thisCountyField.options[0] = new Option("不限" , "不限");
//	if(CityValue != "")
//	{
//		for(i = 0; i < ObjCityArray.length; i++)
//		{
//			for(var j = 0; j < ObjCityArray[i].length; j++)
//			{
//				if(ObjCityArray[i][j] == CityValue)
//				{
//					for(var k = 0; k < ObjCountyArray[i][j].length; k++)
//					{
//						thisCountyField.options[k + 1] = new Option(ObjCountyArray[i][j][k], ObjCountyArray[i][j][k]);
//					}
//				}
//			}
//		}
//
//	}
//}

var arrProvince = new Array();
var arrCity = new Array();
var arrCountry = new Array();

var i = 0;
var j = 0;
var k = 0;

arrProvince[i] = "深圳";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "罗湖区";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "蔡屋围";
		arrCountry[i][j][k++] = "国贸";
		arrCountry[i][j][k++] = "火车站";
		arrCountry[i][j][k++] = "人民南";
		arrCountry[i][j][k++] = "东门";
		arrCountry[i][j][k++] = "洪湖";
		arrCountry[i][j][k++] = "田贝";
		arrCountry[i][j][k++] = "罗湖区委";
		arrCountry[i][j][k++] = "文锦渡";
		arrCountry[i][j][k++] = "黄贝岭";
		arrCountry[i][j][k++] = "留医部";
		arrCountry[i][j][k++] = "翠竹";
		arrCountry[i][j][k++] = "东湖";
		arrCountry[i][j][k++] = "罗湖区内";

	j++;
	arrCity[i][j] = "福田区";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "区内";

	j++;
	arrCity[i][j] = "盐田区";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "盐田区内";

	j++;
	arrCity[i][j] = "南山区";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "南油";
		arrCountry[i][j][k++] = "前海";
		arrCountry[i][j][k++] = "南头";
		arrCountry[i][j][k++] = "后海";
		arrCountry[i][j][k++] = "科技园";
		arrCountry[i][j][k++] = "白石洲";
		arrCountry[i][j][k++] = "桃源村";
		arrCountry[i][j][k++] = "华侨城";
		arrCountry[i][j][k++] = "南山区政府";
		arrCountry[i][j][k++] = "南新路口";
		arrCountry[i][j][k++] = "大冲";
		arrCountry[i][j][k++] = "桂庙路口";
		arrCountry[i][j][k++] = "海王大厦";
		arrCountry[i][j][k++] = "西丽";
		arrCountry[i][j][k++] = "南山医院";
		arrCountry[i][j][k++] = "深大北门";
		arrCountry[i][j][k++] = "蛇口海上世界";
		arrCountry[i][j][k++] = "南山周边";
		arrCountry[i][j][k++] = "区内";

	j++;
	arrCity[i][j] = "龙岗区";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "区内";

	j++;
	arrCity[i][j] = "宝安区";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "区内";

	j++;
	arrCity[i][j] = "光明新区";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "区内";

	j++;
	arrCity[i][j] = "市内";
	arrCountry[i][j] = new Array();

		k = 0;

	j++;

i++;
arrProvince[i] = "安徽";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "安庆";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安庆市";
		arrCountry[i][j][k++] = "怀宁县";
		arrCountry[i][j][k++] = "潜山县";
		arrCountry[i][j][k++] = "宿松县";
		arrCountry[i][j][k++] = "太湖县";
		arrCountry[i][j][k++] = "桐城市";
		arrCountry[i][j][k++] = "望江县";
		arrCountry[i][j][k++] = "岳西县";
		arrCountry[i][j][k++] = "枞阳县";

	j++;
	arrCity[i][j] = "蚌埠";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "蚌埠市";
		arrCountry[i][j][k++] = "固镇县";
		arrCountry[i][j][k++] = "怀远县";
		arrCountry[i][j][k++] = "五河县";

	j++;
	arrCity[i][j] = "巢湖";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "巢湖市";
		arrCountry[i][j][k++] = "含山县";
		arrCountry[i][j][k++] = "和县";
		arrCountry[i][j][k++] = "庐江县";
		arrCountry[i][j][k++] = "无为县";

	j++;
	arrCity[i][j] = "池州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "池州市";
		arrCountry[i][j][k++] = "东至县";
		arrCountry[i][j][k++] = "青阳县";
		arrCountry[i][j][k++] = "石台县";

	j++;
	arrCity[i][j] = "滁州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "滁州市";
		arrCountry[i][j][k++] = "定远县";
		arrCountry[i][j][k++] = "凤阳县";
		arrCountry[i][j][k++] = "来安县";
		arrCountry[i][j][k++] = "明光市";
		arrCountry[i][j][k++] = "全椒县";
		arrCountry[i][j][k++] = "天长市";

	j++;
	arrCity[i][j] = "阜阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阜南县";
		arrCountry[i][j][k++] = "阜阳市";
		arrCountry[i][j][k++] = "界首市";
		arrCountry[i][j][k++] = "临泉县";
		arrCountry[i][j][k++] = "太和县";
		arrCountry[i][j][k++] = "颖上县";

	j++;
	arrCity[i][j] = "合肥";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长丰县";
		arrCountry[i][j][k++] = "肥东县";
		arrCountry[i][j][k++] = "肥西县";
		arrCountry[i][j][k++] = "合肥市";

	j++;
	arrCity[i][j] = "淮北";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "淮北市";
		arrCountry[i][j][k++] = "濉溪县";

	j++;
	arrCity[i][j] = "淮南";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "凤台县";
		arrCountry[i][j][k++] = "淮南市";

	j++;
	arrCity[i][j] = "黄山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "黄山市";
		arrCountry[i][j][k++] = "祁门县";
		arrCountry[i][j][k++] = "休宁县";
		arrCountry[i][j][k++] = "歙县";
		arrCountry[i][j][k++] = "黟县";

	j++;
	arrCity[i][j] = "六安";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "霍邱县";
		arrCountry[i][j][k++] = "霍山县";
		arrCountry[i][j][k++] = "金寨县";
		arrCountry[i][j][k++] = "六安市";
		arrCountry[i][j][k++] = "寿县";
		arrCountry[i][j][k++] = "舒城县";

	j++;
	arrCity[i][j] = "马鞍山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "当涂县";
		arrCountry[i][j][k++] = "马鞍山市";

	j++;
	arrCity[i][j] = "宿州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "灵璧县";
		arrCountry[i][j][k++] = "宿州市";
		arrCountry[i][j][k++] = "萧县";
		arrCountry[i][j][k++] = "泗县";
		arrCountry[i][j][k++] = "砀山县";

	j++;
	arrCity[i][j] = "铜陵";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "铜陵市";
		arrCountry[i][j][k++] = "铜陵县";

	j++;
	arrCity[i][j] = "芜湖";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "繁昌县";
		arrCountry[i][j][k++] = "南陵县";
		arrCountry[i][j][k++] = "芜湖市";
		arrCountry[i][j][k++] = "芜湖县";

	j++;
	arrCity[i][j] = "宣城";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "广德县";
		arrCountry[i][j][k++] = "绩溪县";
		arrCountry[i][j][k++] = "郎溪县";
		arrCountry[i][j][k++] = "宁国市";
		arrCountry[i][j][k++] = "宣城市";
		arrCountry[i][j][k++] = "泾县";
		arrCountry[i][j][k++] = "旌德县";

	j++;
	arrCity[i][j] = "亳州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "利辛县";
		arrCountry[i][j][k++] = "蒙城县";
		arrCountry[i][j][k++] = "涡阳县";
		arrCountry[i][j][k++] = "亳州市";

	j++;

i++;
arrProvince[i] = "北京";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "北京";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "北京市";
		arrCountry[i][j][k++] = "密云县";
		arrCountry[i][j][k++] = "延庆县";
		arrCountry[i][j][k++] = "大兴县";
		arrCountry[i][j][k++] = "顺义县";
		arrCountry[i][j][k++] = "怀柔县";
		arrCountry[i][j][k++] = "平谷县";

	j++;

i++;
arrProvince[i] = "广东";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "深圳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "深圳市";

	j++;
	arrCity[i][j] = "潮州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "潮安县";
		arrCountry[i][j][k++] = "潮州市";
		arrCountry[i][j][k++] = "饶平县";

	j++;
	arrCity[i][j] = "东莞";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东莞市";

	j++;
	arrCity[i][j] = "佛山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "佛山市";

	j++;
	arrCity[i][j] = "广州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "从化市";
		arrCountry[i][j][k++] = "广州市";
		arrCountry[i][j][k++] = "增城市";

	j++;
	arrCity[i][j] = "河源";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东源县";
		arrCountry[i][j][k++] = "和平县";
		arrCountry[i][j][k++] = "河源市";
		arrCountry[i][j][k++] = "连平县";
		arrCountry[i][j][k++] = "龙川县";
		arrCountry[i][j][k++] = "紫金县";

	j++;
	arrCity[i][j] = "惠州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "博罗县";
		arrCountry[i][j][k++] = "惠东县";
		arrCountry[i][j][k++] = "惠州市";
		arrCountry[i][j][k++] = "龙门县";

	j++;
	arrCity[i][j] = "江门";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "恩平市";
		arrCountry[i][j][k++] = "鹤山市";
		arrCountry[i][j][k++] = "江门市";
		arrCountry[i][j][k++] = "开平市";
		arrCountry[i][j][k++] = "台山市";

	j++;
	arrCity[i][j] = "揭阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "惠来县";
		arrCountry[i][j][k++] = "揭东县";
		arrCountry[i][j][k++] = "揭西县";
		arrCountry[i][j][k++] = "揭阳市";
		arrCountry[i][j][k++] = "普宁市";

	j++;
	arrCity[i][j] = "茂名";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "电白县";
		arrCountry[i][j][k++] = "高州市";
		arrCountry[i][j][k++] = "化州市";
		arrCountry[i][j][k++] = "茂名市";
		arrCountry[i][j][k++] = "信宜市";

	j++;
	arrCity[i][j] = "梅州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大埔县";
		arrCountry[i][j][k++] = "丰顺县";
		arrCountry[i][j][k++] = "蕉岭县";
		arrCountry[i][j][k++] = "梅县";
		arrCountry[i][j][k++] = "梅州市";
		arrCountry[i][j][k++] = "平远县";
		arrCountry[i][j][k++] = "五华县";
		arrCountry[i][j][k++] = "兴宁市";

	j++;
	arrCity[i][j] = "清远";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "佛冈县";
		arrCountry[i][j][k++] = "连南瑶族自治县";
		arrCountry[i][j][k++] = "连山壮族瑶族自治县";
		arrCountry[i][j][k++] = "连州市";
		arrCountry[i][j][k++] = "清新县";
		arrCountry[i][j][k++] = "清远市";
		arrCountry[i][j][k++] = "阳山县";
		arrCountry[i][j][k++] = "英德市";

	j++;
	arrCity[i][j] = "汕头";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "南澳县";
		arrCountry[i][j][k++] = "汕头市";

	j++;
	arrCity[i][j] = "汕尾";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "海丰县";
		arrCountry[i][j][k++] = "陆丰市";
		arrCountry[i][j][k++] = "陆河县";
		arrCountry[i][j][k++] = "汕尾市";

	j++;
	arrCity[i][j] = "韶关";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "乐昌市";
		arrCountry[i][j][k++] = "南雄市";
		arrCountry[i][j][k++] = "曲江县";
		arrCountry[i][j][k++] = "仁化县";
		arrCountry[i][j][k++] = "乳源瑶族自治县";
		arrCountry[i][j][k++] = "韶关市";
		arrCountry[i][j][k++] = "始兴县";
		arrCountry[i][j][k++] = "翁源县";
		arrCountry[i][j][k++] = "新丰县";

	j++;
	arrCity[i][j] = "阳江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阳春市";
		arrCountry[i][j][k++] = "阳东县";
		arrCountry[i][j][k++] = "阳江市";
		arrCountry[i][j][k++] = "阳西县";

	j++;
	arrCity[i][j] = "云浮";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "罗定市";
		arrCountry[i][j][k++] = "新兴县";
		arrCountry[i][j][k++] = "郁南县";
		arrCountry[i][j][k++] = "云安县";
		arrCountry[i][j][k++] = "云浮市";

	j++;
	arrCity[i][j] = "湛江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "雷州市";
		arrCountry[i][j][k++] = "廉江市";
		arrCountry[i][j][k++] = "遂溪县";
		arrCountry[i][j][k++] = "吴川市";
		arrCountry[i][j][k++] = "徐闻县";
		arrCountry[i][j][k++] = "湛江市";

	j++;
	arrCity[i][j] = "肇庆";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "德庆县";
		arrCountry[i][j][k++] = "封开县";
		arrCountry[i][j][k++] = "高要市";
		arrCountry[i][j][k++] = "广宁县";
		arrCountry[i][j][k++] = "怀集县";
		arrCountry[i][j][k++] = "四会市";
		arrCountry[i][j][k++] = "肇庆市";

	j++;
	arrCity[i][j] = "中山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "中山市";

	j++;
	arrCity[i][j] = "珠海";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "珠海市";

	j++;

i++;
arrProvince[i] = "云南";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "昆明";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "昆明市区";
		arrCountry[i][j][k++] = "五华区";
		arrCountry[i][j][k++] = "盘龙区";
		arrCountry[i][j][k++] = "官渡区";
		arrCountry[i][j][k++] = "西山区";
		arrCountry[i][j][k++] = "东川区";
		arrCountry[i][j][k++] = "呈贡县";
		arrCountry[i][j][k++] = "晋宁县";
		arrCountry[i][j][k++] = "富民县";
		arrCountry[i][j][k++] = "宜良县";
		arrCountry[i][j][k++] = "石林县";
		arrCountry[i][j][k++] = "嵩明县";
		arrCountry[i][j][k++] = "禄劝县";
		arrCountry[i][j][k++] = "寻甸县";
		arrCountry[i][j][k++] = "安宁市";

	j++;
	arrCity[i][j] = "曲靖";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "富源县";
		arrCountry[i][j][k++] = "会泽县";
		arrCountry[i][j][k++] = "陆良县";
		arrCountry[i][j][k++] = "罗平县";
		arrCountry[i][j][k++] = "马龙县";
		arrCountry[i][j][k++] = "曲靖市";
		arrCountry[i][j][k++] = "师宗县";
		arrCountry[i][j][k++] = "宣威市";
		arrCountry[i][j][k++] = "沾益县";

	j++;
	arrCity[i][j] = "大理";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宾川县";
		arrCountry[i][j][k++] = "大理市";
		arrCountry[i][j][k++] = "洱源县";
		arrCountry[i][j][k++] = "鹤庆县";
		arrCountry[i][j][k++] = "剑川县";
		arrCountry[i][j][k++] = "弥渡县";
		arrCountry[i][j][k++] = "南涧彝族自治县";
		arrCountry[i][j][k++] = "巍山彝族回族自治县";
		arrCountry[i][j][k++] = "祥云县";
		arrCountry[i][j][k++] = "漾濞彝族自治县";
		arrCountry[i][j][k++] = "永平县";
		arrCountry[i][j][k++] = "云龙县";

	j++;
	arrCity[i][j] = "保山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "保山市";
		arrCountry[i][j][k++] = "昌宁县";
		arrCountry[i][j][k++] = "龙陵县";
		arrCountry[i][j][k++] = "施甸县";
		arrCountry[i][j][k++] = "腾冲县";

	j++;
	arrCity[i][j] = "玉溪";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "澄江县";
		arrCountry[i][j][k++] = "峨山彝族自治县";
		arrCountry[i][j][k++] = "华宁县";
		arrCountry[i][j][k++] = "江川县";
		arrCountry[i][j][k++] = "通海县";
		arrCountry[i][j][k++] = "新平彝族傣族自治县";
		arrCountry[i][j][k++] = "易门县";
		arrCountry[i][j][k++] = "玉溪市";
		arrCountry[i][j][k++] = "元江哈尼族彝族傣族自治县";

	j++;
	arrCity[i][j] = "楚雄";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "楚雄市";
		arrCountry[i][j][k++] = "大姚县";
		arrCountry[i][j][k++] = "禄丰县";
		arrCountry[i][j][k++] = "牟定县";
		arrCountry[i][j][k++] = "南华县";
		arrCountry[i][j][k++] = "双柏县";
		arrCountry[i][j][k++] = "武定县";
		arrCountry[i][j][k++] = "姚安县";
		arrCountry[i][j][k++] = "永仁县";
		arrCountry[i][j][k++] = "元谋县";

	j++;
	arrCity[i][j] = "丽江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "华坪县";
		arrCountry[i][j][k++] = "丽江市";
		arrCountry[i][j][k++] = "宁蒗彝族自治县";
		arrCountry[i][j][k++] = "永胜县";
		arrCountry[i][j][k++] = "玉龙纳西族自治县";

	j++;
	arrCity[i][j] = "德宏";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "梁河县";
		arrCountry[i][j][k++] = "陇川县";
		arrCountry[i][j][k++] = "潞西市";
		arrCountry[i][j][k++] = "瑞丽市";
		arrCountry[i][j][k++] = "盈江县";

	j++;
	arrCity[i][j] = "迪庆";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "德钦县";
		arrCountry[i][j][k++] = "维西傈僳族自治县";
		arrCountry[i][j][k++] = "香格里拉县";

	j++;
	arrCity[i][j] = "红河";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "个旧市";
		arrCountry[i][j][k++] = "河口瑶族自治县";
		arrCountry[i][j][k++] = "红河县";
		arrCountry[i][j][k++] = "建水县";
		arrCountry[i][j][k++] = "金平苗族瑶族傣族自治县";
		arrCountry[i][j][k++] = "开远市";
		arrCountry[i][j][k++] = "绿春县";
		arrCountry[i][j][k++] = "蒙自县";
		arrCountry[i][j][k++] = "弥勒县";
		arrCountry[i][j][k++] = "屏边苗族自治县";
		arrCountry[i][j][k++] = "石屏县";
		arrCountry[i][j][k++] = "元阳县";
		arrCountry[i][j][k++] = "泸西县";

	j++;
	arrCity[i][j] = "临沧";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "沧源佤族自治县";
		arrCountry[i][j][k++] = "凤庆县";
		arrCountry[i][j][k++] = "耿马傣族佤族治县";
		arrCountry[i][j][k++] = "临沧县";
		arrCountry[i][j][k++] = "双江拉祜族佤族布朗族傣族自治县";
		arrCountry[i][j][k++] = "永德县";
		arrCountry[i][j][k++] = "云县";
		arrCountry[i][j][k++] = "镇康县";

	j++;
	arrCity[i][j] = "昭通";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大关县";
		arrCountry[i][j][k++] = "鲁甸县";
		arrCountry[i][j][k++] = "巧家县";
		arrCountry[i][j][k++] = "水富县";
		arrCountry[i][j][k++] = "绥江县";
		arrCountry[i][j][k++] = "威信县";
		arrCountry[i][j][k++] = "盐津县";
		arrCountry[i][j][k++] = "彝良县";
		arrCountry[i][j][k++] = "永善县";
		arrCountry[i][j][k++] = "昭通市";
		arrCountry[i][j][k++] = "镇雄县";

	j++;
	arrCity[i][j] = "怒江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "福贡县";
		arrCountry[i][j][k++] = "贡山独龙族怒族自治县";
		arrCountry[i][j][k++] = "兰坪白族普米族自治县";
		arrCountry[i][j][k++] = "泸水县";

	j++;
	arrCity[i][j] = "思茅";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "江城哈尼族彝族自治县";
		arrCountry[i][j][k++] = "景东彝族自治县";
		arrCountry[i][j][k++] = "景谷彝族傣族自治县";
		arrCountry[i][j][k++] = "澜沧拉祜族自治县";
		arrCountry[i][j][k++] = "孟连傣族拉祜族佤族自治县";
		arrCountry[i][j][k++] = "墨江哈尼族自治县";
		arrCountry[i][j][k++] = "普洱哈尼族彝族自治县";
		arrCountry[i][j][k++] = "思茅市";
		arrCountry[i][j][k++] = "西盟佤族自治县";
		arrCountry[i][j][k++] = "镇沅彝族哈尼族拉祜族自治县";

	j++;
	arrCity[i][j] = "文山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "富宁县";
		arrCountry[i][j][k++] = "广南县";
		arrCountry[i][j][k++] = "麻栗坡县";
		arrCountry[i][j][k++] = "马关县";
		arrCountry[i][j][k++] = "丘北县";
		arrCountry[i][j][k++] = "文山县";
		arrCountry[i][j][k++] = "西畴县";
		arrCountry[i][j][k++] = "砚山县";

	j++;
	arrCity[i][j] = "西双版纳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "景洪市";
		arrCountry[i][j][k++] = "勐海县";
		arrCountry[i][j][k++] = "勐腊县";

	j++;

i++;
arrProvince[i] = "福建";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "福州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长乐市";
		arrCountry[i][j][k++] = "福清市";
		arrCountry[i][j][k++] = "福州市";
		arrCountry[i][j][k++] = "连江县";
		arrCountry[i][j][k++] = "罗源县";
		arrCountry[i][j][k++] = "闽侯县";
		arrCountry[i][j][k++] = "闽清县";
		arrCountry[i][j][k++] = "平潭县";
		arrCountry[i][j][k++] = "永泰县";

	j++;
	arrCity[i][j] = "龙岩";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长汀县";
		arrCountry[i][j][k++] = "连城县";
		arrCountry[i][j][k++] = "龙岩市";
		arrCountry[i][j][k++] = "上杭县";
		arrCountry[i][j][k++] = "武平县";
		arrCountry[i][j][k++] = "永定县";
		arrCountry[i][j][k++] = "漳平市";

	j++;
	arrCity[i][j] = "南平";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "光泽县";
		arrCountry[i][j][k++] = "建阳市";
		arrCountry[i][j][k++] = "建瓯市";
		arrCountry[i][j][k++] = "南平市";
		arrCountry[i][j][k++] = "浦城县";
		arrCountry[i][j][k++] = "邵武市";
		arrCountry[i][j][k++] = "顺昌县";
		arrCountry[i][j][k++] = "松溪县";
		arrCountry[i][j][k++] = "武夷山市";
		arrCountry[i][j][k++] = "政和县";

	j++;
	arrCity[i][j] = "宁德";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "福安市";
		arrCountry[i][j][k++] = "福鼎市";
		arrCountry[i][j][k++] = "古田县";
		arrCountry[i][j][k++] = "宁德市";
		arrCountry[i][j][k++] = "屏南县";
		arrCountry[i][j][k++] = "寿宁县";
		arrCountry[i][j][k++] = "霞浦县";
		arrCountry[i][j][k++] = "周宁县";
		arrCountry[i][j][k++] = "柘荣县";

	j++;
	arrCity[i][j] = "莆田";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "莆田市";
		arrCountry[i][j][k++] = "仙游县";

	j++;
	arrCity[i][j] = "泉州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安溪县";
		arrCountry[i][j][k++] = "德化县";
		arrCountry[i][j][k++] = "惠安县";
		arrCountry[i][j][k++] = "金门县";
		arrCountry[i][j][k++] = "晋江市";
		arrCountry[i][j][k++] = "南安市";
		arrCountry[i][j][k++] = "泉州市";
		arrCountry[i][j][k++] = "石狮市";
		arrCountry[i][j][k++] = "永春县";

	j++;
	arrCity[i][j] = "三明";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大田县";
		arrCountry[i][j][k++] = "建宁县";
		arrCountry[i][j][k++] = "将乐县";
		arrCountry[i][j][k++] = "明溪县";
		arrCountry[i][j][k++] = "宁化县";
		arrCountry[i][j][k++] = "清流县";
		arrCountry[i][j][k++] = "三明市";
		arrCountry[i][j][k++] = "沙县";
		arrCountry[i][j][k++] = "泰宁县";
		arrCountry[i][j][k++] = "永安市";
		arrCountry[i][j][k++] = "尤溪县";

	j++;
	arrCity[i][j] = "厦门";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "厦门市";

	j++;
	arrCity[i][j] = "漳州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长泰县";
		arrCountry[i][j][k++] = "东山县";
		arrCountry[i][j][k++] = "华安县";
		arrCountry[i][j][k++] = "龙海市";
		arrCountry[i][j][k++] = "南靖县";
		arrCountry[i][j][k++] = "平和县";
		arrCountry[i][j][k++] = "云霄县";
		arrCountry[i][j][k++] = "漳浦县";
		arrCountry[i][j][k++] = "漳州市";
		arrCountry[i][j][k++] = "诏安县";

	j++;

i++;
arrProvince[i] = "甘肃";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "白银";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "白银市";
		arrCountry[i][j][k++] = "会宁县";
		arrCountry[i][j][k++] = "景泰县";
		arrCountry[i][j][k++] = "靖远县";

	j++;
	arrCity[i][j] = "定西";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "定西市";
		arrCountry[i][j][k++] = "临洮县";
		arrCountry[i][j][k++] = "陇西县";
		arrCountry[i][j][k++] = "通渭县";
		arrCountry[i][j][k++] = "渭源县";
		arrCountry[i][j][k++] = "漳县";
		arrCountry[i][j][k++] = "岷县";

	j++;
	arrCity[i][j] = "甘南藏族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "迭部县";
		arrCountry[i][j][k++] = "合作市";
		arrCountry[i][j][k++] = "临潭县";
		arrCountry[i][j][k++] = "碌曲县";
		arrCountry[i][j][k++] = "玛曲县";
		arrCountry[i][j][k++] = "夏河县";
		arrCountry[i][j][k++] = "舟曲县";
		arrCountry[i][j][k++] = "卓尼县";

	j++;
	arrCity[i][j] = "嘉峪关";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "嘉峪关市";

	j++;
	arrCity[i][j] = "金昌";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "金昌市";
		arrCountry[i][j][k++] = "永昌县";

	j++;
	arrCity[i][j] = "酒泉";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿克塞哈萨克族自治县";
		arrCountry[i][j][k++] = "安西县";
		arrCountry[i][j][k++] = "敦煌市";
		arrCountry[i][j][k++] = "金塔县";
		arrCountry[i][j][k++] = "酒泉市";
		arrCountry[i][j][k++] = "肃北蒙古族自治县";
		arrCountry[i][j][k++] = "玉门市";

	j++;
	arrCity[i][j] = "兰州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "皋兰县";
		arrCountry[i][j][k++] = "兰州市";
		arrCountry[i][j][k++] = "永登县";
		arrCountry[i][j][k++] = "榆中县";

	j++;
	arrCity[i][j] = "临夏回族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东乡族自治县";
		arrCountry[i][j][k++] = "广河县";
		arrCountry[i][j][k++] = "和政县";
		arrCountry[i][j][k++] = "积石山保安族东乡族撒拉族自治县";
		arrCountry[i][j][k++] = "康乐县";
		arrCountry[i][j][k++] = "临夏市";
		arrCountry[i][j][k++] = "临夏县";
		arrCountry[i][j][k++] = "永靖县";

	j++;
	arrCity[i][j] = "陇南";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "成县";
		arrCountry[i][j][k++] = "徽县";
		arrCountry[i][j][k++] = "康县";
		arrCountry[i][j][k++] = "礼县";
		arrCountry[i][j][k++] = "两当县";
		arrCountry[i][j][k++] = "文县";
		arrCountry[i][j][k++] = "武都县";
		arrCountry[i][j][k++] = "西和县";
		arrCountry[i][j][k++] = "宕昌县";

	j++;
	arrCity[i][j] = "平凉";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "崇信县";
		arrCountry[i][j][k++] = "华亭县";
		arrCountry[i][j][k++] = "静宁县";
		arrCountry[i][j][k++] = "灵台县";
		arrCountry[i][j][k++] = "平凉市";
		arrCountry[i][j][k++] = "庄浪县";
		arrCountry[i][j][k++] = "泾川县";

	j++;
	arrCity[i][j] = "庆阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "合水县";
		arrCountry[i][j][k++] = "华池县";
		arrCountry[i][j][k++] = "环县";
		arrCountry[i][j][k++] = "宁县";
		arrCountry[i][j][k++] = "庆城县";
		arrCountry[i][j][k++] = "庆阳市";
		arrCountry[i][j][k++] = "镇原县";
		arrCountry[i][j][k++] = "正宁县";

	j++;
	arrCity[i][j] = "天水";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "甘谷县";
		arrCountry[i][j][k++] = "秦安县";
		arrCountry[i][j][k++] = "清水县";
		arrCountry[i][j][k++] = "天水市";
		arrCountry[i][j][k++] = "武山县";
		arrCountry[i][j][k++] = "张家川回族自治县";

	j++;
	arrCity[i][j] = "武威";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "古浪县";
		arrCountry[i][j][k++] = "民勤县";
		arrCountry[i][j][k++] = "天祝藏族自治县";
		arrCountry[i][j][k++] = "武威市";

	j++;
	arrCity[i][j] = "张掖";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "高台县";
		arrCountry[i][j][k++] = "临泽县";
		arrCountry[i][j][k++] = "民乐县";
		arrCountry[i][j][k++] = "山丹县";
		arrCountry[i][j][k++] = "肃南裕固族自治县";
		arrCountry[i][j][k++] = "张掖市";

	j++;

i++;
arrProvince[i] = "广西";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "南宁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宾阳县";
		arrCountry[i][j][k++] = "横县";
		arrCountry[i][j][k++] = "隆安县";
		arrCountry[i][j][k++] = "马山县";
		arrCountry[i][j][k++] = "南宁市";
		arrCountry[i][j][k++] = "上林县";
		arrCountry[i][j][k++] = "武鸣县";
		arrCountry[i][j][k++] = "邕宁县";

	j++;
	arrCity[i][j] = "玉林";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "北流市";
		arrCountry[i][j][k++] = "博白县";
		arrCountry[i][j][k++] = "陆川县";
		arrCountry[i][j][k++] = "容县";
		arrCountry[i][j][k++] = "兴业县";
		arrCountry[i][j][k++] = "玉林市";

	j++;
	arrCity[i][j] = "百色";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "百色市";
		arrCountry[i][j][k++] = "德保县";
		arrCountry[i][j][k++] = "靖西县";
		arrCountry[i][j][k++] = "乐业县";
		arrCountry[i][j][k++] = "凌云县";
		arrCountry[i][j][k++] = "隆林各族自治县";
		arrCountry[i][j][k++] = "那坡县";
		arrCountry[i][j][k++] = "平果县";
		arrCountry[i][j][k++] = "田东县";
		arrCountry[i][j][k++] = "田林县";
		arrCountry[i][j][k++] = "田阳县";
		arrCountry[i][j][k++] = "西林县";

	j++;
	arrCity[i][j] = "北海";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "北海市";
		arrCountry[i][j][k++] = "合浦县";

	j++;
	arrCity[i][j] = "崇左";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "崇左市";
		arrCountry[i][j][k++] = "大新县";
		arrCountry[i][j][k++] = "扶绥县";
		arrCountry[i][j][k++] = "龙州县";
		arrCountry[i][j][k++] = "宁明县";
		arrCountry[i][j][k++] = "凭祥市";
		arrCountry[i][j][k++] = "天等县";

	j++;
	arrCity[i][j] = "防城港";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东兴市";
		arrCountry[i][j][k++] = "防城港市";
		arrCountry[i][j][k++] = "上思县";

	j++;
	arrCity[i][j] = "桂林";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "恭城瑶族自治县";
		arrCountry[i][j][k++] = "灌阳县";
		arrCountry[i][j][k++] = "桂林市";
		arrCountry[i][j][k++] = "荔浦县";
		arrCountry[i][j][k++] = "临桂县";
		arrCountry[i][j][k++] = "灵川县";
		arrCountry[i][j][k++] = "龙胜各族自治县";
		arrCountry[i][j][k++] = "平乐县";
		arrCountry[i][j][k++] = "全州县";
		arrCountry[i][j][k++] = "兴安县";
		arrCountry[i][j][k++] = "阳朔县";
		arrCountry[i][j][k++] = "永福县";
		arrCountry[i][j][k++] = "资源县";

	j++;
	arrCity[i][j] = "贵港";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "桂平市";
		arrCountry[i][j][k++] = "贵港市";
		arrCountry[i][j][k++] = "平南县";

	j++;
	arrCity[i][j] = "河池";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "巴马瑶族自治县";
		arrCountry[i][j][k++] = "大化瑶族自治县";
		arrCountry[i][j][k++] = "东兰县";
		arrCountry[i][j][k++] = "都安瑶族自治县";
		arrCountry[i][j][k++] = "凤山县";
		arrCountry[i][j][k++] = "河池市";
		arrCountry[i][j][k++] = "环江毛南族自治县";
		arrCountry[i][j][k++] = "罗城仡佬族自治县";
		arrCountry[i][j][k++] = "南丹县";
		arrCountry[i][j][k++] = "天峨县";
		arrCountry[i][j][k++] = "宜州市";

	j++;
	arrCity[i][j] = "贺州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "富川瑶族自治县";
		arrCountry[i][j][k++] = "贺州市";
		arrCountry[i][j][k++] = "昭平县";
		arrCountry[i][j][k++] = "钟山县";

	j++;
	arrCity[i][j] = "来宾";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "合山市";
		arrCountry[i][j][k++] = "金秀瑶族自治县";
		arrCountry[i][j][k++] = "来宾市";
		arrCountry[i][j][k++] = "武宣县";
		arrCountry[i][j][k++] = "象州县";
		arrCountry[i][j][k++] = "忻城县";

	j++;
	arrCity[i][j] = "柳州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "柳城县";
		arrCountry[i][j][k++] = "柳江县";
		arrCountry[i][j][k++] = "柳州市";
		arrCountry[i][j][k++] = "鹿寨县";
		arrCountry[i][j][k++] = "融安县";
		arrCountry[i][j][k++] = "融水苗族自治县";
		arrCountry[i][j][k++] = "三江侗族自治县";

	j++;
	arrCity[i][j] = "钦州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "灵山县";
		arrCountry[i][j][k++] = "浦北县";
		arrCountry[i][j][k++] = "钦州市";

	j++;
	arrCity[i][j] = "梧州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "苍梧县";
		arrCountry[i][j][k++] = "蒙山县";
		arrCountry[i][j][k++] = "藤县";
		arrCountry[i][j][k++] = "梧州市";
		arrCountry[i][j][k++] = "岑溪市";

	j++;

i++;
arrProvince[i] = "贵州";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "安顺";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安顺市";
		arrCountry[i][j][k++] = "关岭布依族苗族自治县";
		arrCountry[i][j][k++] = "平坝县";
		arrCountry[i][j][k++] = "普定县";
		arrCountry[i][j][k++] = "镇宁布依族苗族自治县";
		arrCountry[i][j][k++] = "紫云苗族布依族自治县";

	j++;
	arrCity[i][j] = "毕节";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "毕节市";
		arrCountry[i][j][k++] = "大方县";
		arrCountry[i][j][k++] = "赫章县";
		arrCountry[i][j][k++] = "金沙县";
		arrCountry[i][j][k++] = "纳雍县";
		arrCountry[i][j][k++] = "黔西县";
		arrCountry[i][j][k++] = "威宁彝族回族苗族自治县";
		arrCountry[i][j][k++] = "织金县";

	j++;
	arrCity[i][j] = "贵阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "贵阳市";
		arrCountry[i][j][k++] = "开阳县";
		arrCountry[i][j][k++] = "清镇市";
		arrCountry[i][j][k++] = "息烽县";
		arrCountry[i][j][k++] = "修文县";

	j++;
	arrCity[i][j] = "六盘水";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "六盘水市";
		arrCountry[i][j][k++] = "六枝特区";
		arrCountry[i][j][k++] = "盘县";
		arrCountry[i][j][k++] = "水城县";

	j++;
	arrCity[i][j] = "黔东南苗族侗族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "从江县";
		arrCountry[i][j][k++] = "丹寨县";
		arrCountry[i][j][k++] = "黄平县";
		arrCountry[i][j][k++] = "剑河县";
		arrCountry[i][j][k++] = "锦屏县";
		arrCountry[i][j][k++] = "凯里市";
		arrCountry[i][j][k++] = "雷山县";
		arrCountry[i][j][k++] = "黎平县";
		arrCountry[i][j][k++] = "麻江县";
		arrCountry[i][j][k++] = "三穗县";
		arrCountry[i][j][k++] = "施秉县";
		arrCountry[i][j][k++] = "台江县";
		arrCountry[i][j][k++] = "天柱县";
		arrCountry[i][j][k++] = "镇远县";
		arrCountry[i][j][k++] = "岑巩县";
		arrCountry[i][j][k++] = "榕江县";

	j++;
	arrCity[i][j] = "黔南布依族苗族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长顺县";
		arrCountry[i][j][k++] = "都匀市";
		arrCountry[i][j][k++] = "独山县";
		arrCountry[i][j][k++] = "福泉市";
		arrCountry[i][j][k++] = "贵定县";
		arrCountry[i][j][k++] = "惠水县";
		arrCountry[i][j][k++] = "荔波县";
		arrCountry[i][j][k++] = "龙里县";
		arrCountry[i][j][k++] = "罗甸县";
		arrCountry[i][j][k++] = "平塘县";
		arrCountry[i][j][k++] = "三都水族自治县";
		arrCountry[i][j][k++] = "瓮安县";

	j++;
	arrCity[i][j] = "黔西南布依族苗族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安龙县";
		arrCountry[i][j][k++] = "册亨县";
		arrCountry[i][j][k++] = "普安县";
		arrCountry[i][j][k++] = "晴隆县";
		arrCountry[i][j][k++] = "望谟县";
		arrCountry[i][j][k++] = "兴仁县";
		arrCountry[i][j][k++] = "兴义市";
		arrCountry[i][j][k++] = "贞丰县";

	j++;
	arrCity[i][j] = "铜仁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "德江县";
		arrCountry[i][j][k++] = "江口县";
		arrCountry[i][j][k++] = "石阡县";
		arrCountry[i][j][k++] = "思南县";
		arrCountry[i][j][k++] = "松桃苗族自治县";
		arrCountry[i][j][k++] = "铜仁市";
		arrCountry[i][j][k++] = "万山特区";
		arrCountry[i][j][k++] = "沿河土家族自治县";
		arrCountry[i][j][k++] = "印江土家族苗族自治县";
		arrCountry[i][j][k++] = "玉屏侗族自治县";

	j++;
	arrCity[i][j] = "遵义";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "赤水市";
		arrCountry[i][j][k++] = "道真仡佬族苗族自治县";
		arrCountry[i][j][k++] = "凤冈县";
		arrCountry[i][j][k++] = "仁怀市";
		arrCountry[i][j][k++] = "绥阳县";
		arrCountry[i][j][k++] = "桐梓县";
		arrCountry[i][j][k++] = "务川仡佬族苗族自治县";
		arrCountry[i][j][k++] = "习水县";
		arrCountry[i][j][k++] = "余庆县";
		arrCountry[i][j][k++] = "正安县";
		arrCountry[i][j][k++] = "遵义市";
		arrCountry[i][j][k++] = "遵义县";
		arrCountry[i][j][k++] = "湄潭县";

	j++;

i++;
arrProvince[i] = "海南";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "白沙黎族自治县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "白沙黎族自治县";

	j++;
	arrCity[i][j] = "保亭黎族苗族自治县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "保亭黎族苗族自治县";

	j++;
	arrCity[i][j] = "昌江黎族自治县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "昌江黎族自治县";

	j++;
	arrCity[i][j] = "澄迈县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "澄迈县";

	j++;
	arrCity[i][j] = "定安县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "定安县";

	j++;
	arrCity[i][j] = "东方";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东方市";

	j++;
	arrCity[i][j] = "海口";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "海口市";

	j++;
	arrCity[i][j] = "乐东黎族自治县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "乐东黎族自治县";

	j++;
	arrCity[i][j] = "临高县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "临高县";

	j++;
	arrCity[i][j] = "陵水黎族自治县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "陵水黎族自治县";

	j++;
	arrCity[i][j] = "琼海";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "琼海市";

	j++;
	arrCity[i][j] = "琼中黎族苗族自治县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "琼中黎族苗族自治县";

	j++;
	arrCity[i][j] = "三亚";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "三亚市";

	j++;
	arrCity[i][j] = "屯昌县";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "屯昌县";

	j++;
	arrCity[i][j] = "万宁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "万宁市";

	j++;
	arrCity[i][j] = "文昌";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "文昌市";

	j++;
	arrCity[i][j] = "五指山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "五指山市";

	j++;
	arrCity[i][j] = "儋州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "儋州市";

	j++;

i++;
arrProvince[i] = "河北";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "保定";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安国市";
		arrCountry[i][j][k++] = "安新县";
		arrCountry[i][j][k++] = "保定市";
		arrCountry[i][j][k++] = "博野县";
		arrCountry[i][j][k++] = "定兴县";
		arrCountry[i][j][k++] = "定州市";
		arrCountry[i][j][k++] = "阜平县";
		arrCountry[i][j][k++] = "高碑店市";
		arrCountry[i][j][k++] = "高阳县";
		arrCountry[i][j][k++] = "满城县";
		arrCountry[i][j][k++] = "清苑县";
		arrCountry[i][j][k++] = "曲阳县";
		arrCountry[i][j][k++] = "容城县";
		arrCountry[i][j][k++] = "顺平县";
		arrCountry[i][j][k++] = "唐县";
		arrCountry[i][j][k++] = "望都县";
		arrCountry[i][j][k++] = "雄县";
		arrCountry[i][j][k++] = "徐水县";
		arrCountry[i][j][k++] = "易县";
		arrCountry[i][j][k++] = "涞水县";
		arrCountry[i][j][k++] = "涞源县";
		arrCountry[i][j][k++] = "涿州市";
		arrCountry[i][j][k++] = "蠡县";

	j++;
	arrCity[i][j] = "沧州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "泊头市";
		arrCountry[i][j][k++] = "沧县";
		arrCountry[i][j][k++] = "沧州市";
		arrCountry[i][j][k++] = "东光县";
		arrCountry[i][j][k++] = "海兴县";
		arrCountry[i][j][k++] = "河间市";
		arrCountry[i][j][k++] = "黄骅市";
		arrCountry[i][j][k++] = "孟村回族自治县";
		arrCountry[i][j][k++] = "南皮县";
		arrCountry[i][j][k++] = "青县";
		arrCountry[i][j][k++] = "任丘市";
		arrCountry[i][j][k++] = "肃宁县";
		arrCountry[i][j][k++] = "吴桥县";
		arrCountry[i][j][k++] = "献县";
		arrCountry[i][j][k++] = "盐山县";

	j++;
	arrCity[i][j] = "承德";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "承德市";
		arrCountry[i][j][k++] = "承德县";
		arrCountry[i][j][k++] = "丰宁满族自治县";
		arrCountry[i][j][k++] = "宽城满族自治县";
		arrCountry[i][j][k++] = "隆化县";
		arrCountry[i][j][k++] = "滦平县";
		arrCountry[i][j][k++] = "平泉县";
		arrCountry[i][j][k++] = "围场满族蒙古族自治县";
		arrCountry[i][j][k++] = "兴隆县";

	j++;
	arrCity[i][j] = "邯郸";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "成安县";
		arrCountry[i][j][k++] = "磁县";
		arrCountry[i][j][k++] = "大名县";
		arrCountry[i][j][k++] = "肥乡县";
		arrCountry[i][j][k++] = "馆陶县";
		arrCountry[i][j][k++] = "广平县";
		arrCountry[i][j][k++] = "邯郸市";
		arrCountry[i][j][k++] = "邯郸县";
		arrCountry[i][j][k++] = "鸡泽县";
		arrCountry[i][j][k++] = "临漳县";
		arrCountry[i][j][k++] = "邱县";
		arrCountry[i][j][k++] = "曲周县";
		arrCountry[i][j][k++] = "涉县";
		arrCountry[i][j][k++] = "魏县";
		arrCountry[i][j][k++] = "武安市";
		arrCountry[i][j][k++] = "永年县";

	j++;
	arrCity[i][j] = "衡水";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安平县";
		arrCountry[i][j][k++] = "阜城县";
		arrCountry[i][j][k++] = "故城县";
		arrCountry[i][j][k++] = "衡水市";
		arrCountry[i][j][k++] = "冀州市";
		arrCountry[i][j][k++] = "景县";
		arrCountry[i][j][k++] = "饶阳县";
		arrCountry[i][j][k++] = "深州市";
		arrCountry[i][j][k++] = "武强县";
		arrCountry[i][j][k++] = "武邑县";
		arrCountry[i][j][k++] = "枣强县";

	j++;
	arrCity[i][j] = "廊坊";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "霸州市";
		arrCountry[i][j][k++] = "大厂回族自治县";
		arrCountry[i][j][k++] = "大城县";
		arrCountry[i][j][k++] = "固安县";
		arrCountry[i][j][k++] = "廊坊市";
		arrCountry[i][j][k++] = "三河市";
		arrCountry[i][j][k++] = "文安县";
		arrCountry[i][j][k++] = "香河县";
		arrCountry[i][j][k++] = "永清县";

	j++;
	arrCity[i][j] = "秦皇岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "昌黎县";
		arrCountry[i][j][k++] = "抚宁县";
		arrCountry[i][j][k++] = "卢龙县";
		arrCountry[i][j][k++] = "秦皇岛市";
		arrCountry[i][j][k++] = "青龙满族自治县";

	j++;
	arrCity[i][j] = "石家庄";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "高邑县";
		arrCountry[i][j][k++] = "晋州市";
		arrCountry[i][j][k++] = "井陉县";
		arrCountry[i][j][k++] = "灵寿县";
		arrCountry[i][j][k++] = "鹿泉市";
		arrCountry[i][j][k++] = "平山县";
		arrCountry[i][j][k++] = "深泽县";
		arrCountry[i][j][k++] = "石家庄市";
		arrCountry[i][j][k++] = "无极县";
		arrCountry[i][j][k++] = "辛集市";
		arrCountry[i][j][k++] = "新乐市";
		arrCountry[i][j][k++] = "行唐县";
		arrCountry[i][j][k++] = "元氏县";
		arrCountry[i][j][k++] = "赞皇县";
		arrCountry[i][j][k++] = "赵县";
		arrCountry[i][j][k++] = "正定县";
		arrCountry[i][j][k++] = "藁城市";
		arrCountry[i][j][k++] = "栾城县";

	j++;
	arrCity[i][j] = "唐山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "乐亭县";
		arrCountry[i][j][k++] = "滦南县";
		arrCountry[i][j][k++] = "滦县";
		arrCountry[i][j][k++] = "迁安市";
		arrCountry[i][j][k++] = "迁西县";
		arrCountry[i][j][k++] = "唐海县";
		arrCountry[i][j][k++] = "唐山市";
		arrCountry[i][j][k++] = "玉田县";
		arrCountry[i][j][k++] = "遵化市";

	j++;
	arrCity[i][j] = "邢台";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "柏乡县";
		arrCountry[i][j][k++] = "广宗县";
		arrCountry[i][j][k++] = "巨鹿县";
		arrCountry[i][j][k++] = "临城县";
		arrCountry[i][j][k++] = "临西县";
		arrCountry[i][j][k++] = "隆尧县";
		arrCountry[i][j][k++] = "南宫市";
		arrCountry[i][j][k++] = "南和县";
		arrCountry[i][j][k++] = "内丘县";
		arrCountry[i][j][k++] = "宁晋县";
		arrCountry[i][j][k++] = "平乡县";
		arrCountry[i][j][k++] = "清河县";
		arrCountry[i][j][k++] = "任县";
		arrCountry[i][j][k++] = "沙河市";
		arrCountry[i][j][k++] = "威县";
		arrCountry[i][j][k++] = "新河县";
		arrCountry[i][j][k++] = "邢台市";
		arrCountry[i][j][k++] = "邢台县";

	j++;
	arrCity[i][j] = "张家口";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "赤城县";
		arrCountry[i][j][k++] = "崇礼县";
		arrCountry[i][j][k++] = "沽源县";
		arrCountry[i][j][k++] = "怀安县";
		arrCountry[i][j][k++] = "怀来县";
		arrCountry[i][j][k++] = "康保县";
		arrCountry[i][j][k++] = "尚义县";
		arrCountry[i][j][k++] = "万全县";
		arrCountry[i][j][k++] = "蔚县";
		arrCountry[i][j][k++] = "宣化县";
		arrCountry[i][j][k++] = "阳原县";
		arrCountry[i][j][k++] = "张北县";
		arrCountry[i][j][k++] = "张家口市";
		arrCountry[i][j][k++] = "涿鹿县";

	j++;

i++;
arrProvince[i] = "河南";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "安阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安阳市";
		arrCountry[i][j][k++] = "安阳县";
		arrCountry[i][j][k++] = "滑县";
		arrCountry[i][j][k++] = "林州市";
		arrCountry[i][j][k++] = "内黄县";
		arrCountry[i][j][k++] = "汤阴县";

	j++;
	arrCity[i][j] = "鹤壁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "鹤壁市";
		arrCountry[i][j][k++] = "浚县";
		arrCountry[i][j][k++] = "淇县";

	j++;
	arrCity[i][j] = "济源";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "济源市";

	j++;
	arrCity[i][j] = "焦作";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "博爱县";
		arrCountry[i][j][k++] = "焦作市";
		arrCountry[i][j][k++] = "孟州市";
		arrCountry[i][j][k++] = "沁阳市";
		arrCountry[i][j][k++] = "温县";
		arrCountry[i][j][k++] = "武陟县";
		arrCountry[i][j][k++] = "修武县";

	j++;
	arrCity[i][j] = "开封";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "开封市";
		arrCountry[i][j][k++] = "开封县";
		arrCountry[i][j][k++] = "兰考县";
		arrCountry[i][j][k++] = "通许县";
		arrCountry[i][j][k++] = "尉氏县";
		arrCountry[i][j][k++] = "杞县";

	j++;
	arrCity[i][j] = "洛阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "洛宁县";
		arrCountry[i][j][k++] = "洛阳市";
		arrCountry[i][j][k++] = "孟津县";
		arrCountry[i][j][k++] = "汝阳县";
		arrCountry[i][j][k++] = "新安县";
		arrCountry[i][j][k++] = "伊川县";
		arrCountry[i][j][k++] = "宜阳县";
		arrCountry[i][j][k++] = "偃师市";
		arrCountry[i][j][k++] = "嵩县";
		arrCountry[i][j][k++] = "栾川县";

	j++;
	arrCity[i][j] = "南阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "邓州市";
		arrCountry[i][j][k++] = "方城县";
		arrCountry[i][j][k++] = "南阳市";
		arrCountry[i][j][k++] = "南召县";
		arrCountry[i][j][k++] = "内乡县";
		arrCountry[i][j][k++] = "社旗县";
		arrCountry[i][j][k++] = "唐河县";
		arrCountry[i][j][k++] = "桐柏县";
		arrCountry[i][j][k++] = "西峡县";
		arrCountry[i][j][k++] = "新野县";
		arrCountry[i][j][k++] = "镇平县";
		arrCountry[i][j][k++] = "淅川县";

	j++;
	arrCity[i][j] = "平顶山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宝丰县";
		arrCountry[i][j][k++] = "鲁山县";
		arrCountry[i][j][k++] = "平顶山市";
		arrCountry[i][j][k++] = "汝州市";
		arrCountry[i][j][k++] = "舞钢市";
		arrCountry[i][j][k++] = "叶县";
		arrCountry[i][j][k++] = "郏县";

	j++;
	arrCity[i][j] = "三门峡";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "灵宝市";
		arrCountry[i][j][k++] = "卢氏县";
		arrCountry[i][j][k++] = "三门峡市";
		arrCountry[i][j][k++] = "陕县";
		arrCountry[i][j][k++] = "义马市";
		arrCountry[i][j][k++] = "渑池县";

	j++;
	arrCity[i][j] = "商丘";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "民权县";
		arrCountry[i][j][k++] = "宁陵县";
		arrCountry[i][j][k++] = "商丘市";
		arrCountry[i][j][k++] = "夏邑县";
		arrCountry[i][j][k++] = "永城市";
		arrCountry[i][j][k++] = "虞城县";
		arrCountry[i][j][k++] = "柘城县";
		arrCountry[i][j][k++] = "睢县";

	j++;
	arrCity[i][j] = "新乡";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长垣县";
		arrCountry[i][j][k++] = "封丘县";
		arrCountry[i][j][k++] = "辉县市";
		arrCountry[i][j][k++] = "获嘉县";
		arrCountry[i][j][k++] = "卫辉市";
		arrCountry[i][j][k++] = "新乡市";
		arrCountry[i][j][k++] = "新乡县";
		arrCountry[i][j][k++] = "延津县";
		arrCountry[i][j][k++] = "原阳县";

	j++;
	arrCity[i][j] = "信阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "固始县";
		arrCountry[i][j][k++] = "光山县";
		arrCountry[i][j][k++] = "淮滨县";
		arrCountry[i][j][k++] = "罗山县";
		arrCountry[i][j][k++] = "商城县";
		arrCountry[i][j][k++] = "息县";
		arrCountry[i][j][k++] = "新县";
		arrCountry[i][j][k++] = "信阳市";
		arrCountry[i][j][k++] = "潢川县";

	j++;
	arrCity[i][j] = "许昌";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长葛市";
		arrCountry[i][j][k++] = "襄城县";
		arrCountry[i][j][k++] = "许昌市";
		arrCountry[i][j][k++] = "许昌县";
		arrCountry[i][j][k++] = "禹州市";
		arrCountry[i][j][k++] = "鄢陵县";

	j++;
	arrCity[i][j] = "郑州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "登封市";
		arrCountry[i][j][k++] = "巩义市";
		arrCountry[i][j][k++] = "新密市";
		arrCountry[i][j][k++] = "新郑市";
		arrCountry[i][j][k++] = "郑州市";
		arrCountry[i][j][k++] = "中牟县";
		arrCountry[i][j][k++] = "荥阳市";

	j++;
	arrCity[i][j] = "周口";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "郸城县";
		arrCountry[i][j][k++] = "扶沟县";
		arrCountry[i][j][k++] = "淮阳县";
		arrCountry[i][j][k++] = "鹿邑县";
		arrCountry[i][j][k++] = "商水县";
		arrCountry[i][j][k++] = "沈丘县";
		arrCountry[i][j][k++] = "太康县";
		arrCountry[i][j][k++] = "西华县";
		arrCountry[i][j][k++] = "项城市";
		arrCountry[i][j][k++] = "周口市";

	j++;
	arrCity[i][j] = "驻马店";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "泌阳县";
		arrCountry[i][j][k++] = "平舆县";
		arrCountry[i][j][k++] = "确山县";
		arrCountry[i][j][k++] = "汝南县";
		arrCountry[i][j][k++] = "上蔡县";
		arrCountry[i][j][k++] = "遂平县";
		arrCountry[i][j][k++] = "西平县";
		arrCountry[i][j][k++] = "新蔡县";
		arrCountry[i][j][k++] = "正阳县";
		arrCountry[i][j][k++] = "驻马店市";

	j++;
	arrCity[i][j] = "漯河";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "临颍县";
		arrCountry[i][j][k++] = "舞阳县";
		arrCountry[i][j][k++] = "郾城县";
		arrCountry[i][j][k++] = "漯河市";

	j++;
	arrCity[i][j] = "濮阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "范县";
		arrCountry[i][j][k++] = "南乐县";
		arrCountry[i][j][k++] = "清丰县";
		arrCountry[i][j][k++] = "台前县";
		arrCountry[i][j][k++] = "濮阳市";
		arrCountry[i][j][k++] = "濮阳县";

	j++;

i++;
arrProvince[i] = "黑龙江";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "大庆";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大庆市";
		arrCountry[i][j][k++] = "杜尔伯特蒙古族自治县";
		arrCountry[i][j][k++] = "林甸县";
		arrCountry[i][j][k++] = "肇源县";
		arrCountry[i][j][k++] = "肇州县";

	j++;
	arrCity[i][j] = "大兴安岭";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "呼玛县";
		arrCountry[i][j][k++] = "漠河县";
		arrCountry[i][j][k++] = "塔河县";

	j++;
	arrCity[i][j] = "哈尔滨";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿城市";
		arrCountry[i][j][k++] = "巴彦县";
		arrCountry[i][j][k++] = "宾县";
		arrCountry[i][j][k++] = "方正县";
		arrCountry[i][j][k++] = "哈尔滨市";
		arrCountry[i][j][k++] = "呼兰县";
		arrCountry[i][j][k++] = "木兰县";
		arrCountry[i][j][k++] = "尚志市";
		arrCountry[i][j][k++] = "双城市";
		arrCountry[i][j][k++] = "通河县";
		arrCountry[i][j][k++] = "五常市";
		arrCountry[i][j][k++] = "延寿县";
		arrCountry[i][j][k++] = "依兰县";

	j++;
	arrCity[i][j] = "鹤岗";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "鹤岗市";
		arrCountry[i][j][k++] = "萝北县";
		arrCountry[i][j][k++] = "绥滨县";

	j++;
	arrCity[i][j] = "黑河";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "北安市";
		arrCountry[i][j][k++] = "黑河市";
		arrCountry[i][j][k++] = "嫩江县";
		arrCountry[i][j][k++] = "孙吴县";
		arrCountry[i][j][k++] = "五大连池市";
		arrCountry[i][j][k++] = "逊克县";

	j++;
	arrCity[i][j] = "鸡西";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "虎林市";
		arrCountry[i][j][k++] = "鸡东县";
		arrCountry[i][j][k++] = "鸡西市";
		arrCountry[i][j][k++] = "密山市";

	j++;
	arrCity[i][j] = "佳木斯";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "抚远县";
		arrCountry[i][j][k++] = "富锦市";
		arrCountry[i][j][k++] = "佳木斯市";
		arrCountry[i][j][k++] = "汤原县";
		arrCountry[i][j][k++] = "同江市";
		arrCountry[i][j][k++] = "桦川县";
		arrCountry[i][j][k++] = "桦南县";

	j++;
	arrCity[i][j] = "牡丹江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东宁县";
		arrCountry[i][j][k++] = "海林市";
		arrCountry[i][j][k++] = "林口县";
		arrCountry[i][j][k++] = "牡丹江市";
		arrCountry[i][j][k++] = "穆棱市";
		arrCountry[i][j][k++] = "宁安市";
		arrCountry[i][j][k++] = "绥芬河市";

	j++;
	arrCity[i][j] = "七台河";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "勃利县";
		arrCountry[i][j][k++] = "七台河市";

	j++;
	arrCity[i][j] = "齐齐哈尔";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "拜泉县";
		arrCountry[i][j][k++] = "富裕县";
		arrCountry[i][j][k++] = "甘南县";
		arrCountry[i][j][k++] = "克东县";
		arrCountry[i][j][k++] = "克山县";
		arrCountry[i][j][k++] = "龙江县";
		arrCountry[i][j][k++] = "齐齐哈尔市";
		arrCountry[i][j][k++] = "泰来县";
		arrCountry[i][j][k++] = "依安县";
		arrCountry[i][j][k++] = "讷河市";

	j++;
	arrCity[i][j] = "双鸭山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宝清县";
		arrCountry[i][j][k++] = "集贤县";
		arrCountry[i][j][k++] = "饶河县";
		arrCountry[i][j][k++] = "双鸭山市";
		arrCountry[i][j][k++] = "友谊县";

	j++;
	arrCity[i][j] = "绥化";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安达市";
		arrCountry[i][j][k++] = "海伦市";
		arrCountry[i][j][k++] = "兰西县";
		arrCountry[i][j][k++] = "明水县";
		arrCountry[i][j][k++] = "青冈县";
		arrCountry[i][j][k++] = "庆安县";
		arrCountry[i][j][k++] = "绥化市";
		arrCountry[i][j][k++] = "绥棱县";
		arrCountry[i][j][k++] = "望奎县";
		arrCountry[i][j][k++] = "肇东市";

	j++;
	arrCity[i][j] = "伊春";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "嘉荫县";
		arrCountry[i][j][k++] = "铁力市";
		arrCountry[i][j][k++] = "伊春市";

	j++;

i++;
arrProvince[i] = "湖北";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "鄂州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "鄂州市";

	j++;
	arrCity[i][j] = "恩施土家族苗族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "巴东县";
		arrCountry[i][j][k++] = "恩施市";
		arrCountry[i][j][k++] = "鹤峰县";
		arrCountry[i][j][k++] = "建始县";
		arrCountry[i][j][k++] = "来凤县";
		arrCountry[i][j][k++] = "利川市";
		arrCountry[i][j][k++] = "咸丰县";
		arrCountry[i][j][k++] = "宣恩县";

	j++;
	arrCity[i][j] = "黄冈";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "红安县";
		arrCountry[i][j][k++] = "黄冈市";
		arrCountry[i][j][k++] = "黄梅县";
		arrCountry[i][j][k++] = "罗田县";
		arrCountry[i][j][k++] = "麻城市";
		arrCountry[i][j][k++] = "团风县";
		arrCountry[i][j][k++] = "武穴市";
		arrCountry[i][j][k++] = "英山县";
		arrCountry[i][j][k++] = "蕲春县";
		arrCountry[i][j][k++] = "浠水县";

	j++;
	arrCity[i][j] = "黄石";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大冶市";
		arrCountry[i][j][k++] = "黄石市";
		arrCountry[i][j][k++] = "阳新县";

	j++;
	arrCity[i][j] = "荆门";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "荆门市";
		arrCountry[i][j][k++] = "京山县";
		arrCountry[i][j][k++] = "沙洋县";
		arrCountry[i][j][k++] = "钟祥市";

	j++;
	arrCity[i][j] = "荆州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "公安县";
		arrCountry[i][j][k++] = "洪湖市";
		arrCountry[i][j][k++] = "监利县";
		arrCountry[i][j][k++] = "江陵县";
		arrCountry[i][j][k++] = "荆州市";
		arrCountry[i][j][k++] = "石首市";
		arrCountry[i][j][k++] = "松滋市";

	j++;
	arrCity[i][j] = "潜江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "潜江市";

	j++;
	arrCity[i][j] = "神农架林区";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "神农架林区";

	j++;
	arrCity[i][j] = "十堰";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "丹江口市";
		arrCountry[i][j][k++] = "房县";
		arrCountry[i][j][k++] = "十堰市";
		arrCountry[i][j][k++] = "郧西县";
		arrCountry[i][j][k++] = "郧县";
		arrCountry[i][j][k++] = "竹山县";
		arrCountry[i][j][k++] = "竹溪县";

	j++;
	arrCity[i][j] = "随州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "广水市";
		arrCountry[i][j][k++] = "随州市";

	j++;
	arrCity[i][j] = "天门";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "天门市";

	j++;
	arrCity[i][j] = "武汉";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "武汉市";

	j++;
	arrCity[i][j] = "仙桃";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "仙桃市";

	j++;
	arrCity[i][j] = "咸宁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "赤壁市";
		arrCountry[i][j][k++] = "崇阳县";
		arrCountry[i][j][k++] = "嘉鱼县";
		arrCountry[i][j][k++] = "通城县";
		arrCountry[i][j][k++] = "通山县";
		arrCountry[i][j][k++] = "咸宁市";

	j++;
	arrCity[i][j] = "襄樊";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "保康县";
		arrCountry[i][j][k++] = "谷城县";
		arrCountry[i][j][k++] = "老河口市";
		arrCountry[i][j][k++] = "南漳县";
		arrCountry[i][j][k++] = "襄樊市";
		arrCountry[i][j][k++] = "宜城市";
		arrCountry[i][j][k++] = "枣阳市";

	j++;
	arrCity[i][j] = "孝感";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安陆市";
		arrCountry[i][j][k++] = "大悟县";
		arrCountry[i][j][k++] = "汉川市";
		arrCountry[i][j][k++] = "孝昌县";
		arrCountry[i][j][k++] = "孝感市";
		arrCountry[i][j][k++] = "应城市";
		arrCountry[i][j][k++] = "云梦县";

	j++;
	arrCity[i][j] = "宜昌";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长阳土家族自治县";
		arrCountry[i][j][k++] = "当阳市";
		arrCountry[i][j][k++] = "五峰土家族自治县";
		arrCountry[i][j][k++] = "兴山县";
		arrCountry[i][j][k++] = "宜昌市";
		arrCountry[i][j][k++] = "宜都市";
		arrCountry[i][j][k++] = "远安县";
		arrCountry[i][j][k++] = "枝江市";
		arrCountry[i][j][k++] = "秭归县";

	j++;

i++;
arrProvince[i] = "湖南";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "常德";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安乡县";
		arrCountry[i][j][k++] = "常德市";
		arrCountry[i][j][k++] = "汉寿县";
		arrCountry[i][j][k++] = "津市市";
		arrCountry[i][j][k++] = "临澧县";
		arrCountry[i][j][k++] = "石门县";
		arrCountry[i][j][k++] = "桃源县";
		arrCountry[i][j][k++] = "澧县";

	j++;
	arrCity[i][j] = "长沙";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长沙市";
		arrCountry[i][j][k++] = "长沙县";
		arrCountry[i][j][k++] = "宁乡县";
		arrCountry[i][j][k++] = "望城县";
		arrCountry[i][j][k++] = "浏阳市";

	j++;
	arrCity[i][j] = "郴州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安仁县";
		arrCountry[i][j][k++] = "郴州市";
		arrCountry[i][j][k++] = "桂东县";
		arrCountry[i][j][k++] = "桂阳县";
		arrCountry[i][j][k++] = "嘉禾县";
		arrCountry[i][j][k++] = "临武县";
		arrCountry[i][j][k++] = "汝城县";
		arrCountry[i][j][k++] = "宜章县";
		arrCountry[i][j][k++] = "永兴县";
		arrCountry[i][j][k++] = "资兴市";

	j++;
	arrCity[i][j] = "衡阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "常宁市";
		arrCountry[i][j][k++] = "衡东县";
		arrCountry[i][j][k++] = "衡南县";
		arrCountry[i][j][k++] = "衡山县";
		arrCountry[i][j][k++] = "衡阳市";
		arrCountry[i][j][k++] = "衡阳县";
		arrCountry[i][j][k++] = "祁东县";
		arrCountry[i][j][k++] = "耒阳市";

	j++;
	arrCity[i][j] = "怀化";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "辰溪县";
		arrCountry[i][j][k++] = "洪江市";
		arrCountry[i][j][k++] = "怀化市";
		arrCountry[i][j][k++] = "会同县";
		arrCountry[i][j][k++] = "靖州苗族侗族自治县";
		arrCountry[i][j][k++] = "麻阳苗族自治县";
		arrCountry[i][j][k++] = "通道侗族自治县";
		arrCountry[i][j][k++] = "新晃侗族自治县";
		arrCountry[i][j][k++] = "中方县";
		arrCountry[i][j][k++] = "芷江侗族自治县";
		arrCountry[i][j][k++] = "沅陵县";
		arrCountry[i][j][k++] = "溆浦县";

	j++;
	arrCity[i][j] = "娄底";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "冷水江市";
		arrCountry[i][j][k++] = "涟源市";
		arrCountry[i][j][k++] = "娄底市";
		arrCountry[i][j][k++] = "双峰县";
		arrCountry[i][j][k++] = "新化县";

	j++;
	arrCity[i][j] = "邵阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "城步苗族自治县";
		arrCountry[i][j][k++] = "洞口县";
		arrCountry[i][j][k++] = "隆回县";
		arrCountry[i][j][k++] = "邵东县";
		arrCountry[i][j][k++] = "邵阳市";
		arrCountry[i][j][k++] = "邵阳县";
		arrCountry[i][j][k++] = "绥宁县";
		arrCountry[i][j][k++] = "武冈市";
		arrCountry[i][j][k++] = "新宁县";
		arrCountry[i][j][k++] = "新邵县";

	j++;
	arrCity[i][j] = "湘潭";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "韶山市";
		arrCountry[i][j][k++] = "湘潭市";
		arrCountry[i][j][k++] = "湘潭县";
		arrCountry[i][j][k++] = "湘乡市";

	j++;
	arrCity[i][j] = "湘西土家族苗族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "保靖县";
		arrCountry[i][j][k++] = "凤凰县";
		arrCountry[i][j][k++] = "古丈县";
		arrCountry[i][j][k++] = "花垣县";
		arrCountry[i][j][k++] = "吉首市";
		arrCountry[i][j][k++] = "龙山县";
		arrCountry[i][j][k++] = "永顺县";
		arrCountry[i][j][k++] = "泸溪县";

	j++;
	arrCity[i][j] = "益阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安化县";
		arrCountry[i][j][k++] = "南县";
		arrCountry[i][j][k++] = "桃江县";
		arrCountry[i][j][k++] = "益阳市";
		arrCountry[i][j][k++] = "沅江市";

	j++;
	arrCity[i][j] = "永州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "道县";
		arrCountry[i][j][k++] = "东安县";
		arrCountry[i][j][k++] = "江华瑶族自治县";
		arrCountry[i][j][k++] = "江永县";
		arrCountry[i][j][k++] = "蓝山县";
		arrCountry[i][j][k++] = "宁远县";
		arrCountry[i][j][k++] = "祁阳县";
		arrCountry[i][j][k++] = "双牌县";
		arrCountry[i][j][k++] = "新田县";
		arrCountry[i][j][k++] = "永州市";

	j++;
	arrCity[i][j] = "岳阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "华容县";
		arrCountry[i][j][k++] = "临湘市";
		arrCountry[i][j][k++] = "平江县";
		arrCountry[i][j][k++] = "湘阴县";
		arrCountry[i][j][k++] = "岳阳市";
		arrCountry[i][j][k++] = "岳阳县";
		arrCountry[i][j][k++] = "汨罗市";

	j++;
	arrCity[i][j] = "张家界";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "慈利县";
		arrCountry[i][j][k++] = "桑植县";
		arrCountry[i][j][k++] = "张家界市";

	j++;
	arrCity[i][j] = "株洲";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "茶陵县";
		arrCountry[i][j][k++] = "炎陵县";
		arrCountry[i][j][k++] = "株洲市";
		arrCountry[i][j][k++] = "株洲县";
		arrCountry[i][j][k++] = "攸县";
		arrCountry[i][j][k++] = "醴陵市";

	j++;

i++;
arrProvince[i] = "吉林";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "白城";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "白城市";
		arrCountry[i][j][k++] = "大安市";
		arrCountry[i][j][k++] = "通榆县";
		arrCountry[i][j][k++] = "镇赉县";
		arrCountry[i][j][k++] = "洮南市";

	j++;
	arrCity[i][j] = "白山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "白山市";
		arrCountry[i][j][k++] = "长白朝鲜族自治县";
		arrCountry[i][j][k++] = "抚松县";
		arrCountry[i][j][k++] = "江源县";
		arrCountry[i][j][k++] = "靖宇县";
		arrCountry[i][j][k++] = "临江市";

	j++;
	arrCity[i][j] = "长春";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长春市";
		arrCountry[i][j][k++] = "德惠市";
		arrCountry[i][j][k++] = "九台市";
		arrCountry[i][j][k++] = "农安县";
		arrCountry[i][j][k++] = "榆树市";

	j++;
	arrCity[i][j] = "吉林";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "吉林市";
		arrCountry[i][j][k++] = "磐石市";
		arrCountry[i][j][k++] = "舒兰市";
		arrCountry[i][j][k++] = "永吉县";
		arrCountry[i][j][k++] = "桦甸市";
		arrCountry[i][j][k++] = "蛟河市";

	j++;
	arrCity[i][j] = "辽源";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东丰县";
		arrCountry[i][j][k++] = "东辽县";
		arrCountry[i][j][k++] = "辽源市";

	j++;
	arrCity[i][j] = "四平";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "公主岭市";
		arrCountry[i][j][k++] = "梨树县";
		arrCountry[i][j][k++] = "双辽市";
		arrCountry[i][j][k++] = "四平市";
		arrCountry[i][j][k++] = "伊通满族自治县";

	j++;
	arrCity[i][j] = "松原";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长岭县";
		arrCountry[i][j][k++] = "扶余县";
		arrCountry[i][j][k++] = "乾安县";
		arrCountry[i][j][k++] = "前郭尔罗斯蒙古族自治县";
		arrCountry[i][j][k++] = "松原市";

	j++;
	arrCity[i][j] = "通化";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "辉南县";
		arrCountry[i][j][k++] = "集安市";
		arrCountry[i][j][k++] = "柳河县";
		arrCountry[i][j][k++] = "梅河口市";
		arrCountry[i][j][k++] = "通化市";
		arrCountry[i][j][k++] = "通化县";

	j++;
	arrCity[i][j] = "延边朝鲜族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安图县";
		arrCountry[i][j][k++] = "敦化市";
		arrCountry[i][j][k++] = "和龙市";
		arrCountry[i][j][k++] = "龙井市";
		arrCountry[i][j][k++] = "图们市";
		arrCountry[i][j][k++] = "汪清县";
		arrCountry[i][j][k++] = "延吉市";
		arrCountry[i][j][k++] = "珲春市";

	j++;

i++;
arrProvince[i] = "江苏";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "常州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "常州市";
		arrCountry[i][j][k++] = "金坛市";
		arrCountry[i][j][k++] = "溧阳市";

	j++;
	arrCity[i][j] = "淮安";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "洪泽县";
		arrCountry[i][j][k++] = "淮安市";
		arrCountry[i][j][k++] = "金湖县";
		arrCountry[i][j][k++] = "涟水县";
		arrCountry[i][j][k++] = "盱眙县";

	j++;
	arrCity[i][j] = "连云港";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东海县";
		arrCountry[i][j][k++] = "赣榆县";
		arrCountry[i][j][k++] = "灌南县";
		arrCountry[i][j][k++] = "灌云县";
		arrCountry[i][j][k++] = "连云港市";

	j++;
	arrCity[i][j] = "南京";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "高淳县";
		arrCountry[i][j][k++] = "南京市";
		arrCountry[i][j][k++] = "溧水县";

	j++;
	arrCity[i][j] = "南通";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "海安县";
		arrCountry[i][j][k++] = "海门市";
		arrCountry[i][j][k++] = "南通市";
		arrCountry[i][j][k++] = "启东市";
		arrCountry[i][j][k++] = "如东县";
		arrCountry[i][j][k++] = "如皋市";
		arrCountry[i][j][k++] = "通州市";

	j++;
	arrCity[i][j] = "苏州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "常熟市";
		arrCountry[i][j][k++] = "昆山市";
		arrCountry[i][j][k++] = "苏州市";
		arrCountry[i][j][k++] = "太仓市";
		arrCountry[i][j][k++] = "吴江市";
		arrCountry[i][j][k++] = "张家港市";

	j++;
	arrCity[i][j] = "宿迁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宿迁市";
		arrCountry[i][j][k++] = "宿豫县";
		arrCountry[i][j][k++] = "沭阳县";
		arrCountry[i][j][k++] = "泗洪县";
		arrCountry[i][j][k++] = "泗阳县";

	j++;
	arrCity[i][j] = "泰州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "姜堰市";
		arrCountry[i][j][k++] = "靖江市";
		arrCountry[i][j][k++] = "泰兴市";
		arrCountry[i][j][k++] = "泰州市";
		arrCountry[i][j][k++] = "兴化市";

	j++;
	arrCity[i][j] = "无锡";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "江阴市";
		arrCountry[i][j][k++] = "无锡市";
		arrCountry[i][j][k++] = "宜兴市";

	j++;
	arrCity[i][j] = "徐州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "丰县";
		arrCountry[i][j][k++] = "沛县";
		arrCountry[i][j][k++] = "铜山县";
		arrCountry[i][j][k++] = "新沂市";
		arrCountry[i][j][k++] = "徐州市";
		arrCountry[i][j][k++] = "邳州市";
		arrCountry[i][j][k++] = "睢宁县";

	j++;
	arrCity[i][j] = "盐城";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "滨海县";
		arrCountry[i][j][k++] = "大丰市";
		arrCountry[i][j][k++] = "东台市";
		arrCountry[i][j][k++] = "阜宁县";
		arrCountry[i][j][k++] = "建湖县";
		arrCountry[i][j][k++] = "射阳县";
		arrCountry[i][j][k++] = "响水县";
		arrCountry[i][j][k++] = "盐城市";
		arrCountry[i][j][k++] = "盐都县";

	j++;
	arrCity[i][j] = "扬州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宝应县";
		arrCountry[i][j][k++] = "高邮市";
		arrCountry[i][j][k++] = "江都市";
		arrCountry[i][j][k++] = "扬州市";
		arrCountry[i][j][k++] = "仪征市";

	j++;
	arrCity[i][j] = "镇江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "丹阳市";
		arrCountry[i][j][k++] = "句容市";
		arrCountry[i][j][k++] = "扬中市";
		arrCountry[i][j][k++] = "镇江市";

	j++;

i++;
arrProvince[i] = "江西";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "抚州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "崇仁县";
		arrCountry[i][j][k++] = "东乡县";
		arrCountry[i][j][k++] = "抚州市";
		arrCountry[i][j][k++] = "广昌县";
		arrCountry[i][j][k++] = "金溪县";
		arrCountry[i][j][k++] = "乐安县";
		arrCountry[i][j][k++] = "黎川县";
		arrCountry[i][j][k++] = "南城县";
		arrCountry[i][j][k++] = "南丰县";
		arrCountry[i][j][k++] = "宜黄县";
		arrCountry[i][j][k++] = "资溪县";

	j++;
	arrCity[i][j] = "赣州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安远县";
		arrCountry[i][j][k++] = "崇义县";
		arrCountry[i][j][k++] = "大余县";
		arrCountry[i][j][k++] = "定南县";
		arrCountry[i][j][k++] = "赣县";
		arrCountry[i][j][k++] = "赣州市";
		arrCountry[i][j][k++] = "会昌县";
		arrCountry[i][j][k++] = "龙南县";
		arrCountry[i][j][k++] = "南康市";
		arrCountry[i][j][k++] = "宁都县";
		arrCountry[i][j][k++] = "全南县";
		arrCountry[i][j][k++] = "瑞金市";
		arrCountry[i][j][k++] = "上犹县";
		arrCountry[i][j][k++] = "石城县";
		arrCountry[i][j][k++] = "信丰县";
		arrCountry[i][j][k++] = "兴国县";
		arrCountry[i][j][k++] = "寻乌县";
		arrCountry[i][j][k++] = "于都县";

	j++;
	arrCity[i][j] = "吉安";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安福县";
		arrCountry[i][j][k++] = "吉安市";
		arrCountry[i][j][k++] = "吉安县";
		arrCountry[i][j][k++] = "吉水县";
		arrCountry[i][j][k++] = "井冈山市";
		arrCountry[i][j][k++] = "遂川县";
		arrCountry[i][j][k++] = "泰和县";
		arrCountry[i][j][k++] = "万安县";
		arrCountry[i][j][k++] = "峡江县";
		arrCountry[i][j][k++] = "新干县";
		arrCountry[i][j][k++] = "永丰县";
		arrCountry[i][j][k++] = "永新县";

	j++;
	arrCity[i][j] = "景德镇";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "浮梁县";
		arrCountry[i][j][k++] = "景德镇市";
		arrCountry[i][j][k++] = "乐平市";

	j++;
	arrCity[i][j] = "九江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "德安县";
		arrCountry[i][j][k++] = "都昌县";
		arrCountry[i][j][k++] = "湖口县";
		arrCountry[i][j][k++] = "九江市";
		arrCountry[i][j][k++] = "九江县";
		arrCountry[i][j][k++] = "彭泽县";
		arrCountry[i][j][k++] = "瑞昌市";
		arrCountry[i][j][k++] = "武宁县";
		arrCountry[i][j][k++] = "星子县";
		arrCountry[i][j][k++] = "修水县";
		arrCountry[i][j][k++] = "永修县";

	j++;
	arrCity[i][j] = "南昌";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安义县";
		arrCountry[i][j][k++] = "进贤县";
		arrCountry[i][j][k++] = "南昌市";
		arrCountry[i][j][k++] = "南昌县";
		arrCountry[i][j][k++] = "新建县";

	j++;
	arrCity[i][j] = "萍乡";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "莲花县";
		arrCountry[i][j][k++] = "芦溪县";
		arrCountry[i][j][k++] = "萍乡市";
		arrCountry[i][j][k++] = "上栗县";

	j++;
	arrCity[i][j] = "上饶";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "波阳县";
		arrCountry[i][j][k++] = "德兴市";
		arrCountry[i][j][k++] = "广丰县";
		arrCountry[i][j][k++] = "横峰县";
		arrCountry[i][j][k++] = "铅山县";
		arrCountry[i][j][k++] = "上饶市";
		arrCountry[i][j][k++] = "上饶县";
		arrCountry[i][j][k++] = "万年县";
		arrCountry[i][j][k++] = "余干县";
		arrCountry[i][j][k++] = "玉山县";
		arrCountry[i][j][k++] = "弋阳县";
		arrCountry[i][j][k++] = "婺源县";

	j++;
	arrCity[i][j] = "新余";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "分宜县";
		arrCountry[i][j][k++] = "新余市";

	j++;
	arrCity[i][j] = "宜春";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "丰城市";
		arrCountry[i][j][k++] = "奉新县";
		arrCountry[i][j][k++] = "高安市";
		arrCountry[i][j][k++] = "靖安县";
		arrCountry[i][j][k++] = "上高县";
		arrCountry[i][j][k++] = "铜鼓县";
		arrCountry[i][j][k++] = "万载县";
		arrCountry[i][j][k++] = "宜春市";
		arrCountry[i][j][k++] = "宜丰县";
		arrCountry[i][j][k++] = "樟树市";

	j++;
	arrCity[i][j] = "鹰潭";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "贵溪市";
		arrCountry[i][j][k++] = "鹰潭市";
		arrCountry[i][j][k++] = "余江县";

	j++;

i++;
arrProvince[i] = "辽宁";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "鞍山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "鞍山市";
		arrCountry[i][j][k++] = "海城市";
		arrCountry[i][j][k++] = "台安县";
		arrCountry[i][j][k++] = "岫岩满族自治县";

	j++;
	arrCity[i][j] = "本溪";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "本溪满族自治县";
		arrCountry[i][j][k++] = "本溪市";
		arrCountry[i][j][k++] = "桓仁满族自治县";

	j++;
	arrCity[i][j] = "朝阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "北票市";
		arrCountry[i][j][k++] = "朝阳市";
		arrCountry[i][j][k++] = "朝阳县";
		arrCountry[i][j][k++] = "建平县";
		arrCountry[i][j][k++] = "喀喇沁左翼蒙古族自治县";
		arrCountry[i][j][k++] = "凌源市";

	j++;
	arrCity[i][j] = "大连";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长海县";
		arrCountry[i][j][k++] = "大连市";
		arrCountry[i][j][k++] = "普兰店市";
		arrCountry[i][j][k++] = "瓦房店市";
		arrCountry[i][j][k++] = "庄河市";

	j++;
	arrCity[i][j] = "丹东";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "丹东市";
		arrCountry[i][j][k++] = "东港市";
		arrCountry[i][j][k++] = "凤城市";
		arrCountry[i][j][k++] = "宽甸满族自治县";

	j++;
	arrCity[i][j] = "抚顺";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "抚顺市";
		arrCountry[i][j][k++] = "抚顺县";
		arrCountry[i][j][k++] = "清原满族自治县";
		arrCountry[i][j][k++] = "新宾满族自治县";

	j++;
	arrCity[i][j] = "阜新";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阜新蒙古族自治县";
		arrCountry[i][j][k++] = "阜新市";
		arrCountry[i][j][k++] = "彰武县";

	j++;
	arrCity[i][j] = "葫芦岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "葫芦岛市";
		arrCountry[i][j][k++] = "建昌县";
		arrCountry[i][j][k++] = "绥中县";
		arrCountry[i][j][k++] = "兴城市";

	j++;
	arrCity[i][j] = "锦州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "北宁市";
		arrCountry[i][j][k++] = "黑山县";
		arrCountry[i][j][k++] = "锦州市";
		arrCountry[i][j][k++] = "凌海市";
		arrCountry[i][j][k++] = "义县";

	j++;
	arrCity[i][j] = "辽阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "灯塔市";
		arrCountry[i][j][k++] = "辽阳市";
		arrCountry[i][j][k++] = "辽阳县";

	j++;
	arrCity[i][j] = "盘锦";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大洼县";
		arrCountry[i][j][k++] = "盘锦市";
		arrCountry[i][j][k++] = "盘山县";

	j++;
	arrCity[i][j] = "沈阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "法库县";
		arrCountry[i][j][k++] = "康平县";
		arrCountry[i][j][k++] = "辽中县";
		arrCountry[i][j][k++] = "沈阳市";
		arrCountry[i][j][k++] = "新民市";

	j++;
	arrCity[i][j] = "铁岭";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "昌图县";
		arrCountry[i][j][k++] = "调兵山市";
		arrCountry[i][j][k++] = "开原市";
		arrCountry[i][j][k++] = "铁岭市";
		arrCountry[i][j][k++] = "铁岭县";
		arrCountry[i][j][k++] = "西丰县";

	j++;
	arrCity[i][j] = "营口";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大石桥市";
		arrCountry[i][j][k++] = "盖州市";
		arrCountry[i][j][k++] = "营口市";

	j++;

i++;
arrProvince[i] = "内蒙古";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "阿拉善盟";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿拉善右旗";
		arrCountry[i][j][k++] = "阿拉善左旗";
		arrCountry[i][j][k++] = "额济纳旗";

	j++;
	arrCity[i][j] = "巴彦淖尔盟";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "杭锦后旗";
		arrCountry[i][j][k++] = "临河市";
		arrCountry[i][j][k++] = "乌拉特后旗";
		arrCountry[i][j][k++] = "乌拉特前旗";
		arrCountry[i][j][k++] = "乌拉特中旗";
		arrCountry[i][j][k++] = "五原县";
		arrCountry[i][j][k++] = "磴口县";

	j++;
	arrCity[i][j] = "包头";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "包头市";
		arrCountry[i][j][k++] = "达尔罕茂明安联合旗";
		arrCountry[i][j][k++] = "固阳县";
		arrCountry[i][j][k++] = "土默特右旗";

	j++;
	arrCity[i][j] = "赤峰";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿鲁科尔沁旗";
		arrCountry[i][j][k++] = "敖汉旗";
		arrCountry[i][j][k++] = "巴林右旗";
		arrCountry[i][j][k++] = "巴林左旗";
		arrCountry[i][j][k++] = "赤峰市";
		arrCountry[i][j][k++] = "喀喇沁旗";
		arrCountry[i][j][k++] = "克什克腾旗";
		arrCountry[i][j][k++] = "林西县";
		arrCountry[i][j][k++] = "宁城县";
		arrCountry[i][j][k++] = "翁牛特旗";

	j++;
	arrCity[i][j] = "鄂尔多斯";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "达拉特旗";
		arrCountry[i][j][k++] = "鄂尔多斯市";
		arrCountry[i][j][k++] = "鄂托克旗";
		arrCountry[i][j][k++] = "鄂托克前旗";
		arrCountry[i][j][k++] = "杭锦旗";
		arrCountry[i][j][k++] = "乌审旗";
		arrCountry[i][j][k++] = "伊金霍洛旗";
		arrCountry[i][j][k++] = "准格尔旗";

	j++;
	arrCity[i][j] = "呼和浩特";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "和林格尔县";
		arrCountry[i][j][k++] = "呼和浩特市";
		arrCountry[i][j][k++] = "清水河县";
		arrCountry[i][j][k++] = "土默特左旗";
		arrCountry[i][j][k++] = "托克托县";
		arrCountry[i][j][k++] = "武川县";

	j++;
	arrCity[i][j] = "呼伦贝尔";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿荣旗";
		arrCountry[i][j][k++] = "陈巴尔虎旗";
		arrCountry[i][j][k++] = "额尔古纳市";
		arrCountry[i][j][k++] = "鄂伦春自治旗";
		arrCountry[i][j][k++] = "鄂温克族自治旗";
		arrCountry[i][j][k++] = "根河市";
		arrCountry[i][j][k++] = "呼伦贝尔市";
		arrCountry[i][j][k++] = "满洲里市";
		arrCountry[i][j][k++] = "莫力达瓦达斡尔族自治旗";
		arrCountry[i][j][k++] = "新巴尔虎右旗";
		arrCountry[i][j][k++] = "新巴尔虎左旗";
		arrCountry[i][j][k++] = "牙克石市";
		arrCountry[i][j][k++] = "扎兰屯市";

	j++;
	arrCity[i][j] = "通辽";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "霍林郭勒市";
		arrCountry[i][j][k++] = "开鲁县";
		arrCountry[i][j][k++] = "科尔沁左翼后旗";
		arrCountry[i][j][k++] = "科尔沁左翼中旗";
		arrCountry[i][j][k++] = "库伦旗";
		arrCountry[i][j][k++] = "奈曼旗";
		arrCountry[i][j][k++] = "通辽市";
		arrCountry[i][j][k++] = "扎鲁特旗";

	j++;
	arrCity[i][j] = "乌海";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "乌海市";

	j++;
	arrCity[i][j] = "乌兰察布盟";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "察哈尔右翼后旗";
		arrCountry[i][j][k++] = "察哈尔右翼前旗";
		arrCountry[i][j][k++] = "察哈尔右翼中旗";
		arrCountry[i][j][k++] = "丰镇市";
		arrCountry[i][j][k++] = "化德县";
		arrCountry[i][j][k++] = "集宁市";
		arrCountry[i][j][k++] = "凉城县";
		arrCountry[i][j][k++] = "商都县";
		arrCountry[i][j][k++] = "四子王旗";
		arrCountry[i][j][k++] = "兴和县";
		arrCountry[i][j][k++] = "卓资县";

	j++;
	arrCity[i][j] = "锡林郭勒盟";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿巴嘎旗";
		arrCountry[i][j][k++] = "东乌珠穆沁旗";
		arrCountry[i][j][k++] = "多伦县";
		arrCountry[i][j][k++] = "二连浩特市";
		arrCountry[i][j][k++] = "苏尼特右旗";
		arrCountry[i][j][k++] = "苏尼特左旗";
		arrCountry[i][j][k++] = "太仆寺旗";
		arrCountry[i][j][k++] = "西乌珠穆沁旗";
		arrCountry[i][j][k++] = "锡林浩特市";
		arrCountry[i][j][k++] = "镶黄旗";
		arrCountry[i][j][k++] = "正蓝旗";
		arrCountry[i][j][k++] = "正镶白旗";

	j++;
	arrCity[i][j] = "兴安盟";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿尔山市";
		arrCountry[i][j][k++] = "科尔沁右翼前旗";
		arrCountry[i][j][k++] = "科尔沁右翼中旗";
		arrCountry[i][j][k++] = "突泉县";
		arrCountry[i][j][k++] = "乌兰浩特市";
		arrCountry[i][j][k++] = "扎赉特旗";

	j++;

i++;
arrProvince[i] = "宁夏";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "固原";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "固原市";
		arrCountry[i][j][k++] = "海原县";
		arrCountry[i][j][k++] = "隆德县";
		arrCountry[i][j][k++] = "彭阳县";
		arrCountry[i][j][k++] = "西吉县";
		arrCountry[i][j][k++] = "泾源县";

	j++;
	arrCity[i][j] = "石嘴山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "惠农县";
		arrCountry[i][j][k++] = "平罗县";
		arrCountry[i][j][k++] = "石嘴山市";
		arrCountry[i][j][k++] = "陶乐县";

	j++;
	arrCity[i][j] = "吴忠";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "青铜峡市";
		arrCountry[i][j][k++] = "同心县";
		arrCountry[i][j][k++] = "吴忠市";
		arrCountry[i][j][k++] = "盐池县";
		arrCountry[i][j][k++] = "中宁县";
		arrCountry[i][j][k++] = "中卫县";

	j++;
	arrCity[i][j] = "银川";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "贺兰县";
		arrCountry[i][j][k++] = "灵武市";
		arrCountry[i][j][k++] = "银川市";
		arrCountry[i][j][k++] = "永宁县";

	j++;

i++;
arrProvince[i] = "青海";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "果洛藏族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "班玛县";
		arrCountry[i][j][k++] = "达日县";
		arrCountry[i][j][k++] = "甘德县";
		arrCountry[i][j][k++] = "久治县";
		arrCountry[i][j][k++] = "玛多县";
		arrCountry[i][j][k++] = "玛沁县";

	j++;
	arrCity[i][j] = "海北藏族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "刚察县";
		arrCountry[i][j][k++] = "海晏县";
		arrCountry[i][j][k++] = "门源回族自治县";
		arrCountry[i][j][k++] = "祁连县";

	j++;
	arrCity[i][j] = "海东";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "互助土族自治";
		arrCountry[i][j][k++] = "化隆回族自治县";
		arrCountry[i][j][k++] = "乐都县";
		arrCountry[i][j][k++] = "民和回族土族自治县";
		arrCountry[i][j][k++] = "平安县";
		arrCountry[i][j][k++] = "循化撒拉族自治县";

	j++;
	arrCity[i][j] = "海南藏族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "共和县";
		arrCountry[i][j][k++] = "贵德县";
		arrCountry[i][j][k++] = "贵南县";
		arrCountry[i][j][k++] = "同德县";
		arrCountry[i][j][k++] = "兴海县";

	j++;
	arrCity[i][j] = "海西蒙古族藏族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "德令哈市";
		arrCountry[i][j][k++] = "都兰县";
		arrCountry[i][j][k++] = "格尔木市";
		arrCountry[i][j][k++] = "天峻县";
		arrCountry[i][j][k++] = "乌兰县";

	j++;
	arrCity[i][j] = "黄南藏族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "河南蒙古族自治县";
		arrCountry[i][j][k++] = "尖扎县";
		arrCountry[i][j][k++] = "同仁县";
		arrCountry[i][j][k++] = "泽库县";

	j++;
	arrCity[i][j] = "西宁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大通回族土族自治县";
		arrCountry[i][j][k++] = "西宁市";
		arrCountry[i][j][k++] = "湟源县";
		arrCountry[i][j][k++] = "湟中县";

	j++;
	arrCity[i][j] = "玉树藏族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "称多县";
		arrCountry[i][j][k++] = "囊谦县";
		arrCountry[i][j][k++] = "曲麻莱县";
		arrCountry[i][j][k++] = "玉树县";
		arrCountry[i][j][k++] = "杂多县";
		arrCountry[i][j][k++] = "治多县";

	j++;

i++;
arrProvince[i] = "山东";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "滨州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "滨州市";
		arrCountry[i][j][k++] = "博兴县";
		arrCountry[i][j][k++] = "惠民县";
		arrCountry[i][j][k++] = "无棣县";
		arrCountry[i][j][k++] = "阳信县";
		arrCountry[i][j][k++] = "沾化县";
		arrCountry[i][j][k++] = "邹平县";

	j++;
	arrCity[i][j] = "德州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "德州市";
		arrCountry[i][j][k++] = "乐陵市";
		arrCountry[i][j][k++] = "临邑县";
		arrCountry[i][j][k++] = "陵县";
		arrCountry[i][j][k++] = "宁津县";
		arrCountry[i][j][k++] = "平原县";
		arrCountry[i][j][k++] = "齐河县";
		arrCountry[i][j][k++] = "庆云县";
		arrCountry[i][j][k++] = "武城县";
		arrCountry[i][j][k++] = "夏津县";
		arrCountry[i][j][k++] = "禹城市";

	j++;
	arrCity[i][j] = "东营";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东营市";
		arrCountry[i][j][k++] = "广饶县";
		arrCountry[i][j][k++] = "垦利县";
		arrCountry[i][j][k++] = "利津县";

	j++;
	arrCity[i][j] = "菏泽";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "曹县";
		arrCountry[i][j][k++] = "成武县";
		arrCountry[i][j][k++] = "单县";
		arrCountry[i][j][k++] = "定陶县";
		arrCountry[i][j][k++] = "东明县";
		arrCountry[i][j][k++] = "菏泽市";
		arrCountry[i][j][k++] = "巨野县";
		arrCountry[i][j][k++] = "郓城县";
		arrCountry[i][j][k++] = "鄄城县";

	j++;
	arrCity[i][j] = "济南";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "济南市";
		arrCountry[i][j][k++] = "济阳县";
		arrCountry[i][j][k++] = "平阴县";
		arrCountry[i][j][k++] = "商河县";
		arrCountry[i][j][k++] = "章丘市";

	j++;
	arrCity[i][j] = "济宁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "济宁市";
		arrCountry[i][j][k++] = "嘉祥县";
		arrCountry[i][j][k++] = "金乡县";
		arrCountry[i][j][k++] = "梁山县";
		arrCountry[i][j][k++] = "曲阜市";
		arrCountry[i][j][k++] = "微山县";
		arrCountry[i][j][k++] = "鱼台县";
		arrCountry[i][j][k++] = "邹城市";
		arrCountry[i][j][k++] = "兖州市";
		arrCountry[i][j][k++] = "汶上县";
		arrCountry[i][j][k++] = "泗水县";

	j++;
	arrCity[i][j] = "莱芜";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "莱芜市";

	j++;
	arrCity[i][j] = "聊城";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东阿县";
		arrCountry[i][j][k++] = "高唐县";
		arrCountry[i][j][k++] = "冠县";
		arrCountry[i][j][k++] = "聊城市";
		arrCountry[i][j][k++] = "临清市";
		arrCountry[i][j][k++] = "阳谷县";
		arrCountry[i][j][k++] = "茌平县";
		arrCountry[i][j][k++] = "莘县";

	j++;
	arrCity[i][j] = "临沂";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "苍山县";
		arrCountry[i][j][k++] = "费县";
		arrCountry[i][j][k++] = "临沂市";
		arrCountry[i][j][k++] = "临沭县";
		arrCountry[i][j][k++] = "蒙阴县";
		arrCountry[i][j][k++] = "平邑县";
		arrCountry[i][j][k++] = "沂南县";
		arrCountry[i][j][k++] = "沂水县";
		arrCountry[i][j][k++] = "郯城县";
		arrCountry[i][j][k++] = "莒南县";

	j++;
	arrCity[i][j] = "青岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "即墨市";
		arrCountry[i][j][k++] = "胶南市";
		arrCountry[i][j][k++] = "胶州市";
		arrCountry[i][j][k++] = "莱西市";
		arrCountry[i][j][k++] = "平度市";
		arrCountry[i][j][k++] = "青岛市";

	j++;
	arrCity[i][j] = "日照";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "日照市";
		arrCountry[i][j][k++] = "五莲县";
		arrCountry[i][j][k++] = "莒县";

	j++;
	arrCity[i][j] = "泰安";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "东平县";
		arrCountry[i][j][k++] = "肥城市";
		arrCountry[i][j][k++] = "宁阳县";
		arrCountry[i][j][k++] = "泰安市";
		arrCountry[i][j][k++] = "新泰市";

	j++;
	arrCity[i][j] = "威海";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "荣成市";
		arrCountry[i][j][k++] = "乳山市";
		arrCountry[i][j][k++] = "威海市";
		arrCountry[i][j][k++] = "文登市";

	j++;
	arrCity[i][j] = "潍坊";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安丘市";
		arrCountry[i][j][k++] = "昌乐县";
		arrCountry[i][j][k++] = "昌邑市";
		arrCountry[i][j][k++] = "高密市";
		arrCountry[i][j][k++] = "临朐县";
		arrCountry[i][j][k++] = "青州市";
		arrCountry[i][j][k++] = "寿光市";
		arrCountry[i][j][k++] = "潍坊市";
		arrCountry[i][j][k++] = "诸城市";

	j++;
	arrCity[i][j] = "烟台";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长岛县";
		arrCountry[i][j][k++] = "海阳市";
		arrCountry[i][j][k++] = "莱阳市";
		arrCountry[i][j][k++] = "莱州市";
		arrCountry[i][j][k++] = "龙口市";
		arrCountry[i][j][k++] = "蓬莱市";
		arrCountry[i][j][k++] = "栖霞市";
		arrCountry[i][j][k++] = "烟台市";
		arrCountry[i][j][k++] = "招远市";

	j++;
	arrCity[i][j] = "枣庄";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "枣庄市";
		arrCountry[i][j][k++] = "滕州市";

	j++;
	arrCity[i][j] = "淄博";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "高青县";
		arrCountry[i][j][k++] = "桓台县";
		arrCountry[i][j][k++] = "沂源县";
		arrCountry[i][j][k++] = "淄博市";

	j++;

i++;
arrProvince[i] = "山西";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "长治";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长治市";
		arrCountry[i][j][k++] = "长治县";
		arrCountry[i][j][k++] = "长子县";
		arrCountry[i][j][k++] = "壶关县";
		arrCountry[i][j][k++] = "黎城县";
		arrCountry[i][j][k++] = "潞城市";
		arrCountry[i][j][k++] = "平顺县";
		arrCountry[i][j][k++] = "沁县";
		arrCountry[i][j][k++] = "沁源县";
		arrCountry[i][j][k++] = "屯留县";
		arrCountry[i][j][k++] = "武乡县";
		arrCountry[i][j][k++] = "襄垣县";

	j++;
	arrCity[i][j] = "大同";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大同市";
		arrCountry[i][j][k++] = "大同县";
		arrCountry[i][j][k++] = "广灵县";
		arrCountry[i][j][k++] = "浑源县";
		arrCountry[i][j][k++] = "灵丘县";
		arrCountry[i][j][k++] = "天镇县";
		arrCountry[i][j][k++] = "阳高县";
		arrCountry[i][j][k++] = "左云县";

	j++;
	arrCity[i][j] = "晋城";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "高平市";
		arrCountry[i][j][k++] = "晋城市";
		arrCountry[i][j][k++] = "陵川县";
		arrCountry[i][j][k++] = "沁水县";
		arrCountry[i][j][k++] = "阳城县";
		arrCountry[i][j][k++] = "泽州县";

	j++;
	arrCity[i][j] = "晋中";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "和顺县";
		arrCountry[i][j][k++] = "介休市";
		arrCountry[i][j][k++] = "晋中市";
		arrCountry[i][j][k++] = "灵石县";
		arrCountry[i][j][k++] = "平遥县";
		arrCountry[i][j][k++] = "祁县";
		arrCountry[i][j][k++] = "寿阳县";
		arrCountry[i][j][k++] = "太谷县";
		arrCountry[i][j][k++] = "昔阳县";
		arrCountry[i][j][k++] = "榆社县";
		arrCountry[i][j][k++] = "左权县";

	j++;
	arrCity[i][j] = "临汾";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安泽县";
		arrCountry[i][j][k++] = "大宁县";
		arrCountry[i][j][k++] = "汾西县";
		arrCountry[i][j][k++] = "浮山县";
		arrCountry[i][j][k++] = "古县";
		arrCountry[i][j][k++] = "洪洞县";
		arrCountry[i][j][k++] = "侯马市";
		arrCountry[i][j][k++] = "霍州市";
		arrCountry[i][j][k++] = "吉县";
		arrCountry[i][j][k++] = "临汾市";
		arrCountry[i][j][k++] = "蒲县";
		arrCountry[i][j][k++] = "曲沃县";
		arrCountry[i][j][k++] = "襄汾县";
		arrCountry[i][j][k++] = "乡宁县";
		arrCountry[i][j][k++] = "翼城县";
		arrCountry[i][j][k++] = "永和县";
		arrCountry[i][j][k++] = "隰县";

	j++;
	arrCity[i][j] = "吕梁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "吕梁市";
		arrCountry[i][j][k++] = "方山县";
		arrCountry[i][j][k++] = "汾阳市";
		arrCountry[i][j][k++] = "交城县";
		arrCountry[i][j][k++] = "交口县";
		arrCountry[i][j][k++] = "临县";
		arrCountry[i][j][k++] = "柳林县";
		arrCountry[i][j][k++] = "石楼县";
		arrCountry[i][j][k++] = "文水县";
		arrCountry[i][j][k++] = "孝义市";
		arrCountry[i][j][k++] = "兴县";
		arrCountry[i][j][k++] = "中阳县";
		arrCountry[i][j][k++] = "岚县";

	j++;
	arrCity[i][j] = "朔州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "怀仁县";
		arrCountry[i][j][k++] = "山阴县";
		arrCountry[i][j][k++] = "朔州市";
		arrCountry[i][j][k++] = "应县";
		arrCountry[i][j][k++] = "右玉县";

	j++;
	arrCity[i][j] = "太原";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "古交市";
		arrCountry[i][j][k++] = "娄烦县";
		arrCountry[i][j][k++] = "清徐县";
		arrCountry[i][j][k++] = "太原市";
		arrCountry[i][j][k++] = "阳曲县";

	j++;
	arrCity[i][j] = "忻州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "保德县";
		arrCountry[i][j][k++] = "代县";
		arrCountry[i][j][k++] = "定襄县";
		arrCountry[i][j][k++] = "繁峙县";
		arrCountry[i][j][k++] = "河曲县";
		arrCountry[i][j][k++] = "静乐县";
		arrCountry[i][j][k++] = "宁武县";
		arrCountry[i][j][k++] = "偏关县";
		arrCountry[i][j][k++] = "神池县";
		arrCountry[i][j][k++] = "五台县";
		arrCountry[i][j][k++] = "五寨县";
		arrCountry[i][j][k++] = "忻州市";
		arrCountry[i][j][k++] = "原平市";
		arrCountry[i][j][k++] = "岢岚县";

	j++;
	arrCity[i][j] = "阳泉";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "平定县";
		arrCountry[i][j][k++] = "阳泉市";
		arrCountry[i][j][k++] = "盂县";

	j++;
	arrCity[i][j] = "运城";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "河津市";
		arrCountry[i][j][k++] = "临猗县";
		arrCountry[i][j][k++] = "平陆县";
		arrCountry[i][j][k++] = "文昌市";

	j++;
	arrCity[i][j] = "五指山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "五指山市";
		arrCountry[i][j][k++] = "万荣县";
		arrCountry[i][j][k++] = "闻喜县";
		arrCountry[i][j][k++] = "夏县";
		arrCountry[i][j][k++] = "新绛县";
		arrCountry[i][j][k++] = "永济市";
		arrCountry[i][j][k++] = "垣曲县";
		arrCountry[i][j][k++] = "运城市";
		arrCountry[i][j][k++] = "芮城县";
		arrCountry[i][j][k++] = "绛县";
		arrCountry[i][j][k++] = "稷山县";

	j++;

i++;
arrProvince[i] = "陕西";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "安康";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安康市";
		arrCountry[i][j][k++] = "白河县";
		arrCountry[i][j][k++] = "汉阴县";
		arrCountry[i][j][k++] = "宁陕县";
		arrCountry[i][j][k++] = "平利县";
		arrCountry[i][j][k++] = "石泉县";
		arrCountry[i][j][k++] = "旬阳县";
		arrCountry[i][j][k++] = "镇坪县";
		arrCountry[i][j][k++] = "紫阳县";
		arrCountry[i][j][k++] = "岚皋县";

	j++;
	arrCity[i][j] = "宝鸡";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宝鸡市";
		arrCountry[i][j][k++] = "凤县";
		arrCountry[i][j][k++] = "凤翔县";
		arrCountry[i][j][k++] = "扶风县";
		arrCountry[i][j][k++] = "陇县";
		arrCountry[i][j][k++] = "眉县";
		arrCountry[i][j][k++] = "千阳县";
		arrCountry[i][j][k++] = "太白县";
		arrCountry[i][j][k++] = "岐山县";
		arrCountry[i][j][k++] = "麟游县";

	j++;
	arrCity[i][j] = "汉中";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "城固县";
		arrCountry[i][j][k++] = "佛坪县";
		arrCountry[i][j][k++] = "汉中市";
		arrCountry[i][j][k++] = "留坝县";
		arrCountry[i][j][k++] = "略阳县";
		arrCountry[i][j][k++] = "勉县";
		arrCountry[i][j][k++] = "南郑县";
		arrCountry[i][j][k++] = "宁强县";
		arrCountry[i][j][k++] = "西乡县";
		arrCountry[i][j][k++] = "洋县";
		arrCountry[i][j][k++] = "镇巴县";

	j++;
	arrCity[i][j] = "商洛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "丹凤县";
		arrCountry[i][j][k++] = "洛南县";
		arrCountry[i][j][k++] = "山阳县";
		arrCountry[i][j][k++] = "商洛市";
		arrCountry[i][j][k++] = "商南县";
		arrCountry[i][j][k++] = "镇安县";
		arrCountry[i][j][k++] = "柞水县";

	j++;
	arrCity[i][j] = "铜川";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "铜川市";
		arrCountry[i][j][k++] = "宜君县";

	j++;
	arrCity[i][j] = "渭南";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "白水县";
		arrCountry[i][j][k++] = "澄城县";
		arrCountry[i][j][k++] = "大荔县";
		arrCountry[i][j][k++] = "富平县";
		arrCountry[i][j][k++] = "韩城市";
		arrCountry[i][j][k++] = "合阳县";
		arrCountry[i][j][k++] = "华县";
		arrCountry[i][j][k++] = "华阴市";
		arrCountry[i][j][k++] = "蒲城县";
		arrCountry[i][j][k++] = "渭南市";
		arrCountry[i][j][k++] = "潼关县";

	j++;
	arrCity[i][j] = "西安";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "高陵县";
		arrCountry[i][j][k++] = "户县";
		arrCountry[i][j][k++] = "蓝田县";
		arrCountry[i][j][k++] = "西安市";
		arrCountry[i][j][k++] = "周至县";

	j++;
	arrCity[i][j] = "咸阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "彬县";
		arrCountry[i][j][k++] = "长武县";
		arrCountry[i][j][k++] = "淳化县";
		arrCountry[i][j][k++] = "礼泉县";
		arrCountry[i][j][k++] = "乾县";
		arrCountry[i][j][k++] = "三原县";
		arrCountry[i][j][k++] = "武功县";
		arrCountry[i][j][k++] = "咸阳市";
		arrCountry[i][j][k++] = "兴平市";
		arrCountry[i][j][k++] = "旬邑县";
		arrCountry[i][j][k++] = "永寿县";
		arrCountry[i][j][k++] = "泾阳县";

	j++;
	arrCity[i][j] = "延安";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安塞县";
		arrCountry[i][j][k++] = "富县";
		arrCountry[i][j][k++] = "甘泉县";
		arrCountry[i][j][k++] = "黄陵县";
		arrCountry[i][j][k++] = "黄龙县";
		arrCountry[i][j][k++] = "洛川县";
		arrCountry[i][j][k++] = "吴旗县";
		arrCountry[i][j][k++] = "延安市";
		arrCountry[i][j][k++] = "延长县";
		arrCountry[i][j][k++] = "延川县";
		arrCountry[i][j][k++] = "宜川县";
		arrCountry[i][j][k++] = "志丹县";
		arrCountry[i][j][k++] = "子长县";

	j++;
	arrCity[i][j] = "榆林";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "定边县";
		arrCountry[i][j][k++] = "府谷县";
		arrCountry[i][j][k++] = "横山县";
		arrCountry[i][j][k++] = "佳县";
		arrCountry[i][j][k++] = "靖边县";
		arrCountry[i][j][k++] = "米脂县";
		arrCountry[i][j][k++] = "清涧县";
		arrCountry[i][j][k++] = "神木县";
		arrCountry[i][j][k++] = "绥德县";
		arrCountry[i][j][k++] = "吴堡县";
		arrCountry[i][j][k++] = "榆林市";
		arrCountry[i][j][k++] = "子洲县";

	j++;

i++;
arrProvince[i] = "上海";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "上海";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "崇明县";
		arrCountry[i][j][k++] = "上海市";

	j++;

i++;
arrProvince[i] = "四川";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "阿坝藏族羌族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿坝县";
		arrCountry[i][j][k++] = "黑水县";
		arrCountry[i][j][k++] = "红原县";
		arrCountry[i][j][k++] = "金川县";
		arrCountry[i][j][k++] = "九寨沟县";
		arrCountry[i][j][k++] = "理县";
		arrCountry[i][j][k++] = "马尔康县";
		arrCountry[i][j][k++] = "茂县";
		arrCountry[i][j][k++] = "壤塘县";
		arrCountry[i][j][k++] = "若尔盖县";
		arrCountry[i][j][k++] = "松潘县";
		arrCountry[i][j][k++] = "小金县";
		arrCountry[i][j][k++] = "汶川县";

	j++;
	arrCity[i][j] = "巴中";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "巴中市";
		arrCountry[i][j][k++] = "南江县";
		arrCountry[i][j][k++] = "平昌县";
		arrCountry[i][j][k++] = "通江县";

	j++;
	arrCity[i][j] = "成都";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "成都市";
		arrCountry[i][j][k++] = "崇州市";
		arrCountry[i][j][k++] = "大邑县";
		arrCountry[i][j][k++] = "都江堰市";
		arrCountry[i][j][k++] = "金堂县";
		arrCountry[i][j][k++] = "彭州市";
		arrCountry[i][j][k++] = "蒲江县";
		arrCountry[i][j][k++] = "双流县";
		arrCountry[i][j][k++] = "新津县";
		arrCountry[i][j][k++] = "邛崃市";
		arrCountry[i][j][k++] = "郫县";

	j++;
	arrCity[i][j] = "达州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "达县";
		arrCountry[i][j][k++] = "达州市";
		arrCountry[i][j][k++] = "大竹县";
		arrCountry[i][j][k++] = "开江县";
		arrCountry[i][j][k++] = "渠县";
		arrCountry[i][j][k++] = "万源市";
		arrCountry[i][j][k++] = "宣汉县";

	j++;
	arrCity[i][j] = "德阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "德阳市";
		arrCountry[i][j][k++] = "广汉市";
		arrCountry[i][j][k++] = "罗江县";
		arrCountry[i][j][k++] = "绵竹市";
		arrCountry[i][j][k++] = "什邡市";
		arrCountry[i][j][k++] = "中江县";

	j++;
	arrCity[i][j] = "甘孜藏族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "巴塘县";
		arrCountry[i][j][k++] = "白玉县";
		arrCountry[i][j][k++] = "丹巴县";
		arrCountry[i][j][k++] = "稻城县";
		arrCountry[i][j][k++] = "道孚县";
		arrCountry[i][j][k++] = "德格县";
		arrCountry[i][j][k++] = "得荣县";
		arrCountry[i][j][k++] = "甘孜县";
		arrCountry[i][j][k++] = "九龙县";
		arrCountry[i][j][k++] = "康定县";
		arrCountry[i][j][k++] = "理塘县";
		arrCountry[i][j][k++] = "炉霍县";
		arrCountry[i][j][k++] = "南宫市";
		arrCountry[i][j][k++] = "南和县";
		arrCountry[i][j][k++] = "内丘县";
		arrCountry[i][j][k++] = "宁晋县";
		arrCountry[i][j][k++] = "平乡县";
		arrCountry[i][j][k++] = "清河县";
		arrCountry[i][j][k++] = "任县";
		arrCountry[i][j][k++] = "沙河市";
		arrCountry[i][j][k++] = "威县";
		arrCountry[i][j][k++] = "新河县";
		arrCountry[i][j][k++] = "邢台市";
		arrCountry[i][j][k++] = "邢台县";

	j++;
	arrCity[i][j] = "张家口";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "赤城县";
		arrCountry[i][j][k++] = "崇礼县";
		arrCountry[i][j][k++] = "沽源县";
		arrCountry[i][j][k++] = "怀安县";
		arrCountry[i][j][k++] = "怀来县";
		arrCountry[i][j][k++] = "康保县";
		arrCountry[i][j][k++] = "色达县";
		arrCountry[i][j][k++] = "石渠县";
		arrCountry[i][j][k++] = "乡城县";
		arrCountry[i][j][k++] = "新龙县";
		arrCountry[i][j][k++] = "雅江县";
		arrCountry[i][j][k++] = "泸定县";

	j++;
	arrCity[i][j] = "广安";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "广安市";
		arrCountry[i][j][k++] = "华蓥市";
		arrCountry[i][j][k++] = "邻水县";
		arrCountry[i][j][k++] = "武胜县";
		arrCountry[i][j][k++] = "岳池县";

	j++;
	arrCity[i][j] = "广元";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "苍溪县";
		arrCountry[i][j][k++] = "广元市";
		arrCountry[i][j][k++] = "剑阁县";
		arrCountry[i][j][k++] = "青川县";
		arrCountry[i][j][k++] = "旺苍县";

	j++;
	arrCity[i][j] = "乐山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "峨边彝族自治县";
		arrCountry[i][j][k++] = "峨眉山市";
		arrCountry[i][j][k++] = "夹江县";
		arrCountry[i][j][k++] = "井研县";
		arrCountry[i][j][k++] = "乐山市";
		arrCountry[i][j][k++] = "马边彝族自治县";
		arrCountry[i][j][k++] = "沐川县";
		arrCountry[i][j][k++] = "犍为县";

	j++;
	arrCity[i][j] = "凉山彝族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "布拖县";
		arrCountry[i][j][k++] = "德昌县";
		arrCountry[i][j][k++] = "甘洛县";
		arrCountry[i][j][k++] = "会东县";
		arrCountry[i][j][k++] = "会理县";
		arrCountry[i][j][k++] = "金阳县";
		arrCountry[i][j][k++] = "雷波县";
		arrCountry[i][j][k++] = "美姑县";
		arrCountry[i][j][k++] = "冕宁县";
		arrCountry[i][j][k++] = "木里藏族自治县";
		arrCountry[i][j][k++] = "宁南县";
		arrCountry[i][j][k++] = "普格县";
		arrCountry[i][j][k++] = "西昌市";
		arrCountry[i][j][k++] = "喜德县";
		arrCountry[i][j][k++] = "盐源县";
		arrCountry[i][j][k++] = "越西县";
		arrCountry[i][j][k++] = "昭觉县";

	j++;
	arrCity[i][j] = "眉山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "丹棱县";
		arrCountry[i][j][k++] = "洪雅县";
		arrCountry[i][j][k++] = "眉山市";
		arrCountry[i][j][k++] = "彭山县";
		arrCountry[i][j][k++] = "青神县";
		arrCountry[i][j][k++] = "仁寿县";

	j++;
	arrCity[i][j] = "绵阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安县";
		arrCountry[i][j][k++] = "北川羌族自治县";
		arrCountry[i][j][k++] = "江油市";
		arrCountry[i][j][k++] = "绵阳市";
		arrCountry[i][j][k++] = "平武县";
		arrCountry[i][j][k++] = "三台县";
		arrCountry[i][j][k++] = "盐亭县";
		arrCountry[i][j][k++] = "梓潼县";

	j++;
	arrCity[i][j] = "南充";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "南部县";
		arrCountry[i][j][k++] = "南充市";
		arrCountry[i][j][k++] = "蓬安县";
		arrCountry[i][j][k++] = "西充县";
		arrCountry[i][j][k++] = "仪陇县";
		arrCountry[i][j][k++] = "营山县";
		arrCountry[i][j][k++] = "阆中市";

	j++;
	arrCity[i][j] = "内江";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "隆昌县";
		arrCountry[i][j][k++] = "内江市";
		arrCountry[i][j][k++] = "威远县";
		arrCountry[i][j][k++] = "资中县";

	j++;
	arrCity[i][j] = "攀枝花";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "米易县";
		arrCountry[i][j][k++] = "攀枝花市";
		arrCountry[i][j][k++] = "盐边县";

	j++;
	arrCity[i][j] = "遂宁";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "大英县";
		arrCountry[i][j][k++] = "蓬溪县";
		arrCountry[i][j][k++] = "射洪县";
		arrCountry[i][j][k++] = "遂宁市";

	j++;
	arrCity[i][j] = "雅安";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宝兴县";
		arrCountry[i][j][k++] = "汉源县";
		arrCountry[i][j][k++] = "芦山县";
		arrCountry[i][j][k++] = "名山县";
		arrCountry[i][j][k++] = "黄陵县";
		arrCountry[i][j][k++] = "黄龙县";
		arrCountry[i][j][k++] = "洛川县";
		arrCountry[i][j][k++] = "吴旗县";
		arrCountry[i][j][k++] = "延安市";
		arrCountry[i][j][k++] = "延长县";
		arrCountry[i][j][k++] = "延川县";
		arrCountry[i][j][k++] = "宜川县";
		arrCountry[i][j][k++] = "志丹县";
		arrCountry[i][j][k++] = "子长县";
		arrCountry[i][j][k++] = "陕西石棉县";
		arrCountry[i][j][k++] = "天全县";
		arrCountry[i][j][k++] = "雅安市";
		arrCountry[i][j][k++] = "荥经县";

	j++;
	arrCity[i][j] = "宜宾";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "长宁县";
		arrCountry[i][j][k++] = "高县";
		arrCountry[i][j][k++] = "江安县";
		arrCountry[i][j][k++] = "南溪县";
		arrCountry[i][j][k++] = "屏山县";
		arrCountry[i][j][k++] = "兴文县";
		arrCountry[i][j][k++] = "宜宾市";
		arrCountry[i][j][k++] = "宜宾县";
		arrCountry[i][j][k++] = "珙县";
		arrCountry[i][j][k++] = "筠连县";

	j++;
	arrCity[i][j] = "资阳";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安岳县";
		arrCountry[i][j][k++] = "简阳市";
		arrCountry[i][j][k++] = "乐至县";
		arrCountry[i][j][k++] = "资阳市";

	j++;
	arrCity[i][j] = "自贡";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "富顺县";
		arrCountry[i][j][k++] = "荣县";
		arrCountry[i][j][k++] = "自贡市";

	j++;
	arrCity[i][j] = "泸州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "古蔺县";
		arrCountry[i][j][k++] = "合江县";
		arrCountry[i][j][k++] = "叙永县";
		arrCountry[i][j][k++] = "泸县";
		arrCountry[i][j][k++] = "泸州市";

	j++;

i++;
arrProvince[i] = "天津";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "天津";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "蓟县";
		arrCountry[i][j][k++] = "静海县";
		arrCountry[i][j][k++] = "宁河县";
		arrCountry[i][j][k++] = "天津市";

	j++;

i++;
arrProvince[i] = "西藏";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "阿里";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "措勤县";
		arrCountry[i][j][k++] = "噶尔县";
		arrCountry[i][j][k++] = "丹棱县";
		arrCountry[i][j][k++] = "洪雅县";
		arrCountry[i][j][k++] = "眉山市";
		arrCountry[i][j][k++] = "改则县";
		arrCountry[i][j][k++] = "革吉县";
		arrCountry[i][j][k++] = "普兰县";
		arrCountry[i][j][k++] = "日土县";
		arrCountry[i][j][k++] = "札达县";

	j++;
	arrCity[i][j] = "昌都";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "八宿县";
		arrCountry[i][j][k++] = "边坝县";
		arrCountry[i][j][k++] = "察雅县";
		arrCountry[i][j][k++] = "昌都县";
		arrCountry[i][j][k++] = "丁青县";
		arrCountry[i][j][k++] = "贡觉县";
		arrCountry[i][j][k++] = "江达县";
		arrCountry[i][j][k++] = "类乌齐县";
		arrCountry[i][j][k++] = "洛隆县";
		arrCountry[i][j][k++] = "芒康县";
		arrCountry[i][j][k++] = "左贡县";

	j++;
	arrCity[i][j] = "拉萨";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "达孜县";
		arrCountry[i][j][k++] = "当雄县";
		arrCountry[i][j][k++] = "堆龙德庆县";
		arrCountry[i][j][k++] = "拉萨市";
		arrCountry[i][j][k++] = "林周县";
		arrCountry[i][j][k++] = "墨竹工卡县";
		arrCountry[i][j][k++] = "尼木县";
		arrCountry[i][j][k++] = "曲水县";

	j++;
	arrCity[i][j] = "林芝";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "波密县";
		arrCountry[i][j][k++] = "察隅县";
		arrCountry[i][j][k++] = "工布江达县";
		arrCountry[i][j][k++] = "朗县";
		arrCountry[i][j][k++] = "林芝县";
		arrCountry[i][j][k++] = "米林县";
		arrCountry[i][j][k++] = "墨脱县";

	j++;
	arrCity[i][j] = "那曲";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "安多县";
		arrCountry[i][j][k++] = "巴青县";
		arrCountry[i][j][k++] = "班戈县";
		arrCountry[i][j][k++] = "比如县";
		arrCountry[i][j][k++] = "嘉黎县";
		arrCountry[i][j][k++] = "那曲县";
		arrCountry[i][j][k++] = "尼玛县";
		arrCountry[i][j][k++] = "聂荣县";
		arrCountry[i][j][k++] = "申扎县";
		arrCountry[i][j][k++] = "索县";

	j++;
	arrCity[i][j] = "日喀则";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "昂仁县";
		arrCountry[i][j][k++] = "白朗县";
		arrCountry[i][j][k++] = "定结县";
		arrCountry[i][j][k++] = "定日县";
		arrCountry[i][j][k++] = "岗巴县";
		arrCountry[i][j][k++] = "吉隆县";
		arrCountry[i][j][k++] = "江孜县";
		arrCountry[i][j][k++] = "康马县";
		arrCountry[i][j][k++] = "拉孜县";
		arrCountry[i][j][k++] = "南木林县";
		arrCountry[i][j][k++] = "聂拉木县";
		arrCountry[i][j][k++] = "仁布县";
		arrCountry[i][j][k++] = "日喀则市";
		arrCountry[i][j][k++] = "萨嘎县";
		arrCountry[i][j][k++] = "萨迦县";
		arrCountry[i][j][k++] = "谢通门县";
		arrCountry[i][j][k++] = "亚东县";
		arrCountry[i][j][k++] = "仲巴县";

	j++;
	arrCity[i][j] = "山南";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "措美县";
		arrCountry[i][j][k++] = "错那县";
		arrCountry[i][j][k++] = "贡嘎县";
		arrCountry[i][j][k++] = "加查县";
		arrCountry[i][j][k++] = "浪卡子县";
		arrCountry[i][j][k++] = "隆子县";
		arrCountry[i][j][k++] = "洛扎县";
		arrCountry[i][j][k++] = "乃东县";
		arrCountry[i][j][k++] = "琼结县";
		arrCountry[i][j][k++] = "曲松县";
		arrCountry[i][j][k++] = "桑日县";
		arrCountry[i][j][k++] = "扎囊县";

	j++;

i++;
arrProvince[i] = "新疆";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "阿克苏";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿克苏市";
		arrCountry[i][j][k++] = "阿瓦提县";
		arrCountry[i][j][k++] = "拜城县";
		arrCountry[i][j][k++] = "柯坪县";
		arrCountry[i][j][k++] = "库车县";
		arrCountry[i][j][k++] = "沙雅县";
		arrCountry[i][j][k++] = "温宿县";
		arrCountry[i][j][k++] = "乌什县";
		arrCountry[i][j][k++] = "新和县";

	j++;
	arrCity[i][j] = "阿拉尔";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿拉尔市";

	j++;
	arrCity[i][j] = "巴音郭楞蒙古自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "博湖县";
		arrCountry[i][j][k++] = "和静县";
		arrCountry[i][j][k++] = "和硕县";
		arrCountry[i][j][k++] = "库尔勒市";
		arrCountry[i][j][k++] = "轮台县";
		arrCountry[i][j][k++] = "且末县";
		arrCountry[i][j][k++] = "若羌县";
		arrCountry[i][j][k++] = "尉犁县";
		arrCountry[i][j][k++] = "焉耆回族自治县";

	j++;
	arrCity[i][j] = "博尔塔拉蒙古自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "博乐市";
		arrCountry[i][j][k++] = "精河县";
		arrCountry[i][j][k++] = "温泉县";

	j++;
	arrCity[i][j] = "昌吉回族自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "昌吉市";
		arrCountry[i][j][k++] = "阜康市";
		arrCountry[i][j][k++] = "呼图壁县";
		arrCountry[i][j][k++] = "吉木萨尔县";
		arrCountry[i][j][k++] = "玛纳斯县";
		arrCountry[i][j][k++] = "米泉市";
		arrCountry[i][j][k++] = "木垒哈萨克自治县";
		arrCountry[i][j][k++] = "奇台县";

	j++;
	arrCity[i][j] = "哈密";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "巴里坤哈萨克自治县";
		arrCountry[i][j][k++] = "哈密市";
		arrCountry[i][j][k++] = "伊吾县";

	j++;
	arrCity[i][j] = "和田";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "策勒县";
		arrCountry[i][j][k++] = "和田市";
		arrCountry[i][j][k++] = "和田县";
		arrCountry[i][j][k++] = "洛浦县";
		arrCountry[i][j][k++] = "民丰县";
		arrCountry[i][j][k++] = "墨玉县";
		arrCountry[i][j][k++] = "皮山县";
		arrCountry[i][j][k++] = "于田县";

	j++;
	arrCity[i][j] = "喀什";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "巴楚县";
		arrCountry[i][j][k++] = "喀什市";
		arrCountry[i][j][k++] = "麦盖提县";
		arrCountry[i][j][k++] = "莎车县";
		arrCountry[i][j][k++] = "疏附县";
		arrCountry[i][j][k++] = "疏勒县";
		arrCountry[i][j][k++] = "塔什库尔干塔吉克自治县";
		arrCountry[i][j][k++] = "叶城县";
		arrCountry[i][j][k++] = "英吉沙县";
		arrCountry[i][j][k++] = "岳普湖县";
		arrCountry[i][j][k++] = "泽普县";
		arrCountry[i][j][k++] = "伽师县";

	j++;
	arrCity[i][j] = "克拉玛依";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "克拉玛依市";

	j++;
	arrCity[i][j] = "克孜勒苏柯尔克孜自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿合奇县";
		arrCountry[i][j][k++] = "阿克陶县";
		arrCountry[i][j][k++] = "阿图什市";
		arrCountry[i][j][k++] = "乌恰县";

	j++;
	arrCity[i][j] = "石河子";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "石河子市";

	j++;
	arrCity[i][j] = "图木舒克";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "图木舒克市";

	j++;
	arrCity[i][j] = "吐鲁番";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "吐鲁番市";
		arrCountry[i][j][k++] = "托克逊县";
		arrCountry[i][j][k++] = "鄯善县";

	j++;
	arrCity[i][j] = "乌鲁木齐";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "乌鲁木齐市";
		arrCountry[i][j][k++] = "乌鲁木齐县";

	j++;
	arrCity[i][j] = "五家渠";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "五家渠市";

	j++;
	arrCity[i][j] = "伊犁哈萨克自治州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "阿勒泰市";
		arrCountry[i][j][k++] = "布尔津县";
		arrCountry[i][j][k++] = "察布查尔锡伯自治县";
		arrCountry[i][j][k++] = "额敏县";
		arrCountry[i][j][k++] = "福海县";
		arrCountry[i][j][k++] = "富蕴县";
		arrCountry[i][j][k++] = "巩留县";
		arrCountry[i][j][k++] = "哈巴河县";
		arrCountry[i][j][k++] = "和布克赛尔蒙古自治县";
		arrCountry[i][j][k++] = "霍城县";
		arrCountry[i][j][k++] = "吉木乃县";
		arrCountry[i][j][k++] = "奎屯市";
		arrCountry[i][j][k++] = "尼勒克县";
		arrCountry[i][j][k++] = "青河县";
		arrCountry[i][j][k++] = "沙湾县";
		arrCountry[i][j][k++] = "塔城市";
		arrCountry[i][j][k++] = "特克斯县";
		arrCountry[i][j][k++] = "托里县";
		arrCountry[i][j][k++] = "乌苏市";
		arrCountry[i][j][k++] = "新源县";
		arrCountry[i][j][k++] = "伊宁市";
		arrCountry[i][j][k++] = "伊宁县";
		arrCountry[i][j][k++] = "裕民县";
		arrCountry[i][j][k++] = "昭苏县";

	j++;

i++;
arrProvince[i] = "浙江";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "杭州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "杭州市";
		arrCountry[i][j][k++] = "淳安县";
		arrCountry[i][j][k++] = "富阳市";
		arrCountry[i][j][k++] = "建德市";
		arrCountry[i][j][k++] = "临安市";
		arrCountry[i][j][k++] = "桐庐县";

	j++;
	arrCity[i][j] = "湖州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "湖州市";
		arrCountry[i][j][k++] = "安吉县";
		arrCountry[i][j][k++] = "长兴县";
		arrCountry[i][j][k++] = "德清县";

	j++;
	arrCity[i][j] = "嘉兴";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "嘉兴市";
		arrCountry[i][j][k++] = "海宁市";
		arrCountry[i][j][k++] = "海盐县";
		arrCountry[i][j][k++] = "嘉善县";
		arrCountry[i][j][k++] = "平湖市";
		arrCountry[i][j][k++] = "桐乡市";

	j++;
	arrCity[i][j] = "金华";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "金华市";
		arrCountry[i][j][k++] = "东阳市";
		arrCountry[i][j][k++] = "兰溪市";
		arrCountry[i][j][k++] = "磐安县";
		arrCountry[i][j][k++] = "浦江县";
		arrCountry[i][j][k++] = "武义县";
		arrCountry[i][j][k++] = "义乌市";
		arrCountry[i][j][k++] = "永康市";

	j++;
	arrCity[i][j] = "丽水";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "丽水市";
		arrCountry[i][j][k++] = "景宁县";
		arrCountry[i][j][k++] = "龙泉市";
		arrCountry[i][j][k++] = "青田县";
		arrCountry[i][j][k++] = "庆元县";
		arrCountry[i][j][k++] = "松阳县";
		arrCountry[i][j][k++] = "遂昌县";
		arrCountry[i][j][k++] = "云和县";
		arrCountry[i][j][k++] = "缙云县";

	j++;
	arrCity[i][j] = "宁波";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "宁波市";
		arrCountry[i][j][k++] = "慈溪市";
		arrCountry[i][j][k++] = "奉化市";
		arrCountry[i][j][k++] = "宁海县";
		arrCountry[i][j][k++] = "象山县";
		arrCountry[i][j][k++] = "余姚市";

	j++;
	arrCity[i][j] = "绍兴";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "绍兴市";
		arrCountry[i][j][k++] = "上虞市";
		arrCountry[i][j][k++] = "新昌县";
		arrCountry[i][j][k++] = "诸暨市";
		arrCountry[i][j][k++] = "嵊州市";

	j++;
	arrCity[i][j] = "台州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "台州市";
		arrCountry[i][j][k++] = "椒江区";
		arrCountry[i][j][k++] = "黄岩区";
		arrCountry[i][j][k++] = "路桥区";
		arrCountry[i][j][k++] = "临海市";
		arrCountry[i][j][k++] = "温岭市";
		arrCountry[i][j][k++] = "三门县";
		arrCountry[i][j][k++] = "天台县";
		arrCountry[i][j][k++] = "仙居县";
		arrCountry[i][j][k++] = "玉环县";

	j++;
	arrCity[i][j] = "温州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "温州市";
		arrCountry[i][j][k++] = "苍南县";
		arrCountry[i][j][k++] = "洞头县";
		arrCountry[i][j][k++] = "乐清市";
		arrCountry[i][j][k++] = "平阳县";
		arrCountry[i][j][k++] = "瑞安市";
		arrCountry[i][j][k++] = "泰顺县";
		arrCountry[i][j][k++] = "文成县";
		arrCountry[i][j][k++] = "永嘉县";

	j++;
	arrCity[i][j] = "舟山";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "舟山市";
		arrCountry[i][j][k++] = "岱山县";
		arrCountry[i][j][k++] = "嵊泗县";

	j++;
	arrCity[i][j] = "衢州";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "衢州市";
		arrCountry[i][j][k++] = "常山县";
		arrCountry[i][j][k++] = "江山市";
		arrCountry[i][j][k++] = "开化县";
		arrCountry[i][j][k++] = "龙游县";

	j++;

i++;
arrProvince[i] = "重庆";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "重庆";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "城口县";
		arrCountry[i][j][k++] = "大足县";
		arrCountry[i][j][k++] = "垫江县";
		arrCountry[i][j][k++] = "丰都县";
		arrCountry[i][j][k++] = "奉节县";
		arrCountry[i][j][k++] = "合川市";
		arrCountry[i][j][k++] = "江津市";
		arrCountry[i][j][k++] = "开县";
		arrCountry[i][j][k++] = "梁平县";
		arrCountry[i][j][k++] = "南川市";
		arrCountry[i][j][k++] = "彭水苗族土家族自治县";
		arrCountry[i][j][k++] = "荣昌县";
		arrCountry[i][j][k++] = "石柱土家族自治县";
		arrCountry[i][j][k++] = "铜梁县";
		arrCountry[i][j][k++] = "巫山县";
		arrCountry[i][j][k++] = "巫溪县";
		arrCountry[i][j][k++] = "武隆县";
		arrCountry[i][j][k++] = "秀山土家族苗族自治县";
		arrCountry[i][j][k++] = "永川市";
		arrCountry[i][j][k++] = "酉阳土家族苗族自治县";
		arrCountry[i][j][k++] = "云阳县";
		arrCountry[i][j][k++] = "忠县";
		arrCountry[i][j][k++] = "重庆市";
		arrCountry[i][j][k++] = "潼南县";
		arrCountry[i][j][k++] = "璧山县";
		arrCountry[i][j][k++] = "綦江县";

	j++;

i++;
arrProvince[i] = "香港";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "香港岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "中西区";
		arrCountry[i][j][k++] = "湾仔区";
		arrCountry[i][j][k++] = "东区";
		arrCountry[i][j][k++] = "南区";

	j++;
	arrCity[i][j] = "九龙半岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "油尖旺区";
		arrCountry[i][j][k++] = "深水涉区";
		arrCountry[i][j][k++] = "九龙城区";
		arrCountry[i][j][k++] = "黄大仙区";
		arrCountry[i][j][k++] = "观塘区";

	j++;
	arrCity[i][j] = "新界本土";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "沙田区";
		arrCountry[i][j][k++] = "大埔区";
		arrCountry[i][j][k++] = "北区";
		arrCountry[i][j][k++] = "荃湾区";
		arrCountry[i][j][k++] = "葵青区";
		arrCountry[i][j][k++] = "屯门区";
		arrCountry[i][j][k++] = "元朗区";
		arrCountry[i][j][k++] = "西贡区";

	j++;
	arrCity[i][j] = "新界离岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "离岛区";

	j++;

i++;
arrProvince[i] = "澳门";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "澳门半岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "圣安多尼堂区(花王堂区)";
		arrCountry[i][j][k++] = "望德堂区";
		arrCountry[i][j][k++] = "圣老楞佐堂区(风顺堂区)";
		arrCountry[i][j][k++] = "大堂堂区";
		arrCountry[i][j][k++] = "花地玛堂区";

	j++;
	arrCity[i][j] = "氹仔岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "氹仔";

	j++;
	arrCity[i][j] = "路环岛";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "路环";

	j++;

i++;
arrProvince[i] = "台湾";
arrCity[i] = new Array();
arrCountry[i] = new Array();

	j = 0;
	arrCity[i][j] = "台湾";
	arrCountry[i][j] = new Array();

		k = 0;
		arrCountry[i][j][k++] = "台湾";

	j++;

i++;

