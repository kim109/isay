$(document).ready(function() {
    function valueFormat(d) {
        if (d > 1000000000) {
            return Math.round(d / 1000000000 * 10) / 10 + "B";
        } else if (d > 1000000) {
            return Math.round(d / 1000000 * 10) / 10 + "M";
        } else if (d > 1000) {
            return Math.round(d / 1000 * 10) / 10 + "K";
        } else {
            return d;
        }
    }

    $.ajax({
        type: "POST",
        url: "/report",
        data: {type: "world", _token:  $('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
            var config = {
                "data0":"Location", "data1":"Member",
                "label0":"label 0","label1":"label 1",
                "color0":"#80a000","color1":"#a02800",
                "width":$('#canvas-svg').innerWidth(),
                "height":$('#canvas-svg').innerWidth() * 0.85
            }

            $('#count').text('총 참여자: ' + data[0]['Total'] + ' / 광화문 참여자: '+data[0]['HotPlace']);

            var width = config.width, height = config.height;

            var MAP_KEY = config.data0;
            var MAP_VALUE = config.data1;

            var projection = d3.geoMercator()
                    .scale((width + 1) / 2 / Math.PI)
                    .translate([width / 2, height / 2])
                    .precision(.1);

            var path = d3.geoPath().projection(projection);

            var graticule = d3.geoGraticule();

            $("#canvas-svg").empty();
            var svg = d3.select("#canvas-svg").append("svg")
                    .attr("width", width)
                    .attr("height", height);

                svg.append("path")
                    .datum(graticule)
                    .attr("class", "graticule")
                    .attr("d", path);

            var valueHash = {};

            data.forEach(function(d) {
                valueHash[d[MAP_KEY]] = +d[MAP_VALUE];
            });

            var quantize = d3.scaleLinear()
                .domain([1, d3.max(data, function(d){ return (+d[MAP_VALUE]) })])
                .range([config.color0, config.color1]);

            d3.json("/topo/world-min.json", function(error, world) {
                var countries = topojson.feature(world, world.objects.countries).features;

                svg.append("path")
                    .datum(graticule)
                    .attr("class", "choropleth")
                    .attr("d", path);

                var g = svg.append("g");

                g.append("path")
                    .datum({type: "LineString", coordinates: [[-180, 0], [-90, 0], [0, 0], [90, 0], [180, 0]]})
                    .attr("class", "equator")
                    .attr("d", path);

                var country = g.selectAll(".country").data(countries);

                country.enter().insert("path")
                    .attr("class", "country")
                    .attr("d", path)
                    .attr("id", function(d,i) { return d.id; })
                    .attr("title", function(d) { return d.properties.name; })
                    .style("fill", function(d) {
                        if (valueHash[d.properties.name]) {
                            var color = quantize((valueHash[d.properties.name]));
                            return color;
                        } else {
                            return "#ccc";
                        }
                    })
                    .on("mousemove", function(d) {
                        var html = "";

                        html += "<div class=\"tooltip_kv\">";
                        html += "<span class=\"tooltip_key\">";
                        html += d.properties.name;
                        html += "</span>";
                        html += "<span class=\"tooltip_value\">";
                        html += (valueHash[d.properties.name] ? valueFormat(valueHash[d.properties.name]) : "");
                        html += "";
                        html += "</span>";
                        html += "</div>";

                        $("#tooltip-container").html(html);
                        $(this).attr("fill-opacity", "0.8");
                        $("#tooltip-container").show();

                        var coordinates = d3.mouse(this);

                        var map_width = $('.choropleth')[0].getBoundingClientRect().width;

                        if (d3.event.pageX < map_width / 2) {
                            d3.select("#tooltip-container")
                                .style("top", (d3.event.layerY + 15) + "px")
                                .style("left", (d3.event.layerX + 15) + "px");
                        } else {
                            var tooltip_width = $("#tooltip-container").width();
                            d3.select("#tooltip-container")
                                .style("top", (d3.event.layerY + 15) + "px")
                                .style("left", (d3.event.layerX - tooltip_width - 30) + "px");
                        }
                    })
                    .on("mouseout", function() {
                        $(this).attr("fill-opacity", "1.0");
                        $("#tooltip-container").hide();
                    });

                g.append("path")
                    .datum(topojson.mesh(world, world.objects.countries, function(a, b) { return a !== b; }))
                    .attr("class", "boundary")
                    .attr("d", path);

                svg.attr("height", config.height * 2.2 / 3);
            });

            d3.select(self.frameElement).style("height", (height * 2.3 / 3) + "px");
        }
    });
});