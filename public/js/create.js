document.getElementById('country').addEventListener('change', function(){
    var city = document.getElementById('city');
    var html='';
    $.get('/ajax/'+this.value, function(res){ 
        console.log(res); 
        res.forEach(function(r){
            console.log(r.id);
            html+=`<option value="${r.id}">${r.city_name}</option>`;
        });
    city.innerHTML = html;

    });
});