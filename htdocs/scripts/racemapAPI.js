
var real_event_id = "637b302d387e3800013d3044";
var event_id = "6336f41309be310001a5894b";
$.get("https://racemap.com/api/data/v1/"+event_id+"/current", function(data){
    data.starters.forEach(balise => {
        var current = balise.current;
        if (current!=null){
            var lat = current.lat;
            var lon = current.lng;
            var distance = current.fromStart;
            create_marker(lat, lon);
            update_counter(distance);
        }
    });
})

function create_marker(lat, lon) {
    console.log(lat, lon);
  }

  function update_counter(distance){
    console.log(distance);
  }


