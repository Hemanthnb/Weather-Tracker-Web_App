// Printing day 
// because in JS Date() Object returns array [0,1,2,3,4,5,6]

let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
let day = new Date().getDay();
let date = new Date().getDate();
let month = new Date().getMonth();
let year = new Date().getFullYear();
let date_day = document.getElementById('date');

//Setting day date month year

date_day.innerText = `${days[day]}   ${date}-${month}-${year}`;



function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';//converting Hours
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    let time = document.getElementById('time');
    time.innerText = `${hours}:${minutes} ${ampm.toUpperCase()}`;
}

// To make a clock dynamic: we use set interval
setInterval(() => {

    formatAMPM(new Date);
}, 1000);


if(navigator.geolocation)
{
    navigator.geolocation.getCurrentPosition(success,Error);//sucess and Error are functions
}
else{
    fetcher('bengaluru');
}


function success(pos)
{

    let lat=pos.coords.latitude;
    let lon=pos.coords.longitude;    
    fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=Metric&appid=5e69ec3f40f5b7eeb739aa9a6ffc8dbf`).then((response)=>
    {
        return response.json()
    }).then((data)=>
    {
        fetcher(data,'Your location');
    }).catch((Error)=>
    {
        alert('Network issue !');
    });

}

function Error()
{
    console.log("error");
}




function fetcher(data,cityname) {
    // console.log(cityname.charAt(0).toUpperCase() + cityname.slice(1));
    let cityname_capitalize = cityname.charAt(0).toUpperCase() + cityname.slice(1);
    
    // console.log(data);
    let cityname1 = document.getElementById('cityname');
    cityname1.innerText = `Weather in ${cityname_capitalize}`;
    let deg = document.getElementById('temp');
    deg.innerText = `${data.main.temp} ° C`;
    let icon = document.getElementById('icon');
            icon.src = `http://openweathermap.org/img/wn/${data.weather[0].icon}.png`;
            let descrp = document.getElementById('desp');
            let description_text=data.weather[0].description;
            
            description_text=description_text[0].toUpperCase()+description_text.slice(1);
            descrp.innerText = description_text;
            let humid = document.getElementById('humidity');
            humid.innerText = `Humidity : ${data.main.humidity}%`;
            let pressure = document.getElementById('Pressure');
            pressure.innerText = `Pressure : ${data.main.pressure} hpa`
            let windspeed = document.getElementById('Windspeed');
            // console.log(windspeed)
            windspeed.innerText = `WindSpeed : ${(data.wind.speed * 3.6).toFixed(2)}kmph`;
        }


// let apikey = '5e69ec3f40f5b7eeb739aa9a6ffc8dbf';

// let icon = ' http://openweathermap.org/img/wn/10d';
let btn = document.getElementById('search_btn');
// alert("Give Access to your current location");
// let cityname='bengaluru';

btn.addEventListener('click', () => {
    let cityname = document.getElementById('cityinput').value;
    // console.log(cityname);
    if (cityname == '') {
        alert('Wrong Input');
    }
    else {
        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${cityname}&units=Metric&appid=5e69ec3f40f5b7eeb739aa9a6ffc8dbf`).then((response) => {
            return response.json();
        }).then((data) => {
            fetcher(data,cityname);
            baby_fetcher(cityname);
            // document.getElementById('cityinput').value='';

        }).catch((Error)=>
        {
            alert('Invalid Input');
        });
    }
});
        
        
        
        
        // let cityname=document.getElementById('cityinput').value;
        // document.getElementById('cityinput').value='';
        function baby_fetcher(cityname)
        {
            console.log(cityname);
        fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${cityname}&units=Metric&appid=5e69ec3f40f5b7eeb739aa9a6ffc8dbf`).then((response)=>
        {
            return response.json();
        }).then((data)=>
        {
            let str='';
            for(let i=1;i<5;i++)
                {
                    str+=` <div class="container21">
                    
                    <img src="${`http://openweathermap.org/img/wn/${data.list[i*7].weather[0].icon}.png`}" alt="Loading" class="baby_icon">
                    <p class="baby">${data.list[i*7].main.temp} ° C</p>
                    <p class="baby">${data.list[i*7].weather[0].description}</p>
                    <p class="baby">Max_temp : ${data.list[i*7].main.temp_max}</p>
                    <p class='baby'>Day ${i}</p>
                    </div>`
                    // console.log(data.list[7*i].main.temp);
                    
                }


                document.getElementById('maincontainer').innerHTML=str;
            }).catch((Error)=>
            {
                alert(Error);
            });

        }
            let section=document.getElementById('babyTemp');
            section.style.display='none';
            let showmore=document.getElementById('showmore');
            showmore.addEventListener('click',()=>
            {
                // if(document.getElementById('cityinput').value=='')
                // {
                //     alert('enter City Name');
                // }
                 if (section.style.display=='none')
                {
                    document.getElementById('cityinput').value='';
                    section.style.display='block';
                    showmore.innerText="Show Less";
                    
                }
                else{
                    
                    section.style.display='none';
                    showmore.innerText="Show more";
                }
            });