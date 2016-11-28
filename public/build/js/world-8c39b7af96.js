$(document).ready(function(){function t(t){return t>1e9?Math.round(t/1e9*10)/10+"B":t>1e6?Math.round(t/1e6*10)/10+"M":t>1e3?Math.round(t/1e3*10)/10+"K":t}$.ajax({type:"POST",url:"/report",data:{type:"world",_token:$('meta[name="csrf-token"]').attr("content")},success:function(e){var a={data0:"Location",data1:"Member",label0:"label 0",label1:"label 1",color0:"#80a000",color1:"#a02800",width:$("#canvas-svg").innerWidth(),height:.85*$("#canvas-svg").innerWidth()};$("#count").text("총 참여자: "+e[0].Total+" / 광화문 참여자: "+e[0].HotPlace);var o=a.width,n=a.height,r=a.data0,i=a.data1,s=d3.geoMercator().scale((o+1)/2/Math.PI).translate([o/2,n/2]).precision(.1),l=d3.geoPath().projection(s),c=d3.geoGraticule();$("#canvas-svg").empty();var p=d3.select("#canvas-svg").append("svg").attr("width",o).attr("height",n);p.append("path").datum(c).attr("class","graticule").attr("d",l);var d={};e.forEach(function(t){d[t[r]]=+t[i]});var u=d3.scaleLinear().domain([1,d3.max(e,function(t){return+t[i]})]).range([a.color0,a.color1]);d3.json("/topo/world-min.json",function(e,o){var n=topojson.feature(o,o.objects.countries).features;p.append("path").datum(c).attr("class","choropleth").attr("d",l);var r=p.append("g");r.append("path").datum({type:"LineString",coordinates:[[-180,0],[-90,0],[0,0],[90,0],[180,0]]}).attr("class","equator").attr("d",l);var i=r.selectAll(".country").data(n);i.enter().insert("path").attr("class","country").attr("d",l).attr("id",function(t,e){return t.id}).attr("title",function(t){return t.properties.name}).style("fill",function(t){if(d[t.properties.name]){var e=u(d[t.properties.name]);return e}return"#ccc"}).on("mousemove",function(e){var a="";a+='<div class="tooltip_kv">',a+='<span class="tooltip_key">',a+=e.properties.name,a+="</span>",a+='<span class="tooltip_value">',a+=d[e.properties.name]?t(d[e.properties.name]):"",a+="",a+="</span>",a+="</div>",$("#tooltip-container").html(a),$(this).attr("fill-opacity","0.8"),$("#tooltip-container").show();var o=(d3.mouse(this),$(".choropleth")[0].getBoundingClientRect().width);if(d3.event.pageX<o/2)d3.select("#tooltip-container").style("top",d3.event.layerY+15+"px").style("left",d3.event.layerX+15+"px");else{var n=$("#tooltip-container").width();d3.select("#tooltip-container").style("top",d3.event.layerY+15+"px").style("left",d3.event.layerX-n-30+"px")}}).on("mouseout",function(){$(this).attr("fill-opacity","1.0"),$("#tooltip-container").hide()}),r.append("path").datum(topojson.mesh(o,o.objects.countries,function(t,e){return t!==e})).attr("class","boundary").attr("d",l),p.attr("height",2.2*a.height/3)}),d3.select(self.frameElement).style("height",2.3*n/3+"px")}})});