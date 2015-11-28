var diameter = 960,
  format = d3.format(",d"),
  color = d3.scale.category20c();

var bubble = d3.layout.pack()
  .sort(null)
  .size([diameter, diameter])
  .padding(1.5);

var svg = d3.select("body").append("svg")
  .attr("width", diameter)
  .attr("height", diameter)
  .attr("class", "bubble");


d3.json(
  "http://kassembly.xyz/circle.json",
  function(error, root) {
    //d3.json("all.json", function(error, root) {
    //d3.json("http://api.kassembly.xyz/q.php/order", function(error, root) {
    if (error) throw error;

    var node = svg.selectAll(".node")
      .data(bubble.nodes(classes(root))
        .filter(function(d) {
          return !d.children;
        }))
      .enter().append("g")
      .attr("class", "node")
      .attr("transform", function(d) {
        return "translate(" + d.x + "," + d.y + ")";
      });

    node.append("title")
      .text(function(d) {
        return d.info + ": " + format(d.count);
      });

    node.append("circle")
      .attr("r", function(d) {
        return d.r;
      })
      .style("fill", function(d) {
        return color(d.packageName);
      });

    //http://stackoverflow.com/questions/13104681/hyperlinks-in-d3-js-objects

    node.append("text")
      .attr("dy", ".3em")
      .style("text-anchor", "middle")
      //  .on("click", function(d) { alert("hello" + d.id); })
      .text(function(d) {
        return d.className.substring(0, d.r / 3);
      });

    node.on("click", function(d) {
      var url = location.href; //Save down the URL without hash.
      window.top.location.href = "in.html#/" + d.id;
    });
  });

// Returns a flattened hierarchy containing all leaf nodes under the root.
function classes(root) {
  var classes = [];

  function recurse(name, node) {
    if (node.children) node.children.forEach(function(child) {
      recurse(node.name, child);
    });
    else classes.push({
      packageName: name,
      className: node.name,
      count: node.c,
      value: node.value,
      id: node.id,
      info: node.info
    });
  }

  recurse(null, root);
  return {
    children: classes
  };
}

d3.select(self.frameElement).style("height", diameter + "px");
