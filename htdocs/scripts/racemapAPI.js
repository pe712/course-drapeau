

$.get("https://racemap.com/api/data/v1/6336f41309be310001a5894b/distance", function(data){
    var balises = data.starters.slice(0,2);
    var currents = [];
    balises.forEach(balise => {
        currents.push(balise.current);
    });
    console.log(currents)
})

